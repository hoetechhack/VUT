<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Services\VTPassService;
use App\Models\Setting;
use Illuminate\Support\Facades\Auth;

class PurchaseController extends Controller
{
    public function getVariations($serviceID)
    {
        $variations = \App\Models\ServiceVariation::where('service_id', $serviceID)
            ->where('is_active', true)
            ->get();

        return response()->json($variations);
    }

    public function buy(Request $request, VTPassService $vtpass)
    {
        $request->validate([
            'serviceID' => 'required',
            'variation_code' => 'required',
            'phone' => 'required|numeric|digits:11',
            'amount' => 'required|numeric',
            'pin' => 'required|numeric|digits:4',
            'billersCode' => 'nullable|string'
        ]);

        $user = Auth::user();

        // Security: Validate price against our local DB if it's a fixed variation
        $variation = \App\Models\ServiceVariation::where('service_id', $request->serviceID)
            ->where('variation_code', $request->variation_code)
            ->first();
        
        $finalAmount = $request->amount;
        if ($request->variation_code !== 'airtime' && $variation) {
            $price = $variation->retail_price > 0 ? $variation->retail_price : $variation->wholesale_price;
            // Only override if the variation has a fixed non-zero price in DB
            if ($price > 0) {
                $finalAmount = $price;
            }
        }

        if ($user->transaction_pin !== $request->pin) {
            return back()->withErrors(['pin' => 'Incorrect Transaction PIN.']);
        }

        if ($user->wallet->balance < $finalAmount) {
            return back()->withErrors(['amount' => 'Insufficient wallet balance.']);
        }

        $requestId = date('YmdHi') . \Illuminate\Support\Str::random(10);
        
        $result = $vtpass->purchase(
            $request->serviceID,
            $request->variation_code,
            $finalAmount, 
            $request->phone,
            $requestId,
            $request->billersCode
        );

        if ($result['success']) {
            $user->wallet->decrement('balance', $finalAmount);
            $user->transactions()->create([
                'reference' => $requestId,
                'type' => $request->serviceID,
                'amount' => $finalAmount,
                'status' => 'success',
                'details' => json_encode($result['data'])
            ]);

            // Advanced Auto-Subscription Logic
            if ($request->has('recurring') && $request->recurring == 'on') {
                $days = (int)$request->frequency_days ?: 30;
                $maxRuns = (int)$request->max_runs ?: null;
                $endAt = $request->end_at ? \Illuminate\Support\Carbon::parse($request->end_at) : null;

                \App\Models\AutoSubscription::create([
                    'user_id' => $user->id,
                    'service_id' => $request->serviceID,
                    'variation_code' => $request->variation_code,
                    'amount' => $finalAmount,
                    'phone_number' => $request->phone,
                    'frequency_days' => $days,
                    'max_runs' => $maxRuns,
                    'end_at' => $endAt,
                    'next_run_at' => now()->addDays($days),
                    'status' => 'active'
                ]);
            }

            // Extract token for UI display
            $data = $result['data'];
            $token = $data['mainToken'] ?? $data['purchased_code'] ?? $data['token'] ?? ($data['content']['token'] ?? ($data['content']['purchased_code'] ?? null));

            // WhatsApp Notification for PIN/Token
            if ($user->receive_whatsapp_notifications) {
                try {
                    $whatsApp = new \App\Services\WhatsAppService();
                    if ($token) {
                        $whatsApp->sendMessage($user->phone, "🎫 *Your Purchase was Successful!*\n\nService: *" . strtoupper($request->serviceID) . "*\nToken/PIN: *" . $token . "*\n\nThank you for choosing CandyTech!");
                    } else {
                        $whatsApp->sendMessage($user->phone, "✅ *Purchase Successful!*\n\nService: *" . strtoupper($request->serviceID) . "*\nAmount: *₦" . number_format($request->amount, 2) . "*\n\nYour transaction was successful. Thank you!");
                    }
                } catch (\Exception $e) {
                    \Illuminate\Support\Facades\Log::error("WhatsApp Purchase Notification Failed: " . $e->getMessage());
                }
            }

            if ($request->ajax() || $request->wantsJson()) {
                return response()->json([
                    'success' => true, 
                    'message' => 'Purchase successful!',
                    'new_balance' => number_format(auth()->user()->wallet->balance, 2),
                    'token' => $token
                ]);
            }
            return back()->with('status', 'Purchase successful!');
        }

        $errorMsg = '❌ ' . ($result['message'] ?? 'Purchase failed');
        if ($request->ajax() || $request->wantsJson()) {
            return response()->json(['success' => false, 'message' => $errorMsg]);
        }
        return back()->withErrors(['amount' => $errorMsg]);
    }

    public function validateBiller(Request $request, VTPassService $vtpass)
    {
        $request->validate([
            'serviceID' => 'required',
            'billersCode' => 'required',
            'type' => 'nullable'
        ]);

        return response()->json($vtpass->verifyAccount($request->serviceID, $request->billersCode, $request->type));
    }

    public function cancelSubscription(\App\Models\AutoSubscription $sub)
    {
        if ($sub->user_id !== Auth::id()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized action.']);
        }

        $sub->update(['status' => 'cancelled']);

        return response()->json(['success' => true, 'message' => 'Subscription cancelled successfully.']);
    }
}
