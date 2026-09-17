@extends('layouts.admin')
@section('title', 'Registration Details')

@section('content')

<a href="{{ route('admin.programme-registrations.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-cream/50 hover:text-cream mb-6 transition-colors">
    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
    Back to Registrations
</a>

<div class="card p-6 sm:p-8">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-3 mb-8">
        <div class="flex items-center gap-4">
            <span class="w-12 h-12 rounded-full flex items-center justify-center font-black text-base flex-shrink-0" style="background:rgba(78,153,102,0.18);color:#6FBE8B;">
                {{ strtoupper(substr($programmeRegistration->child_name, 0, 1)) }}
            </span>
            <div>
                <h1 class="font-display text-2xl font-bold text-cream">{{ $programmeRegistration->child_name }}</h1>
                <p class="text-sm text-cream/40">{{ $programmeRegistration->programme }} &middot; Age {{ $programmeRegistration->child_age }}</p>
            </div>
        </div>
        <span class="badge {{ $programmeRegistration->status === 'paid' ? 'badge-green' : ($programmeRegistration->status === 'pending' ? 'badge-gold' : 'badge-red') }}">
            {{ $programmeRegistration->status === 'paid' ? 'Paid' : strtoupper($programmeRegistration->status) }}
        </span>
    </div>

    <div class="grid grid-cols-2 gap-x-8 gap-y-7">
        <div>
            <div class="label">Parent / Guardian</div>
            <div class="font-bold text-sm text-cream">{{ $programmeRegistration->parent_name }}</div>
            <div class="text-xs text-cream/40">{{ $programmeRegistration->email }} &middot; {{ $programmeRegistration->phone }}</div>
        </div>
        <div>
            <div class="label">Programme</div>
            <div class="font-bold text-sm text-cream">{{ $programmeRegistration->programme }}</div>
            <div class="text-xs text-cream/40">Band for ages {{ $programmeRegistration->child_age }}</div>
        </div>
        <div>
            <div class="label">Device</div>
            <div class="font-bold text-sm text-cream">{{ ucfirst($programmeRegistration->device) }}</div>
        </div>
        <div>
            <div class="label">Payment option</div>
            <span class="badge {{ $programmeRegistration->payment_option === 'full' ? 'badge-gold' : 'badge-gray' }}">{{ $programmeRegistration->payment_option === 'full' ? 'Full payment' : 'Monthly (3x)' }}</span>
        </div>
        <div>
            <div class="label">Amount</div>
            <div class="font-display font-bold text-xl text-cream">&#8358;{{ number_format($programmeRegistration->amount) }}</div>
        </div>
        <div>
            <div class="label">Reference</div>
            <div class="font-mono text-xs font-bold text-cream/70">{{ $programmeRegistration->reference }}</div>
        </div>
        <div>
            <div class="label">Registered</div>
            <div class="font-bold text-sm text-cream">{{ $programmeRegistration->created_at->format('F j, Y g:i A') }}</div>
        </div>
        @if($programmeRegistration->status === 'paid')
        <div>
            <div class="label">Paid</div>
            <div class="font-bold text-sm text-cream">{{ $programmeRegistration->paid_at?->format('F j, Y g:i A') ?? 'N/A' }}</div>
            <div class="text-xs text-cream/40">{{ $programmeRegistration->gateway_channel ?? 'Paystack' }}</div>
        </div>
        <div>
            <div class="label">Transaction ID</div>
            <div class="font-mono text-xs font-bold text-cream/70">{{ $programmeRegistration->gateway_transaction ?? 'N/A' }}</div>
        </div>
        @endif
    </div>

    @if($programmeRegistration->status === 'pending')
    <div class="mt-8 rounded-2xl p-5 flex flex-wrap items-center gap-3" style="background:rgba(250,245,232,0.04);border:1px solid rgba(250,245,232,0.08);">
        <form method="POST" action="{{ route('admin.programme-registrations.verify', $programmeRegistration) }}" onsubmit="return confirm('Confirm this registration as paid?')">
            @csrf
            <button class="btn-primary">Verify &amp; mark as paid</button>
        </form>
        <p class="text-xs text-cream/40 font-semibold">Only mark as paid if payment was confirmed outside Paystack.</p>
    </div>
    @endif
</div>

@endsection