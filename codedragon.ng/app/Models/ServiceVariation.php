<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['service_id', 'variation_code', 'name', 'wholesale_price', 'retail_price', 'category', 'is_hot_deal', 'hot_deal_start', 'hot_deal_end', 'is_active'])]
class ServiceVariation extends Model
{
    protected $casts = [
        'hot_deal_start' => 'datetime',
        'hot_deal_end' => 'datetime',
        'is_hot_deal' => 'boolean',
        'is_active' => 'boolean',
    ];
}
