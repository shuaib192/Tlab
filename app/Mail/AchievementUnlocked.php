<?php

namespace App\Mail;

use App\Models\Achievement;
use App\Models\ChildProfile;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class AchievementUnlocked extends Mailable
{
    use Queueable, SerializesModels;

    public Achievement $achievement;

    public ChildProfile $child;

    public function __construct(Achievement $achievement, ChildProfile $child)
    {
        $this->achievement = $achievement;
        $this->child = $child;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Achievement Unlocked! - TLab',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.achievement-unlocked',
        );
    }
}
