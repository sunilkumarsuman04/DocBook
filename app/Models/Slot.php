<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Slot extends Model
{
    protected $fillable = ['doctor_id', 'date', 'start_time', 'end_time', 'is_available'];

    protected $casts = ['is_available' => 'boolean'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }

    public function appointment()
    {
        return $this->hasOne(Appointment::class);
    }
}
