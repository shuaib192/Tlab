<?php

namespace App\Mail;

use App\Models\ClassSession;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class ClassReminder extends Mailable
{
    use Queueable, SerializesModels;

    public ClassSession $session;

    public string $childName;

    public function __construct(ClassSession $session, string $childName)
    {
        $this->session = $session;
        $this->childName = $childName;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Upcoming Class Reminder - TLab',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.class-reminder',
        );
    }
}
