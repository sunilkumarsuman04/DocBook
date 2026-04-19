<?php

namespace App\Mail;

use App\Models\Appointment;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AppointmentRejectedMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public readonly Appointment $appointment
    ) {}

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: '❌ Appointment Request Rejected — DocBook',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.appointment_rejected',
            with: [
                'patientName' => $this->appointment->patient->name,
                'doctorName'  => $this->appointment->doctor->name,
                'appointmentDate' => $this->appointment->appointment_date,
            ],
        );
    }
}
