<?php

namespace App\Helpers;

class AppHelper
{
    public static function specializations(): array
    {
        return [
            'Cardiologist', 'Dermatologist', 'Endocrinologist', 'Gastroenterologist',
            'General Physician', 'Gynecologist', 'Neurologist', 'Oncologist',
            'Ophthalmologist', 'Orthopedist', 'Pediatrician', 'Psychiatrist',
            'Pulmonologist', 'Radiologist', 'Rheumatologist', 'Urologist',
        ];
    }

    public static function days(): array
    {
        return ['MONDAY','TUESDAY','WEDNESDAY','THURSDAY','FRIDAY','SATURDAY','SUNDAY'];
    }

    public static function statusBadgeClass(string $status): string
    {
        return match ($status) {
            'PENDING'   => 'badge-yellow',
            'CONFIRMED' => 'badge-blue',
            'COMPLETED' => 'badge-green',
            'CANCELLED' => 'badge-red',
            'REJECTED'  => 'badge-red',
            'APPROVED'  => 'badge-green',
            'NO_SHOW'   => 'badge-gray',
            default     => 'badge-gray',
        };
    }

    public static function formatTime(string $time): string
    {
        try {
            return \Carbon\Carbon::createFromFormat('H:i:s', $time)->format('h:i A');
        } catch (\Exception $e) {
            return $time;
        }
    }
}
