<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Http\Requests\Auth\LoginRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\View\View;

class AuthenticatedSessionController extends Controller
{
    /**
     * Display the login view.
     */
    public function create(): View
    {
        return view('auth.login');
    }

    /**
     * Handle an incoming authentication request.
     */
    public function store(LoginRequest $request): RedirectResponse
    {
        $request->authenticate();
        
        $user = Auth::user();

        // 2FA Intercept
        if ($user->two_factor_enabled) {
            Auth::logout();
            $request->session()->put('2fa:user:id', $user->id);
            $request->session()->put('2fa:user:remember', $request->boolean('remember'));
            return redirect()->route('security.2fa.verify');
        }

        // Check if OTP is needed:
        // 1. Every time for Admins
        // 2. First time for normal users (if not verified)
        /* TEMPORARILY DISABLED OTP DUE TO EMAIL ISSUES
        if ($user->is_admin || !$user->is_verified) {
            $otp = rand(100000, 999999);
            $user->update([
                'otp' => $otp,
                'otp_expires_at' => now()->addMinutes(10)
            ]);
            
            Auth::logout();
            $request->session()->put('otp_user_id', $user->id);

            // try {
            //     \Illuminate\Support\Facades\Mail::raw("Your CandyTech Verification Code is: {$otp}. It expires in 10 minutes.", function ($message) use ($user) {
            //         $message->to($user->email)->subject('CandyTech Verification Code');
            //     });
            // } catch (\Exception $e) {
            //     // If mail fails, we still redirect to OTP page
            // }

            return redirect()->route('otp.show');
        }
        */

        // Auto verify user since OTP is disabled
        if (!$user->is_verified) {
            $user->update(['is_verified' => true]);
        }


        $request->session()->regenerate();

        return redirect()->intended(route('dashboard', absolute: false));
    }

    /**
     * Destroy an authenticated session.
     */
    public function destroy(Request $request): RedirectResponse
    {
        Auth::guard('web')->logout();

        $request->session()->invalidate();

        $request->session()->regenerateToken();

        return redirect('/');
    }
}
