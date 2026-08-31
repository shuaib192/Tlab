@extends('emails.layout')
@section('content')
<h2>Payment Confirmed! 🎉</h2>
<p>Your payment of <strong>₦{{ number_format($payment->amount) }}</strong> for the <strong>{{ $plan?->name ?? 'TLab' }}</strong> subscription has been confirmed.</p>
<div class="details">
<dl>
<dt>Reference</dt><dd>{{ $payment->reference }}</dd>
<dt>Amount</dt><dd>₦{{ number_format($payment->amount) }}</dd>
<dt>Date</dt><dd>{{ $payment->paid_at?->format('F j, Y g:i A') ?? now()->format('F j, Y g:i A') }}</dd>
<dt>Plan</dt><dd>{{ $plan?->name ?? 'N/A' }}</dd>
</dl>
</div>
<p>Your subscription is now active. Your child can start learning immediately!</p>
<a href="{{ route('parent.dashboard') }}" class="btn">Go to Dashboard</a>
@endsection
