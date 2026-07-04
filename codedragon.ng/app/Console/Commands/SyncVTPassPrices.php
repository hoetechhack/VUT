<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Services\VTPassService;
use App\Models\ServiceVariation;
use Illuminate\Support\Facades\Log;

class SyncVTPassPrices extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'vtpass:sync-prices';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Fetch and sync wholesale prices from VTPass into the local database.';

    /**
     * Execute the console command.
     */
    public function handle(VTPassService $vtpass)
    {
        $this->info('Starting VTPass Price Sync...');

        $servicesToSync = [
            'mtn-data',
            'airtel-data',
            'glo-data',
            'etisalat-data',
            'smile-direct',
            'spectranet',
            'dstv',
            'gotv',
            'startimes',
            'showmax',
            'abuja-electric',
            'eko-electric',
            'ikeja-electric',
            'enugu-electric',
            'ibadan-electric',
            'jos-electric',
            'kano-electric',
            'port-harcourt-electric',
            'waec',
            'waec-registration',
            'neco',
            'jamb'
        ];

        foreach ($servicesToSync as $serviceId) {
            $this->info("Fetching variations for {$serviceId}...");
            $variations = $vtpass->getVariationCodes($serviceId);

            if (!empty($variations)) {
                foreach ($variations as $var) {
                    $category = null;
                    $lowerName = strtolower($var['name']);
                    if (str_contains($lowerName, '24 hrs') || str_contains($lowerName, '1 day') || str_contains($lowerName, 'daily')) {
                        $category = 'daily';
                    } elseif (str_contains($lowerName, '7 days') || str_contains($lowerName, 'week')) {
                        $category = 'weekly';
                    } elseif (str_contains($lowerName, '30 days') || str_contains($lowerName, 'month')) {
                        $category = 'monthly';
                    }

                    $variation = ServiceVariation::firstOrNew([
                        'service_id' => $serviceId,
                        'variation_code' => $var['variation_code']
                    ]);

                    $variation->name = $var['name'];
                    $variation->wholesale_price = $var['variation_amount'];
                    
                    // Auto-categorize only if not already set
                    if (!$variation->category) {
                        $variation->category = $category;
                    }

                    $variation->save();
                }
                $this->info("Successfully synced " . count($variations) . " variations for {$serviceId}.");
            } else {
                $this->error("Failed to fetch variations for {$serviceId}.");
                Log::warning("VTPass Sync: Failed to fetch variations for {$serviceId}.");
            }
        }

        $this->info('Price Sync Completed Successfully!');
    }
}
