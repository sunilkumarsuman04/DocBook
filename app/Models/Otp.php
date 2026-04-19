<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Carbon\Carbon;

class Otp extends Model
{
    protected $table = 'otps';

    protected $fillable = [
        'email',
        'otp',
        'expires_at',
    ];

    protected $casts = [
        'expires_at' => 'datetime',
    ];

    /**
     * Check whether this OTP is still valid (not expired).
     */
    public function isValid(): bool
    {
        return Carbon::now()->lessThanOrEqualTo($this->expires_at);
    }

    /**
     * Scope: find latest OTP for an email.
     */
    public function scopeForEmail($query, string $email)
    {
        return $query->where('email', $email)->latest();
    }
}