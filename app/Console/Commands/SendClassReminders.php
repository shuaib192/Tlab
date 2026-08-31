<?php

namespace App\Console\Commands;

use App\Models\ClassSession;
use App\Models\Enrollment;
use App\Mail\ClassReminder;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class SendClassReminders extends Command
{
    protected $signature = 'classes:remind';
    protected $description = 'Send 24-hour class reminders to parents';

    public function handle()
    {
        $this->info('Sending class reminders...');

        $tomorrow = now()->addDay()->toDateString();

        $sessions = ClassSession::whereDate('date', $tomorrow)
            ->where('status', 'scheduled')
            ->with(['course', 'cohort.enrollments.child.parent'])
            ->get();

        $sent = 0;
        foreach ($sessions as $session) {
            foreach ($session->cohort->enrollments as $enrollment) {
                $child = $enrollment->child;
                if (!$child || !$child->parent || !$child->parent->email) continue;

                try {
                    Mail::to($child->parent->email)
                        ->send(new ClassReminder($session, $child->name));
                    $sent++;
                } catch (\Exception $e) {
                    $this->error("Failed: {$child->parent->email} - {$e->getMessage()}");
                }
            }
        }

        $this->info("Sent {$sent} class reminders for tomorrow's sessions.");
        return Command::SUCCESS;
    }
}
