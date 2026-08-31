<?php

namespace App\Mail;

use App\Models\Payment;
use App\Models\SubscriptionPlan;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;

class PaymentConfirmation extends Mailable
{
    use Queueable, SerializesModels;

    public Payment $payment;
    public ?SubscriptionPlan $plan;

    public function __construct(Payment $payment, ?SubscriptionPlan $plan = null)
    {
        $this->payment = $payment;
        $this->plan = $plan;
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'Payment Confirmed - TLab Subscription',
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.payment-confirmation',
        );
    }
}
