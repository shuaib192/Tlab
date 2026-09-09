@extends('layouts.admin')
@section('title', 'Payment Details')

@php use Illuminate\Support\Str; @endphp

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
            @if($payment->isManual())
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Gateway</div>
                <div class="text-xs font-bold px-3 py-1.5 rounded-lg inline-block" style="background:#EEF2FF;color:#4F46E5">Manual — proof submitted</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Proof submitted</div>
                <div class="font-bold text-sm text-ink">{{ $payment->proof_submitted_at?->format('F j, Y g:i A') ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Invoice</div>
                <div class="font-mono text-sm font-bold text-ink">{{ $payment->invoice?->invoice_number ?? 'N/A' }}</div>
            </div>
            <div>
                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Verified by</div>
                <div class="font-bold text-sm text-ink">{{ $payment->verifier?->name ?? 'N/A' }}</div>
            </div>
            @endif
            @if($payment->rejection_reason)
            <div class="col-span-2">
                <div class="text-xs font-bold text-red-500 uppercase tracking-wider mb-1">Rejection reason</div>
                <div class="font-bold text-sm text-red-500">{{ $payment->rejection_reason }}</div>
            </div>
            @endif
        </div>

        @if($payment->isManual() && $payment->proof_path)
        <div class="mt-6 rounded-2xl bg-indigo-50/60 border border-indigo-100 p-5">
            <div class="text-xs font-black text-indigo-600 uppercase tracking-wider mb-3">Payment proof — watchman review</div>
            @if(Str::contains($payment->proof_path, '.pdf'))
                <a href="{{ Storage::url($payment->proof_path) }}" target="_blank" class="inline-flex items-center gap-2 bg-indigo-600 text-white rounded-xl px-5 py-2.5 text-sm font-bold hover:bg-indigo-700 transition-colors">Open PDF proof</a>
            @else
                <img src="{{ Storage::url($payment->proof_path) }}" alt="Payment proof" class="max-h-72 rounded-xl border border-indigo-200 shadow-sm">
            @endif
        </div>
        @endif

        @if($payment->isManual() && $payment->status === 'pending')
        <div class="mt-6 rounded-2xl bg-gray-50 border border-gray-200 p-5 flex flex-wrap items-center gap-3">
            <form method="POST" action="{{ route('admin.payments.verify', $payment) }}" onsubmit="return confirm('Confirm this payment as received?')">
                @csrf
                <button class="bg-green-600 text-white rounded-xl px-6 py-2.5 text-sm font-bold hover:bg-green-700 transition-colors">Verify &amp; mark as paid</button>
            </form>
            <form method="POST" action="{{ route('admin.payments.reject', $payment) }}" class="flex items-center gap-2">
                @csrf
                <input name="reason" placeholder="Rejection reason (optional)" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm text-ink flex-1 min-w-56">
                <button class="bg-red-600 text-white rounded-xl px-6 py-2.5 text-sm font-bold hover:bg-red-700 transition-colors" onclick="return confirm('Reject this payment proof?')">Reject</button>
            </form>
        </div>
        @endif
    </div>
</div>
@endsection
