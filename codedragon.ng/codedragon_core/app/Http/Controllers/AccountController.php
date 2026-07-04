<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

use App\Services\MonnifyService;

class AccountController extends Controller
{
    public function updateProfile(Request $request)
    {
        $user = Auth::user();

        $request->validate([
            'name' => 'required|string|max:255',
            'transaction_pin' => 'nullable|numeric|digits:4',
        ]);

        $data = [
            'name' => $request->name,
        ];

        if ($request->filled('transaction_pin')) {
            $data['transaction_pin'] = $request->transaction_pin;
        }

        $user->update($data);

        return back()->with('status', 'Profile updated successfully.');
    }

    public function verifyBvn(Request $request, MonnifyService $monnify)
    {
        $request->validate(['bvn' => 'required|numeric|digits:11']);
        $user = Auth::user();

        if ($user->bvn_verified_at) {
            return back()->withErrors(['bvn' => 'BVN already verified.']);
        }

        $result = $monnify->verifyBvn($request->bvn);

        if ($result['success']) {
            $user->update([
                'bvn' => $request->bvn,
                'bvn_verified_at' => now(),
                'is_verified' => true // Auto-verify account when BVN is valid
            ]);
            return back()->with('status', 'BVN Verified successfully! Your account is now active.');
        }

        return back()->withErrors(['bvn' => $result['message']]);
    }
    public function withdraw(Request $request, MonnifyService $monnify)
    {
        $request->validate([
            'amount' => 'required|numeric|min:100',
            'bank_code' => 'required|string',
            'account_number' => 'required|numeric|digits:10',
            'pin' => 'required|numeric|digits:4'
        ]);

        $user = Auth::user();

        if ($user->transaction_pin !== $request->pin) {
            return back()->withErrors(['pin' => 'Incorrect Transaction PIN.']);
        }

        if ($user->wallet->balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient wallet balance.']);
        }

        $reference = 'WDR-' . uniqid();
        
        $result = $monnify->disburse(
            $request->amount,
            $request->bank_code,
            $request->account_number,
            'Withdrawal from CandyTech',
            $reference
        );

        if ($result['success']) {
            $user->wallet->decrement('balance', $request->amount);
            $user->transactions()->create([
                'reference' => $reference,
                'type' => 'withdrawal',
                'amount' => $request->amount,
                'status' => 'success'
            ]);
            return back()->with('status', 'Withdrawal successful! The money has been sent to your bank.');
        }

        return back()->withErrors(['amount' => $result['message']]);
    }
    public function requestPinChange(Request $request)
    {
        $request->validate([
            'current_password' => 'required',
            'new_pin' => 'required|numeric|digits:4|confirmed',
        ]);

        $user = Auth::user();

        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'Incorrect account password.']);
        }

        $user->update([
            'transaction_pin' => $request->new_pin
        ]);

        return back()->with('status', 'Transaction PIN updated successfully!');
    }

    public function validateAccount(Request $request, MonnifyService $monnify)
    {
        $request->validate([
            'account_number' => 'required|numeric|digits:10',
            'bank_code' => 'required|string'
        ]);

        return response()->json($monnify->validateAccount($request->account_number, $request->bank_code));
    }

    public function getBalance()
    {
        return response()->json([
            'balance' => number_format(Auth::user()->wallet->balance ?? 0, 2),
            'raw_balance' => Auth::user()->wallet->balance ?? 0
        ]);
    }

    public function getTransactions()
    {
        $txs = Auth::user()->transactions()->latest()->take(10)->get()->map(function($tx) {
            return [
                'type' => ucfirst($tx->type),
                'reference' => $tx->reference,
                'amount' => number_format($tx->amount, 2),
                'status' => $tx->status,
                'date' => $tx->created_at->format('M d, h:i A'),
                'icon' => ($tx->type == 'funding' ? '💰' : ($tx->type == 'withdrawal' ? '🏧' : '🛒'))
            ];
        });
        return response()->json($txs);
    }
}
