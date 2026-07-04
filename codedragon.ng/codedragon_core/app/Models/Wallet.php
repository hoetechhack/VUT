<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id',
        'balance',
        'virtual_account_number',
        'virtual_account_name',
        'virtual_bank_name',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
