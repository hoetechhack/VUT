<?php

namespace App\Console\Commands;

use Illuminate\Console\Attributes\Description;
use Illuminate\Console\Attributes\Signature;
use Illuminate\Console\Command;

class MonitorVTPassBalance extends Command
{
    protected $signature = 'vtpass:monitor-balance';
    protected $description = 'Monitors VTPass balance and automatically tops it up from Monnify if it falls below the threshold.';

    public function handle()
    {
        $vtpass = new \App\Services\VTPassService();
        $monnify = new \App\Services\MonnifyService();

        $threshold = \App\Models\Setting::where('key', 'vtpass_auto_fund_threshold')->value('value');
        $topUpAmount = \App\Models\Setting::where('key', 'vtpass_auto_fund_amount')->value('value');
        $bankCode = \App\Models\Setting::where('key', 'vtpass_funding_bank_code')->value('value');
        $accountNumber = \App\Models\Setting::where('key', 'vtpass_funding_account_number')->value('value');

        if (!$threshold || !$topUpAmount || !$bankCode || !$accountNumber) {
            $this->warn('Auto-Top-Up is not fully configured in settings. Skipping.');
            return;
        }

        $vBalResponse = $vtpass->getBalance();
        if (!$vBalResponse['success']) {
            $this->error('Failed to fetch VTPass balance.');
            return;
        }

        $currentBalance = $vBalResponse['balance'];
        
        if ($currentBalance < $threshold) {
            $this->info("VTPass balance (₦$currentBalance) is below threshold (₦$threshold). Initiating auto-top-up of ₦$topUpAmount...");

            $reference = 'VTP-AUTO-' . time();
            $result = $monnify->disburse(
                $topUpAmount,
                $bankCode,
                $accountNumber,
                'Auto VTPass Wallet Funding',
                $reference
            );

            if ($result['success']) {
                $this->info("Successfully disbursed ₦$topUpAmount to VTPass.");
                \Illuminate\Support\Facades\Log::info("Auto-Top-Up: Disbursed ₦$topUpAmount to VTPass.");
            } else {
                $this->error("Failed to disburse: " . ($result['message'] ?? 'Unknown error'));
                \Illuminate\Support\Facades\Log::error("Auto-Top-Up Failed: " . ($result['message'] ?? 'Unknown error'));
            }
        } else {
            $this->info("VTPass balance (₦$currentBalance) is above threshold (₦$threshold). No action needed.");
        }
    }
}
