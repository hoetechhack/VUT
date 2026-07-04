<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AirtimeToCash;
use App\Models\Setting;
use Illuminate\Support\Facades\Hash;

class AirtimeToCashController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'network' => 'required|string',
            'phone' => 'required|string|min:11|max:11',
            'amount' => 'required|numeric|min:1000',
            'pin' => 'required|string|min:4|max:4',
        ]);

        $user = auth()->user();

        // Verify PIN
        if (!Hash::check($request->pin, $user->transaction_pin)) {
            return back()->withErrors(['pin' => 'Invalid transaction PIN.']);
        }

        // Calculate receiving amount based on commission
        $commission = Setting::where('key', 'airtime_to_cash_commission')->value('value') ?? 20;
        // Or per-network commission if you want to be fancy.
        // Let's use the one from the form if we want, or a fixed one.
        // The form has: mtn 15, airtel 20, glo 25, 9mobile 25.
        $rates = [
            'mtn' => 15,
            'airtel' => 20,
            'glo' => 25,
            '9mobile' => 25
        ];
        $rate = $rates[$request->network] ?? $commission;
        
        $receiveAmount = $request->amount - ($request->amount * ($rate / 100));

        AirtimeToCash::create([
            'user_id' => $user->id,
            'network' => $request->network,
            'phone' => $request->phone,
            'amount' => $request->amount,
            'receive_amount' => $receiveAmount,
            'reference' => 'ATC-' . strtoupper(bin2hex(random_bytes(4))),
            'status' => 'pending',
        ]);

        return redirect()->route('dashboard')->with('status', 'Your conversion request has been submitted. Please transfer the airtime to the designated number.');
    }
}
