@extends('emails.layout')
@section('content')
<h2>Subscription Expiring Soon ⚠️</h2>
<p>Your <strong>{{ $subscription->plan->name }}</strong> subscription is expiring on <strong>{{ $subscription->ends_at->format('F j, Y') }}</strong>.</p>
<p>To ensure uninterrupted access to TLab's learning features, please renew your subscription before the expiry date.</p>
<a href="{{ route('parent.subscription') }}" class="btn">Renew Now</a>
@endsection
