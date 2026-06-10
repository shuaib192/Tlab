<?php

namespace App\Http\Controllers;

use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use App\Models\Enrollment;
use App\Models\Notification;
use Illuminate\Http\Request;
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

        if (!$plan->is_active) {
            return back()->with('error', 'This plan is no longer available.');
        }

        $reference = 'TLAB-' . strtoupper(Str::random(12));

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
                'description' => $plan->name . ' Plan Subscription',
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

                    return redirect()->route('parent.subscription')->with('success', 'Payment successful! Your subscription is now active.');
                }
            } catch (\Exception $e) {}

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

    public function subscription()
    {
        $user = auth()->user();
        $activeSubscription = $user->activeSubscription;
        $subscriptions = $user->subscriptions()->latest()->get();
        $plans = SubscriptionPlan::where('is_active', true)->orderBy('sort_order')->get();
        return view('parent.subscription', compact('activeSubscription', 'subscriptions', 'plans'));
    }
}
