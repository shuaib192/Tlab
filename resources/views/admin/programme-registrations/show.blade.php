@extends('layouts.admin')
@section('title', 'Registration Details')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('admin.programme-registrations.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-muted hover:text-ink mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Registrations
    </a>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="font-black text-2xl text-ink">Registration Details</h1>
            <span class="text-xs font-bold px-4 py-2 rounded-lg" style="background:{{ $programmeRegistration->status === 'paid' ? '#F0FDF4' : ($programmeRegistration->status === 'pending' ? '#FFFBEB' : '#FEF2F2') }};color:{{ $programmeRegistration->status === 'paid' ? '#16A34A' : ($programmeRegistration->status === 'pending' ? '#D97706' : '#DC2626') }}">
                {{ strtoupper($programmeRegistration->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Child</div>
                <div class="font-bold text-sm text-ink">{{ $programmeRegistration->child_name }}</div>
                <div class="text-xs text-muted">Age {{ $programmeRegistration->child_age }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Programme</div>
                <div class="font-bold text-sm text-ink">{{ $programmeRegistration->programme }}</div>
            </div>
            <div class="col-span-2">
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Parent / Guardian</div>
                <div class="font-bold text-sm text-ink">{{ $programmeRegistration->parent_name }}</div>
                <div class="text-xs text-muted">{{ $programmeRegistration->email }} · {{ $programmeRegistration->phone }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Device</div>
                <div class="font-bold text-sm text-ink">{{ ucfirst($programmeRegistration->device) }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Payment option</div>
                <div class="font-bold text-sm text-ink">{{ ucfirst($programmeRegistration->payment_option) }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Amount</div>
                <div class="font-black text-lg text-ink">&#8358;{{ number_format($programmeRegistration->amount) }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Reference</div>
                <div class="font-mono text-xs font-bold text-ink">{{ $programmeRegistration->reference }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Registered</div>
                <div class="font-bold text-sm text-ink">{{ $programmeRegistration->created_at->format('F j, Y g:i A') }}</div>
            </div>
            @if($programmeRegistration->status === 'paid')
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Paid</div>
                <div class="font-bold text-sm text-ink">{{ $programmeRegistration->paid_at?->format('F j, Y g:i A') ?? 'N/A' }}</div>
                <div class="text-xs text-muted">{{ $programmeRegistration->gateway_channel ?? 'Paystack' }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Transaction ID</div>
                <div class="font-mono text-xs font-bold text-ink">{{ $programmeRegistration->gateway_transaction ?? 'N/A' }}</div>
            </div>
            @endif
        </div>

        @if($programmeRegistration->status === 'pending')
        <div class="mt-6 rounded-2xl bg-gray-50 border border-gray-200 p-5 flex flex-wrap items-center gap-3">
            <form method="POST" action="{{ route('admin.programme-registrations.verify', $programmeRegistration) }}" onsubmit="return confirm('Confirm this registration as paid?')">
                @csrf
                <button class="bg-green-600 text-white rounded-xl px-6 py-2.5 text-sm font-bold hover:bg-green-700 transition-colors">Verify &amp; mark as paid</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection