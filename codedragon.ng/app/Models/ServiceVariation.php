<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ServiceVariation extends Model
{
    protected $fillable = [
        'service_id', 'variation_code', 'name', 'wholesale_price', 'retail_price',
        'category', 'is_hot_deal', 'hot_deal_start', 'hot_deal_end', 'is_active',
    ];

    protected $casts = [
        'hot_deal_start' => 'datetime',
        'hot_deal_end' => 'datetime',
        'is_hot_deal' => 'boolean',
        'is_active' => 'boolean',
    ];
}
