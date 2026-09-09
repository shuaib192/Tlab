<?php

namespace App\Http\Controllers;

use App\Mail\PaymentConfirmation;
use App\Models\Invoice;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Facades\Paystack;

class PaymentController extends Controller
{
    public function pricing()
    {
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('sort_order')->get();

        return view('pricing', compact('plans'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'plan_id' => 'required|exists:subscription_plans,id',
        ]);

        $plan = SubscriptionPlan::findOrFail($request->plan_id);
        $user = auth()->user();

        if (! $plan->is_active) {
            return back()->with('error', 'This plan is no longer available.');
        }

        $reference = 'TLAB-'.strtoupper(Str::random(12));

        try {
            $paymentData = [
                'amount' => $plan->price * 100,
                'email' => $user->email,
                'reference' => $reference,
                'currency' => 'NGN',
                'metadata' => json_encode([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'plan_name' => $plan->name,
                ]),
                'callback_url' => route('payment.callback'),
            ];

            $paystack = Paystack::getAuthorizationUrl($paymentData);
            $payment = Payment::create([
                'user_id' => $user->id,
                'reference' => $reference,
                'amount' => $plan->price,
                'currency' => 'NGN',
                'status' => 'pending',
                'description' => $plan->name.' Plan Subscription',
                'metadata' => ['plan_id' => $plan->id, 'plan_name' => $plan->name],
            ]);

            return redirect()->away($paystack->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to initialize payment. Please try again.');
        }
    }

    public function callback(Request $request)
    {
        $payment = Payment::where('reference', $request->reference)->firstOrFail();

        if ($request->trxref && $request->reference) {
            try {
                $verification = Paystack::getPaymentData($request->reference);

                if ($verification['data']['status'] === 'success') {
                    $payment->update([
                        'transaction_id' => $verification['data']['id'],
                        'channel' => $verification['data']['channel'],
                        'status' => 'paid',
                        'paid_at' => now(),
                    ]);

                    $metadata = $payment->metadata;
                    $plan = SubscriptionPlan::find($metadata['plan_id'] ?? null);

                    if ($plan) {
                        $endsAt = match ($plan->interval) {
                            'monthly' => now()->addMonth(),
                            'termly' => now()->addMonths(3),
                            'annual' => now()->addYear(),
                            default => now()->addMonth(),
                        };

                        Subscription::create([
                            'user_id' => $payment->user_id,
                            'subscription_plan_id' => $plan->id,
                            'status' => 'active',
                            'starts_at' => now(),
                            'ends_at' => $endsAt,
                        ]);

                        Notification::create([
                            'user_id' => $payment->user_id,
                            'type' => 'payment',
                            'title' => 'Payment Successful!',
                            'body' => "Your {$plan->name} subscription is now active.",
                            'icon' => '🎉',
                            'link' => route('parent.subscription'),
                        ]);
                    }

                    try { Mail::to($payment->user->email)->send(new PaymentConfirmation($payment, $plan)); } catch (\Exception $e) {}

                    return redirect()->route('parent.subscription')->with('success', 'Payment successful! Your subscription is now active.');
                }
            } catch (\Exception $e) {
            }

            $payment->update(['status' => 'failed']);

            return redirect()->route('pricing')->with('error', 'Payment verification failed. Please try again.');
        }

        return redirect()->route('pricing')->with('error', 'Payment was cancelled.');
    }

    public function webhook(Request $request)
    {
        $input = $request->all();

        if ($request->header('x-paystack-signature') !== hash_hmac('sha512', $request->getContent(), config('services.paystack.secret'))) {
            return response()->json(['status' => 'invalid signature'], 403);
        }

        $event = $input['event'] ?? '';

        if ($event === 'charge.success') {
            $data = $input['data'];
            $reference = $data['reference'];

            $payment = Payment::where('reference', $reference)->first();
            if ($payment && $payment->status !== 'paid') {
                $payment->update([
                    'transaction_id' => $data['id'],
                    'channel' => $data['channel'],
                    'status' => 'paid',
                    'paid_at' => now(),
                ]);

                $metadata = $payment->metadata;
                $plan = SubscriptionPlan::find($metadata['plan_id'] ?? null);

                if ($plan) {
                    $endsAt = match ($plan->interval) {
                        'monthly' => now()->addMonth(),
                        'termly' => now()->addMonths(3),
                        'annual' => now()->addYear(),
                        default => now()->addMonth(),
                    };

                    Subscription::create([
                        'user_id' => $payment->user_id,
                        'subscription_plan_id' => $plan->id,
                        'status' => 'active',
                        'starts_at' => now(),
                        'ends_at' => $endsAt,
                    ]);
                }
            }
        }

        return response()->json(['status' => 'ok']);
    }

    public function history()
    {
        $payments = Payment::where('user_id', auth()->id())->latest()->paginate(10);

        return view('parent.payments.history', compact('payments'));
    }

    public function invoices()
    {
        $invoices = Invoice::where('user_id', auth()->id())->latest()->paginate(10);

        return view('parent.payments.invoices', compact('invoices'));
    }

    public function uploadProof(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|exists:invoices,id',
            'proof' => 'required|file|mimes:jpg,jpeg,png,webp,pdf|max:8192',
        ]);

        $invoice = Invoice::where('id', $request->invoice_id)
            ->where('user_id', auth()->id())
            ->firstOrFail();

        if ($invoice->status === 'paid') {
            return back()->with('error', 'This invoice has already been paid.');
        }

        $path = $request->file('proof')->store('payment-proof/'.auth()->id(), 'public');

        $reference = 'TLAB-MAN-'.strtoupper(Str::random(10));

        $payment = Payment::updateOrCreate(
            [
                'user_id' => auth()->id(),
                'invoice_id' => $invoice->id,
                'status' => 'pending',
                'gateway' => 'manual',
            ],
            [
                'reference' => $reference,
                'amount' => $invoice->amount,
                'currency' => $invoice->currency ?? 'NGN',
                'description' => 'Payment for invoice '.$invoice->invoice_number,
                'proof_path' => $path,
                'proof_submitted_at' => now(),
                'metadata' => ['invoice_id' => $invoice->id, 'invoice_number' => $invoice->invoice_number],
            ]
        );

        foreach (User::whereIn('role', ['admin', 'super_admin'])->cursor() as $admin) {
            Notification::create([
                'user_id' => $admin->id,
                'type' => 'payment',
                'title' => 'Payment proof awaiting review',
                'body' => "{$invoice->invoice_number} — ".auth()->user()->name.' uploaded transfer proof (N'.$invoice->amount.') and is waiting for verification.',
                'icon' => '🔎',
                'link' => route('admin.payments.show', $payment),
            ]);
        }

        return back()->with('success', 'Proof submitted! Our team will verify your payment shortly.');
    }

    public function subscription()
    {
        $user = auth()->user();
        $activeSubscription = $user->activeSubscription;
        $subscriptions = $user->subscriptions()->latest()->get();
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('sort_order')->get();

        return view('parent.subscription', compact('activeSubscription', 'subscriptions', 'plans'));
    }
}
