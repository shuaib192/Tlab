<?php

namespace App\Mail;

use App\Models\CommunicationLog;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class TeacherFeedback extends Mailable
{
    use Queueable, SerializesModels;

    public CommunicationLog $log;

    public function __construct(CommunicationLog $log)
    {
        $this->log = $log;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Message from Teacher - TLab',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.teacher-feedback',
        );
    }
}
