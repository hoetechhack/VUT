<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Database\Factories\UserFactory;
use Illuminate\Database\Eloquent\Attributes\Fillable;
use Illuminate\Database\Eloquent\Attributes\Hidden;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

#[Fillable(['name', 'email', 'password', 'is_admin', 'is_active', 'is_verified', 'google_id', 'avatar', 'otp', 'otp_expires_at', 'transaction_pin', 'phone', 'bvn', 'bvn_verified_at', 'referral_code', 'referred_by', 'two_factor_secret', 'two_factor_enabled', 'receive_whatsapp_notifications'])]
#[Hidden(['password', 'remember_token'])]
class User extends Authenticatable
{
    /** @use HasFactory<UserFactory> */
    use HasFactory, Notifiable;

    /**
     * Get the attributes that should be cast.
     *
     * @return array<string, string>
     */
    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
            'bvn_verified_at' => 'datetime',
            'otp_expires_at' => 'datetime',
        ];
    }

    public function supportTickets()
    {
        return $this->hasMany(SupportTicket::class);
    }

    public function wallet()
    {
        return $this->hasOne(Wallet::class);
    }

    public function transactions()
    {
        return $this->hasMany(Transaction::class);
    }
}
