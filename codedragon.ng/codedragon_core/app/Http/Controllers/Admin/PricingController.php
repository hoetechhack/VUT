<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\ServiceVariation;
use Illuminate\Support\Facades\Artisan;

class PricingController extends Controller
{
    public function index(Request $request)
    {
        $services = ServiceVariation::select('service_id')->distinct()->pluck('service_id');
        
        $selectedService = $request->get('service', $services->first() ?? 'mtn-data');
        
        $variations = ServiceVariation::where('service_id', $selectedService)->get();

        return view('admin.pricing.index', compact('services', 'selectedService', 'variations'));
    }

    public function syncNow()
    {
        Artisan::call('vtpass:sync-prices');
        return back()->with('status', 'Wholesale prices have been successfully synced from VTPass!');
    }

    public function applyRule(Request $request)
    {
        $request->validate([
            'service_id' => 'required',
            'rule_type' => 'required|in:percentage,fixed,use_higher,use_lower',
            'rule_value' => 'required|numeric'
        ]);

        $variations = ServiceVariation::where('service_id', $request->service_id)->get();
        $type = $request->rule_type;
        $val = (float) $request->rule_value;

        foreach ($variations as $var) {
            $wholesale = $var->wholesale_price;
            $newRetail = $wholesale;

            if ($type === 'percentage') {
                $newRetail = $wholesale + ($wholesale * ($val / 100));
            } elseif ($type === 'fixed') {
                $newRetail = $wholesale + $val;
            } elseif ($type === 'use_higher') {
                $pct = $wholesale * ($val / 100);
                $newRetail = $wholesale + max($pct, $val);
            } elseif ($type === 'use_lower') {
                $pct = $wholesale * ($val / 100);
                $newRetail = $wholesale + min($pct, $val);
            }

            $var->update(['retail_price' => $newRetail]);
        }

        return back()->with('status', 'Pricing rule applied to all packages in ' . $request->service_id);
    }

    public function updateManual(Request $request, $id)
    {
        $request->validate([
            'retail_price' => 'required|numeric',
            'category' => 'nullable|string',
            'is_hot_deal' => 'sometimes',
            'hot_deal_start' => 'nullable',
            'hot_deal_end' => 'nullable'
        ]);

        $variation = ServiceVariation::findOrFail($id);
        $variation->update([
            'retail_price' => $request->retail_price,
            'category' => $request->category,
            'is_hot_deal' => (bool) $request->has('is_hot_deal'),
            'hot_deal_start' => $request->filled('hot_deal_start') ? $request->hot_deal_start : null,
            'hot_deal_end' => $request->filled('hot_deal_end') ? $request->hot_deal_end : null,
        ]);

        return back()->with('status', 'Manual update successful for ' . $variation->name);
    }
}
