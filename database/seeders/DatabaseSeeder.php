<?php

namespace Database\Seeders;

use App\Models\Appointment;
use App\Models\DoctorProfile;
use App\Models\PatientProfile;
use App\Models\Review;
use App\Models\Slot;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        // ── Admin ────────────────────────────────────────────────
        User::create([
            'name'      => 'Admin User',
            'email'     => 'admin@demo.com',
            'password'  => Hash::make('password'),
            'role'      => 'ADMIN',
            'is_active' => true,
        ]);

        // ── Doctors ──────────────────────────────────────────────
        $doctors = [
            ['Dr. Priya Sharma',   'Cardiologist',      'Mumbai', 12, 800],
            ['Dr. Rahul Mehta',    'Neurologist',       'Delhi',  8,  600],
            ['Dr. Anjali Singh',   'Pediatrician',      'Pune',   15, 500],
            ['Dr. Vikram Patel',   'Orthopedist',       'Mumbai', 10, 700],
            ['Dr. Sunita Rao',     'Dermatologist',     'Chennai',6,  400],
            ['Dr. Arun Kumar',     'General Physician', 'Bangalore',5, 300],
        ];

        $doctorUsers = [];
        foreach ($doctors as $i => [$name, $spec, $city, $exp, $fee]) {
            $email = strtolower(str_replace([' ', '.'], ['', ''], $name)) . '@demo.com';
            $user  = User::create([
                'name'      => $name,
                'email'     => $email,
                'password'  => Hash::make('password'),
                'role'      => 'DOCTOR',
                'is_active' => true,
            ]);
            DoctorProfile::create([
                'user_id'          => $user->id,
                'specialization'   => $spec,
                'experience'       => $exp,
                'consultation_fee' => $fee,
                'city'             => $city,
                'clinic_name'      => $name . "'s Clinic",
                'qualifications'   => ['MBBS', 'MD'],
                'bio'              => "Dr. " . explode(' ', $name)[1] . " is a highly experienced {$spec} with {$exp} years of practice.",
                'approval_status'  => 'APPROVED',
                'rating'           => round(4.0 + mt_rand(0, 9) / 10, 1),
                'review_count'     => mt_rand(10, 80),
            ]);

            // Generate slots for next 7 days
            for ($d = 0; $d < 7; $d++) {
                $date = Carbon::today()->addDays($d);
                for ($h = 9; $h < 17; $h++) {
                    Slot::create([
                        'doctor_id'    => $user->id,
                        'date'         => $date->format('Y-m-d'),
                        'start_time'   => sprintf('%02d:00:00', $h),
                        'end_time'     => sprintf('%02d:30:00', $h),
                        'is_available' => true,
                    ]);
                    Slot::create([
                        'doctor_id'    => $user->id,
                        'date'         => $date->format('Y-m-d'),
                        'start_time'   => sprintf('%02d:30:00', $h),
                        'end_time'     => sprintf('%02d:00:00', $h + 1),
                        'is_available' => true,
                    ]);
                }
            }

            $doctorUsers[] = $user;
        }

        // Demo doctor with exact credentials
        $demoDoctor = User::create([
            'name'      => 'Demo Doctor',
            'email'     => 'doctor@demo.com',
            'password'  => Hash::make('password'),
            'role'      => 'DOCTOR',
            'is_active' => true,
        ]);
        DoctorProfile::create([
            'user_id'          => $demoDoctor->id,
            'specialization'   => 'General Physician',
            'experience'       => 5,
            'consultation_fee' => 300,
            'city'             => 'Mumbai',
            'qualifications'   => ['MBBS'],
            'bio'              => 'Demo doctor account for testing.',
            'approval_status'  => 'APPROVED',
            'rating'           => 4.5,
            'review_count'     => 20,
        ]);

        // ── Patients ─────────────────────────────────────────────
        $patient = User::create([
            'name'      => 'Demo Patient',
            'email'     => 'patient@demo.com',
            'password'  => Hash::make('password'),
            'role'      => 'PATIENT',
            'is_active' => true,
        ]);
        PatientProfile::create([
            'user_id'    => $patient->id,
            'gender'     => 'MALE',
            'blood_group'=> 'O+',
        ]);

        // ── Sample Appointments ───────────────────────────────────
        $statuses = ['PENDING', 'CONFIRMED', 'COMPLETED', 'COMPLETED', 'CANCELLED'];
        foreach ($doctorUsers as $i => $doc) {
            $status = $statuses[$i % count($statuses)];
            Appointment::create([
                'patient_id'       => $patient->id,
                'doctor_id'        => $doc->id,
                'appointment_date' => Carbon::today()->subDays($i + 1)->format('Y-m-d'),
                'start_time'       => '10:00:00',
                'end_time'         => '10:30:00',
                'status'           => $status,
                'consultation_fee' => $doc->doctorProfile->consultation_fee,
                'payment_status'   => $status === 'COMPLETED' ? 'PAID' : 'UNPAID',
                'is_reviewed'      => $status === 'COMPLETED',
            ]);
        }
    }
}
