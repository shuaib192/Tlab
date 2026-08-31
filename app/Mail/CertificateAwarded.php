<?php

namespace App\Mail;

use App\Models\Certificate;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class CertificateAwarded extends Mailable
{
    use Queueable, SerializesModels;

    public Certificate $certificate;

    public function __construct(Certificate $certificate)
    {
        $this->certificate = $certificate;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Certificate Awarded - TLab',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.certificate-awarded',
        );
    }
}
