<?php

namespace App\Mail;

use App\Models\StudentRegistration;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class StudentRegistrationReceived extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(
        public StudentRegistration $registration
    ) {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'طلب تسجيل طالب جديد — ' . ($this->registration->student_name ?? 'مدارس رواد النجاح')
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.student-registration'
        );
    }
}
