<?php

namespace App\Mail;

use App\Models\AssignmentSubmission;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class SubmissionGraded extends Mailable
{
    use Queueable, SerializesModels;

    public AssignmentSubmission $submission;

    public function __construct(AssignmentSubmission $submission)
    {
        $this->submission = $submission;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Assignment Graded - TLab',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.submission-graded',
        );
    }
}
