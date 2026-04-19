<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DoctorHospitalImage extends Model
{
    protected $fillable = ['doctor_id', 'image_path'];

    public function doctor()
    {
        return $this->belongsTo(User::class, 'doctor_id');
    }
}
