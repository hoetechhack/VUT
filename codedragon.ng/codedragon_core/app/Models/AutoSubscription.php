<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Illuminate\Database\Eloquent\Attributes\Fillable;

#[Fillable(['user_id', 'service_id', 'variation_code', 'amount', 'phone_number', 'frequency_days', 'max_runs', 'current_runs', 'next_run_at', 'last_run_at', 'end_at', 'status'])]
class AutoSubscription extends Model
{
    protected $casts = [
        'next_run_at' => 'datetime',
        'last_run_at' => 'datetime',
        'end_at' => 'datetime',
    ];
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
