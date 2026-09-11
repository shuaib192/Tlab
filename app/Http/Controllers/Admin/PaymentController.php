<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Notification;
use App\Models\Payment;
use App\Models\Subscription;
use App\Models\SubscriptionPlan;
use Illuminate\Http\Request;

class PaymentController extends Controller
{
    public function index(Request $request)
    {
        $query = Payment::with('user');

        if ($request->filled('status') && in_array($request->status, ['pending', 'paid', 'failed'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('gateway') && in_array($request->gateway, ['paystack', 'manual'])) {
            $query->where('gateway', $request->gateway);
        }

        $payments = $query->latest()->paginate(20);
        $totalRevenue = Payment::where('status', 'paid')->sum('amount');
        $pendingCount = Payment::where('status', 'pending')->count();
        $successfulCount = Payment::where('status', 'paid')->count();

        return view('admin.payments.index', compact('payments', 'totalRevenue', 'pendingCount', 'successfulCount'));
    }

    public function show(Payment $payment)
    {
        $payment->load('user', 'verifier', 'invoice');

        return view('admin.payments.show', compact('payment'));
    }

    public function verify(Request $request, Payment $payment)
    {
        if ($payment->status === 'paid') {
            return back()->with('error', 'This payment has already been verified.');
        }

        $payment->update([
            'status' => 'paid',
            'paid_at' => now(),
            'verified_at' => now(),
            'verified_by' => auth()->id(),
            'rejection_reason' => null,
        ]);

        if ($payment->invoice) {
            $payment->invoice->update(['status' => 'paid', 'paid_at' => now()]);
        }

        $planId = data_get($payment->metadata, 'plan_id');
        $plan = $planId ? SubscriptionPlan::find($planId) : null;

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

        Notification::create([
            'user_id' => $payment->user_id,
            'type' => 'payment',
            'title' => 'Payment Verified!',
            'body' => 'Your transfer payment '.$payment->reference.' has been confirmed. Thank you!',
            'icon' => null,
            'link' => route('payment.history'),
        ]);

        return back()->with('success', 'Payment verified and marked as paid.');
    }

    public function reject(Request $request, Payment $payment)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);

        if ($payment->status === 'paid') {
            return back()->with('error', 'A verified payment cannot be rejected.');
        }

        $payment->update([
            'status' => 'failed',
            'verified_by' => auth()->id(),
            'rejection_reason' => $request->reason ?? 'Proof did not match an expected transfer.',
        ]);

        Notification::create([
            'user_id' => $payment->user_id,
            'type' => 'payment',
            'title' => 'Payment not verified',
            'body' => $payment->rejection_reason.' — please contact support or resubmit clearer proof.',
            'icon' => null,
            'link' => route('payment.history'),
        ]);

        return back()->with('success', 'Payment rejected.');
    }
}
