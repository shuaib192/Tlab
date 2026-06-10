@extends('layouts.admin')
@section('title', 'Payment Details')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('admin.payments.index') }}" class="inline-flex items-center gap-2 text-sm font-bold text-muted hover:text-ink mb-6 transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Payments
    </a>

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
        <div class="flex items-center justify-between mb-6">
            <h1 class="font-black text-2xl text-ink">Payment Details</h1>
            <span class="text-xs font-bold px-4 py-2 rounded-lg" style="background:{{ $payment->status === 'paid' ? '#F0FDF4' : ($payment->status === 'pending' ? '#FFFBEB' : '#FEF2F2') }};color:{{ $payment->status === 'paid' ? '#16A34A' : ($payment->status === 'pending' ? '#D97706' : '#DC2626') }}">
                {{ strtoupper($payment->status) }}
            </span>
        </div>

        <div class="grid grid-cols-2 gap-6">
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Reference</div>
                <div class="font-mono text-sm font-bold text-ink">{{ $payment->reference }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Transaction ID</div>
                <div class="font-mono text-sm font-bold text-ink">{{ $payment->transaction_id ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">User</div>
                <div class="font-bold text-sm text-ink">{{ $payment->user->name }}</div>
                <div class="text-xs text-muted">{{ $payment->user->email }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Amount</div>
                <div class="font-black text-lg text-ink">&#8358;{{ number_format($payment->amount) }}</div>
                <div class="text-xs text-muted">{{ $payment->currency }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Channel</div>
                <div class="font-bold text-sm text-ink">{{ $payment->channel ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Date</div>
                <div class="font-bold text-sm text-ink">{{ $payment->paid_at?->format('F j, Y g:i A') ?? $payment->created_at->format('F j, Y g:i A') }}</div>
            </div>
            <div class="col-span-2">
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Description</div>
                <div class="font-bold text-sm text-ink">{{ $payment->description ?? 'N/A' }}</div>
            </div>
        </div>
    </div>
</div>
@endsection
