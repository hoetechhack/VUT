<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Services\Google2FA;

class SecurityController extends Controller
{
    // Show 2FA Setup Page in Dashboard
    public function index()
    {
        $user = Auth::user();
        
        $qrCodeUrl = null;
        
        if (!$user->two_factor_enabled) {
            if (empty($user->two_factor_secret)) {
                $user->two_factor_secret = Google2FA::generateSecretKey();
                $user->save();
            }
            $qrCodeUrl = Google2FA::getQRCodeUrl('CandyTech', $user->email, $user->two_factor_secret);
        }

        return view('profile.security', compact('user', 'qrCodeUrl'));
    }

    // Enable 2FA
    public function enable(Request $request)
    {
        $request->validate(['code' => 'required|numeric|digits:6']);
        $user = Auth::user();

        $isValid = Google2FA::verifyKey($user->two_factor_secret, $request->code);

        if ($isValid) {
            $user->two_factor_enabled = true;
            $user->save();
            return back()->with('status', 'Two-Factor Authentication successfully enabled!');
        }

        return back()->withErrors(['code' => 'Invalid Authenticator Code.']);
    }

    // Disable 2FA
    public function disable(Request $request)
    {
        $request->validate(['password' => 'required']);
        $user = Auth::user();

        if (Hash::check($request->password, $user->password)) {
            $user->two_factor_enabled = false;
            $user->two_factor_secret = null; // Reset secret
            $user->save();
            return back()->with('status', 'Two-Factor Authentication disabled.');
        }

        return back()->withErrors(['password' => 'Incorrect password.']);
    }

    // Show Login Verification Form
    public function showVerifyForm()
    {
        if (!session('2fa:user:id')) {
            return redirect()->route('login');
        }
        return view('auth.2fa-verify');
    }

    // Verify OTP during Login
    public function verifyLogin(Request $request)
    {
        $request->validate(['code' => 'required|numeric|digits:6']);
        
        $userId = session('2fa:user:id');
        if (!$userId) return redirect()->route('login');

        $user = \App\Models\User::find($userId);

        if (Google2FA::verifyKey($user->two_factor_secret, $request->code)) {
            // Login success
            session()->forget('2fa:user:id');
            Auth::login($user, session('2fa:user:remember', false));
            session()->forget('2fa:user:remember');
            
            return redirect()->intended(route('dashboard'));
        }

        return back()->withErrors(['code' => 'Invalid Authenticator Code.']);
    }
}
