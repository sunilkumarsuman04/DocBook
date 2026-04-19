<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Appointment extends Model
{
    protected $fillable = [
        'patient_id', 'doctor_id', 'slot_id', 'appointment_date',
        'start_time', 'end_time', 'status', 'notes',
        'consultation_fee', 'payment_status', 'payment_method', 'is_reviewed',
        'token_number', 'is_extra_request', 'patient_note', 'approved_at',
    ];

    protected $casts = [
        'appointment_date' => 'date',
        'is_reviewed'      => 'boolean',
        'is_extra_request' => 'boolean',
        'consultation_fee' => 'decimal:2',
        'token_number'     => 'integer',
        'approved_at'      => 'datetime',
    ];

    public function patient()
    {
        return $this->belongsTo(User::class, 'patient_id');
    }

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function slot()
    {
        return $this->belongsTo(Slot::class);
    }

    public function review()
    {
        return $this->hasOne(Review::class);
    }

    public function canCancel(): bool
    {
        return in_array($this->status, ['PENDING', 'CONFIRMED']);
    }

    public function canReview(): bool
    {
        return $this->status === 'COMPLETED' && !$this->is_reviewed;
    }

    public static function nextToken(int $doctorId, string $date): int
    {
        $max = self::where('doctor_id', $doctorId)
            ->where('appointment_date', $date)
            ->whereNotNull('token_number')
            ->max('token_number');

        return ($max ?? 0) + 1;
    }
}
