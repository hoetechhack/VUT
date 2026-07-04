<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class PinController extends Controller
{
    public function show()
    {
        return view('auth.set-pin');
    }

    public function store(Request $request)
    {
        $request->validate([
            'pin' => 'required|digits:4|confirmed',
        ]);

        $request->user()->update([
            'transaction_pin' => Hash::make($request->pin),
        ]);

        return redirect()->route('dashboard')->with('status', 'Transaction PIN set successfully!');
    }
}
