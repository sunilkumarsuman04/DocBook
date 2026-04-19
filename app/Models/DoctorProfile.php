<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorProfile extends Model
{
    protected $fillable = [
        'user_id', 'specialization', 'experience', 'consultation_fee',
        'city', 'clinic_name', 'clinic_address', 'qualifications',
        'bio', 'approval_status', 'rejection_reason', 'rating', 'review_count',
        'booking_type', 'max_tokens',
        'max_patients_per_day', 'allow_next_day', 'doctor_image',
    ];

    protected $casts = [
        'qualifications'       => 'array',
        'experience'           => 'integer',
        'consultation_fee'     => 'decimal:2',
        'rating'               => 'decimal:2',
        'review_count'         => 'integer',
        'max_tokens'           => 'integer',
        'max_patients_per_day' => 'integer',
        'allow_next_day'       => 'boolean',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function hospitalImages()
    {
        return $this->hasMany(DoctorHospitalImage::class, 'doctor_id', 'user_id');
    }

    public function isTokenBased(): bool
    {
        return $this->booking_type === 'token';
    }

    public function effectiveDailyLimit(): int
    {
        return $this->booking_type === 'token'
            ? ($this->max_tokens ?? 30)
            : ($this->max_patients_per_day ?? 30);
    }
}
