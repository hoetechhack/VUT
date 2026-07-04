<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\AutoSubscription;
use App\Services\VTPassService;
use App\Services\WhatsAppService;
use Illuminate\Support\Facades\Log;

class ProcessAutoSubscriptions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'subscriptions:process';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Process recurring auto-subscriptions (Airtime, Data, etc.)';

    /**
     * Execute the console command.
     */
    public function handle(VTPassService $vtpass, WhatsAppService $whatsApp)
    {
        $this->info('Starting Auto-Subscription processing...');

        $subscriptions = AutoSubscription::where('status', 'active')
            ->where('next_run_at', '<=', now())
            ->get();

        foreach ($subscriptions as $sub) {
            $user = $sub->user;
            if (!$user) continue;

            // Check if subscription has expired by date
            if ($sub->end_at && $sub->end_at->isPast()) {
                $sub->update(['status' => 'completed']);
                continue;
            }

            // Check if subscription has reached max runs
            if ($sub->max_runs > 0 && $sub->current_runs >= $sub->max_runs) {
                $sub->update(['status' => 'completed']);
                continue;
            }

            $this->info("Processing subscription #{$sub->id} for user {$user->name}");

            // Atomic check for balance
            if ($user->wallet->balance < $sub->amount) {
                $this->handleFailure($sub, "Insufficient wallet balance", $whatsApp);
                continue;
            }

            $requestId = date('YmdHi') . uniqid();
            
            $result = $vtpass->purchase(
                $sub->service_id,
                $sub->variation_code,
                $sub->amount,
                $sub->phone_number,
                $requestId
            );

            if ($result['success']) {
                $user->wallet->decrement('balance', $sub->amount);
                $user->transactions()->create([
                    'user_id' => $user->id,
                    'reference' => $requestId,
                    'type' => $sub->service_id,
                    'amount' => $sub->amount,
                    'status' => 'success',
                    'details' => json_encode($result['data'])
                ]);

                // Update runs and next run time
                $nextRun = now()->addDays($sub->frequency_days);
                
                $sub->increment('current_runs');
                $sub->update([
                    'next_run_at' => $nextRun,
                    'last_run_at' => now()
                ]);

                // Check if this was the last run
                if ($sub->max_runs > 0 && $sub->current_runs >= $sub->max_runs) {
                    $sub->update(['status' => 'completed']);
                    $whatsApp->sendMessage($user->phone, "✅ *Subscription Completed!*\n\nYour recurring payment for *" . strtoupper($sub->service_id) . "* has completed all *" . $sub->max_runs . "* scheduled runs.");
                } else {
                    $whatsApp->sendMessage($user->phone, "🔄 *Auto-Renewal Successful!*\n\nYour subscription for *" . strtoupper($sub->service_id) . "* has been renewed.\nAmount: *₦" . number_format($sub->amount, 2) . "*\nNext Renewal: *" . $nextRun->format('d M Y') . "*");
                }
                
                $this->info("Subscription #{$sub->id} renewed successfully.");
            } else {
                $this->handleFailure($sub, $result['message'], $whatsApp);
            }
        }

        $this->info('Auto-Subscription processing complete.');
    }

    protected function handleFailure($sub, $reason, $whatsApp)
    {
        $user = $sub->user;
        Log::warning("Auto-Subscription Failed for #{$sub->id}: {$reason}");
        
        if ($user && $user->phone) {
            $whatsApp->sendMessage($user->phone, "⚠️ *Auto-Renewal Failed!*\n\nYour subscription for *" . strtoupper($sub->service_id) . "* could not be renewed.\nReason: *" . $reason . "*\n\nPlease fund your wallet or check your settings to avoid service interruption.");
        }
        
        // We update the next_run_at to try again tomorrow even on failure, 
        // or we could pause it. For now, let's just move it by 1 day to retry.
        $sub->update([
            'next_run_at' => now()->addDay()
        ]);
    }
}
