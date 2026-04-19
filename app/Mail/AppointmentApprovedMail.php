<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentApprovedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Appointment $appointment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '✅ Appointment Confirmed — DocBook',
        );
    }

    public function content(): Content
    {
        $apt = $this->appointment;

        // For token-based bookings, show token number; for time-based show time
        $timeOrToken = $apt->token_number
            ? 'Token #' . $apt->token_number
            : \App\Helpers\AppHelper::formatTime($apt->start_time ?? '00:00:00');

        return new Content(
            view: 'emails.appointment_approved',
            with: [
                'patientName'     => $apt->patient->name,
                'doctorName'      => $apt->doctor->name,
                'appointmentDate' => $apt->appointment_date,
                'appointmentTime' => $timeOrToken,
                'appointmentId'   => $apt->id,
                'tokenNumber'     => $apt->token_number,
            ],
        );
    }
}
