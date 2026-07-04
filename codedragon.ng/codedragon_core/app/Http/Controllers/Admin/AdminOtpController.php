<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class AdminOtpController extends Controller
{
    public function show()
    {
        if (!session('admin_otp_id')) {
            return redirect()->route('login');
        }
        return view('admin.otp');
    }

    public function verify(Request $request)
    {
        $request->validate(['otp' => 'required|numeric']);

        $user = User::find(session('admin_otp_id'));

        if (!$user || $user->otp !== $request->otp || now()->greaterThan($user->otp_expires_at)) {
            return back()->withErrors(['otp' => 'Invalid or expired OTP.']);
        }

        // OTP is valid
        $user->update(['otp' => null, 'otp_expires_at' => null]);
        Auth::login($user);
        session()->forget('admin_otp_id');

        return redirect()->route('admin.settings');
    }
}
