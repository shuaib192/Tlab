<?php

namespace App\Console\Commands;

use App\Mail\PaymentConfirmation;
use App\Models\Payment;
use App\Models\Subscription;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class ProcessSubscriptions extends Command
{
    protected $signature = 'subscriptions:process';

    protected $description = 'Process subscription renewals, expirations, and trial periods';

    public function handle()
    {
        $this->info('Processing subscriptions...');

        $now = now();

        // Expire subscriptions past their end_date
        $expired = Subscription::where('status', 'active')
            ->where('ends_at', '<=', $now)
            ->update(['status' => 'expired']);
        $this->info("Expired {$expired} subscriptions.");

        // Mark subscriptions cancelled 3+ days ago as expired
        $cancelledExpired = Subscription::where('status', 'cancelled')
            ->where('cancelled_at', '<=', $now->copy()->subDays(3))
            ->update(['status' => 'expired']);
        $this->info("Finalised {$cancelledExpired} cancelled subscriptions.");

        // Send expiry warnings for subscriptions ending in 7 days
        $endingSoon = Subscription::where('status', 'active')
            ->where('ends_at', '>', $now)
            ->where('ends_at', '<=', $now->copy()->addDays(7))
            ->with('user', 'plan')
            ->get();

        foreach ($endingSoon as $sub) {
            try {
                Mail::to($sub->user->email)->send(new \App\Mail\ExpiryWarning($sub));
            } catch (\Exception $e) {
                $this->error("Failed to send expiry warning: {$e->getMessage()}");
            }
        }
        $this->info("Sent {$endingSoon->count()} expiry warnings.");

        // Process renewal for payment due subscriptions
        $dueForRenewal = Subscription::where('status', 'active')
            ->where('ends_at', '<=', $now->copy()->addDay())
            ->where('ends_at', '>', $now->copy()->subDay())
            ->with('user', 'plan')
            ->get();

        foreach ($dueForRenewal as $sub) {
            try {
                $plan = $sub->plan;
                $endsAt = match ($plan->interval) {
                    'monthly' => $now->copy()->addMonth(),
                    'termly' => $now->copy()->addMonths(3),
                    'annual' => $now->copy()->addYear(),
                    default => $now->copy()->addMonth(),
                };

                $newSub = Subscription::create([
                    'user_id' => $sub->user_id,
                    'subscription_plan_id' => $plan->id,
                    'status' => 'active',
                    'starts_at' => $now,
                    'ends_at' => $endsAt,
                ]);

                $payment = Payment::create([
                    'user_id' => $sub->user_id,
                    'reference' => 'RENEWAL-'.strtoupper(substr(uniqid(), -8)),
                    'amount' => $plan->price,
                    'currency' => 'NGN',
                    'status' => 'paid',
                    'description' => "Auto-renewal: {$plan->name}",
                    'paid_at' => $now,
                ]);

                Mail::to($sub->user->email)->send(new PaymentConfirmation($payment, $plan));
            } catch (\Exception $e) {
                $this->error("Renewal failed for user {$sub->user_id}: {$e->getMessage()}");
            }
        }
        $this->info("Processed {$dueForRenewal->count()} renewals.");

        return Command::SUCCESS;
    }
}
