<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Setting;

class AdminSettingsController extends Controller
{
    public function index()
    {
        $settings = Setting::pluck('value', 'key')->toArray();
        
        $monnifyBalance = null;
        $vtpassBalance = null;

        if (auth()->user()->email === 'info@candytech.ng') {
            $monnifyService = new \App\Services\MonnifyService();
            $vtpassService = new \App\Services\VTPassService();
            
            $mBal = $monnifyService->getWalletBalance();
            $monnifyBalance = $mBal['success'] ? $mBal['availableBalance'] : 'Error: ' . ($mBal['message'] ?? 'Failed');

            $vBal = $vtpassService->getBalance();
            $vtpassBalance = $vBal['success'] ? $vBal['balance'] : 'Error: ' . ($vBal['message'] ?? 'Failed');
        }

        return view('admin.settings', compact('settings', 'monnifyBalance', 'vtpassBalance'));
    }

    public function store(Request $request)
    {
        $data = $request->except('_token');
        
        foreach ($data as $key => $value) {
            Setting::updateOrCreate(['key' => $key], ['value' => $value]);
        }

        return redirect()->back()->with('status', 'Settings updated successfully!');
    }

    public function fundVTPass(Request $request)
    {
        $request->validate(['amount' => 'required|numeric|min:100']);

        $bankCode = Setting::where('key', 'vtpass_funding_bank_code')->value('value');
        $accountNumber = Setting::where('key', 'vtpass_funding_account_number')->value('value');

        if (!$bankCode || !$accountNumber) {
            return back()->with('status', 'Error: VTPass Bank Code or Account Number is not configured in settings.');
        }

        $monnify = new \App\Services\MonnifyService();
        $reference = 'VTP-FUND-' . time();
        
        $result = $monnify->disburse(
            $request->amount,
            $bankCode,
            $accountNumber,
            'Manual VTPass Wallet Funding',
            $reference
        );

        if ($result['success']) {
            return back()->with('status', 'Transfer initiated successfully! Monnify is sending ' . number_format($request->amount, 2) . ' to VTPass.');
        }

        return back()->with('status', 'Transfer failed: ' . ($result['message'] ?? 'Unknown error.'));
    }
}
