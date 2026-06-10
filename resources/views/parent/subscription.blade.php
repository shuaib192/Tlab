@extends('layouts.parent')
@section('title', 'Subscription & Billing')

@section('parent-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h1 class="font-black text-2xl text-ink">Subscription & Billing</h1>
            </div>
        </div>
        <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-sm">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6v6m0 0v6m0-6h6m-6 0H6"/></svg>
            Upgrade Plan
        </a>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm mb-8">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($activeSubscription)
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 mb-8">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4">
            <div class="flex items-center gap-4">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center">
                    <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <div>
                    <div class="flex items-center gap-2">
                        <h2 class="font-black text-xl text-ink">Active Plan</h2>
                        <span class="text-xs font-bold bg-primary/10 text-primary px-3 py-1 rounded-full">{{ $activeSubscription->plan->name ?? 'N/A' }}</span>
                    </div>
                    <p class="text-muted text-sm mt-1">
                        {{ $activeSubscription->plan->description ?? '' }} &middot;
                        &#8358;{{ number_format($activeSubscription->plan->price ?? 0) }}/{{ $activeSubscription->plan->interval ?? 'month' }}
                    </p>
                </div>
            </div>
            <div class="text-right">
                <div class="text-xs text-muted font-semibold">Valid until</div>
                <div class="font-bold text-ink">{{ $activeSubscription->ends_at ? $activeSubscription->ends_at->format('M j, Y') : 'Lifetime' }}</div>
                <div class="text-xs text-muted mt-1">{{ now()->diffInDays($activeSubscription->ends_at) }} days remaining</div>
            </div>
        </div>
    </div>
    @else
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-12 text-center mb-8">
        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
        </div>
        <h2 class="font-black text-xl text-ink mb-2">No Active Subscription</h2>
        <p class="text-muted text-sm mb-6">Subscribe to a plan to unlock all features for your children.</p>
        <a href="{{ route('pricing') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all">
            View Plans
        </a>
    </div>
    @endif

    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="font-black text-lg text-ink mb-6">Subscription History</h2>
            @if($subscriptions->isEmpty())
                <p class="text-muted text-sm text-center py-8">No subscription history yet.</p>
            @else
                <div class="space-y-3">
                    @foreach($subscriptions as $sub)
                    <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50">
                        <div>
                            <div class="font-bold text-sm text-ink">{{ $sub->plan->name ?? 'Unknown Plan' }}</div>
                            <div class="text-xs text-muted">{{ $sub->starts_at->format('M j, Y') }} - {{ $sub->ends_at?->format('M j, Y') ?? 'N/A' }}</div>
                        </div>
                        <span class="text-xs font-bold px-3 py-1.5 rounded-lg" style="background:{{ $sub->status === 'active' ? '#F0FDF4' : '#F9FAFB' }};color:{{ $sub->status === 'active' ? '#16A34A' : '#9CA3AF' }}">
                            {{ ucfirst($sub->status) }}
                        </span>
                    </div>
                    @endforeach
                </div>
            @endif
        </div>

        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="font-black text-lg text-ink mb-6">Available Plans</h2>
            <div class="space-y-3">
                @foreach($plans as $plan)
                <div class="flex items-center justify-between p-4 rounded-2xl border border-gray-100 hover:border-primary/20 transition-all">
                    <div>
                        <div class="font-bold text-sm text-ink">{{ $plan->name }}</div>
                        <div class="text-xs text-muted">&#8358;{{ number_format($plan->price) }}/{{ $plan->interval }} &middot; Up to {{ $plan->max_children }} children</div>
                    </div>
                    @if($activeSubscription && $activeSubscription->subscription_plan_id === $plan->id)
                        <span class="text-xs font-bold text-primary bg-primary/10 px-3 py-1.5 rounded-lg">Current</span>
                    @else
                        <a href="{{ route('payment.checkout') }}" class="text-xs font-bold text-primary hover:text-primary/80 transition-colors"
                           onclick="event.preventDefault();document.getElementById('checkout-{{ $plan->id }}').submit();">
                            Subscribe
                        </a>
                        <form id="checkout-{{ $plan->id }}" action="{{ route('payment.checkout') }}" method="POST" class="hidden">
                            @csrf
                            <input type="hidden" name="plan_id" value="{{ $plan->id }}">
                        </form>
                    @endif
                </div>
                @endforeach
            </div>
        </div>
    </div>
</div>
@endsection
