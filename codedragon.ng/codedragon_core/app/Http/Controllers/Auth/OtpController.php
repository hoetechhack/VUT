<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class OtpController extends Controller
{
    public function show()
    {
        if (!session('otp_user_id')) {
            return redirect()->route('login');
        }
        return view('auth.verify-otp');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = User::find(session('otp_user_id'));

        if (!$user || $user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Invalid or expired code.']);
        }

        // OTP is valid
        $user->update([
            'otp' => null, 
            'otp_expires_at' => null,
            'is_verified' => true
        ]);
        
        Auth::login($user);
        $request->session()->forget('otp_user_id');

        return redirect()->intended(route('dashboard', absolute: false));
    }

    public function resend(Request $request)
    {
        if (!session('otp_user_id')) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }

        $user = User::find(session('otp_user_id'));
        if (!$user) {
            return response()->json(['message' => 'User not found'], 404);
        }

        // Generate fresh OTP
        $otp = rand(100000, 999999);
        $user->update([
            'otp' => $otp,
            'otp_expires_at' => now()->addMinutes(10),
        ]);

        /*
        // Send Mail
        \Illuminate\Support\Facades\Mail::raw("Your New CandyTech Verification Code is: {$otp}. It expires in 10 minutes.", function ($message) use ($user) {
            $message->to($user->email)
                    ->subject('New Verification Code - CandyTech');
        });
        */

        return back()->with('status', 'A fresh verification code has been sent to your email.');
    }
}
