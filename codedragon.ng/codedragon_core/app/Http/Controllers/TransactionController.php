<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Transaction;
use App\Models\Wallet;
use App\Services\VTPassService;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class TransactionController extends Controller
{
    protected $vtpass;

    public function __construct(VTPassService $vtpass)
    {
        $this->vtpass = $vtpass;
    }

    public function purchase(Request $request)
    {
        $request->validate([
            'type' => 'required|in:airtime,data,electricity,cable',
            'amount' => 'required|numeric|min:50',
            'phone' => 'required|string',
            'network' => 'required_if:type,airtime,data|string',
            'pin' => 'required|digits:4'
        ]);

        $user = Auth::user();

        // 1. Verify Transaction PIN
        if (!$user->transaction_pin || !Hash::check($request->pin, $user->transaction_pin)) {
            return back()->withErrors(['pin' => 'Invalid Transaction PIN.']);
        }

        try {
            DB::transaction(function () use ($request, $user) {
                // 2. Lock wallet for update to prevent double spending
                $wallet = Wallet::where('user_id', $user->id)->lockForUpdate()->firstOrFail();

                if ($wallet->balance < $request->amount) {
                    throw new \Exception('Insufficient wallet balance.');
                }

                // 3. Deduct Wallet
                $balanceBefore = $wallet->balance;
                $wallet->decrement('balance', $request->amount);
                $balanceAfter = $wallet->fresh()->balance;

                // 4. Record Pending Transaction
                $tx = Transaction::create([
                    'user_id' => $user->id,
                    'reference' => 'CT-' . strtoupper(Str::random(12)),
                    'type' => $request->type,
                    'amount' => $request->amount,
                    'status' => 'success', // Auto success for airtime in this flow as per the result check below
                    'details' => json_encode([
                        'description' => "Purchased {$request->type} for {$request->phone}",
                        'wallet_before' => $balanceBefore,
                        'wallet_after' => $balanceAfter,
                        'request_data' => $request->except(['pin', '_token'])
                    ])
                ]);

                // 5. Call API
                if ($request->type === 'airtime') {
                    $apiResponse = $this->vtpass->purchaseAirtime($request->phone, $request->network, $request->amount);
                } else {
                    // Logic for other types would go here
                    throw new \Exception('Only Airtime is fully wired in this sandbox test.');
                }

                // 6. Handle API Response
                if (isset($apiResponse['code']) && $apiResponse['code'] === '000') {
                    $tx->update([
                        'status' => 'success',
                        'api_reference' => $apiResponse['requestId'] ?? null
                    ]);

                    // Check for referral commission on first successful transaction
                    $this->processReferralBonus($user);
                } else {
                    throw new \Exception('API Provider Failed: ' . ($apiResponse['response_description'] ?? 'Unknown Error'));
                }
            });

            return back()->with('status', 'Transaction successful!');

        } catch (\Exception $e) {
            return back()->withErrors(['error' => $e->getMessage()]);
        }
    }

    protected function processReferralBonus($user)
    {
        // Only credit referrer if this is the user's FIRST successful transaction
        $successfulTxCount = Transaction::where('user_id', $user->id)->where('status', 'success')->count();
        
        if ($successfulTxCount === 1 && $user->referred_by) {
            $referrerWallet = Wallet::where('user_id', $user->referred_by)->first();
            $commission = \App\Models\Setting::where('key', 'referral_commission')->value('value') ?: 0;
            
            if ($referrerWallet && $commission > 0) {
                $referrerWallet->increment('balance', $commission);
                
                // Record referral bonus transaction for referrer
                Transaction::create([
                    'user_id' => $user->referred_by,
                    'reference' => 'REF-' . strtoupper(Str::random(12)),
                    'type' => 'referral_bonus',
                    'amount' => $commission,
                    'status' => 'success',
                    'details' => json_encode([
                        'description' => "Referral bonus for inviting {$user->name}",
                        'wallet_before' => $referrerWallet->balance - $commission,
                        'wallet_after' => $referrerWallet->balance,
                    ])
                ]);
            }
        }
    }
}
