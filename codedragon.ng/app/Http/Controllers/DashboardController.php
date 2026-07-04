<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Models\ServiceVariation;
use App\Services\MonnifyService;

class DashboardController extends Controller
{
    public function index()
    {
        $user = Auth::user();
        
        // Auto-generate virtual account if verified but missing
        if ($user->is_verified && $user->wallet && !$user->wallet->virtual_account_number) {
            try {
                $monnify = new MonnifyService();
                $ref = 'CT-VA-' . $user->id . '-' . time();
                $monnifyEmail = config('app.env') === 'local' ? 'sb_' . time() . '_' . $user->email : $user->email;
                $accountName = config('app.name') . ' - ' . $user->name;
                $res = $monnify->createVirtualAccount($accountName, $monnifyEmail, $ref);
                
                if ($res && isset($res['accounts']) && count($res['accounts']) > 0) {
                    $user->wallet->update([
                        'virtual_account_number' => $res['accounts'][0]['accountNumber'],
                        'virtual_bank_name' => $res['accounts'][0]['bankName'],
                        'virtual_account_name' => $accountName
                    ]);
                }
            } catch (\Exception $e) {
                Log::error('Dashboard Auto-VA Failed: ' . $e->getMessage());
            }
        }

        // Fetch Hot Deals
        $hotDeals = ServiceVariation::where('is_hot_deal', true)
            ->where('is_active', true)
            ->where(function($q) {
                $q->whereNull('hot_deal_start')
                  ->orWhere('hot_deal_start', '<=', now());
            })
            ->where(function($q) {
                $q->whereNull('hot_deal_end')
                  ->orWhere('hot_deal_end', '>', now());
            })
            ->get();

        // Fetch Recurring Subscriptions
        $subscriptions = \App\Models\AutoSubscription::where('user_id', $user->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view('dashboard', compact('user', 'hotDeals', 'subscriptions'));
    }
}
