@extends('layouts.parent')
@section('title', 'Payment History')

@section('parent-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
        </div>
        <h1 class="font-black text-2xl text-ink">Payment History</h1>
    </div>

    @if($payments->isEmpty())
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <h2 class="font-black text-xl text-ink mb-2">No Payments Yet</h2>
            <p class="text-muted text-sm">Payment records will appear here after you subscribe.</p>
        </div>
    @else
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm overflow-hidden">
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="bg-gray-50">
                            <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Reference</th>
                            <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Description</th>
                            <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Amount</th>
                            <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Status</th>
                            <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase tracking-wider">Date</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($payments as $payment)
                        <tr class="hover:bg-gray-50/50 transition-colors">
                            <td class="px-6 py-4 font-mono text-xs text-muted font-semibold">{{ $payment->reference }}</td>
                            <td class="px-6 py-4 font-semibold text-ink">{{ $payment->description }}</td>
                            <td class="px-6 py-4 text-right font-bold text-ink">&#8358;{{ number_format($payment->amount) }}</td>
                            <td class="px-6 py-4 text-center">
                                <span class="text-xs font-bold px-3 py-1.5 rounded-lg" style="background:{{ $payment->status === 'paid' ? '#F0FDF4' : ($payment->status === 'pending' ? '#FFFBEB' : '#FEF2F2') }};color:{{ $payment->status === 'paid' ? '#16A34A' : ($payment->status === 'pending' ? '#D97706' : '#DC2626') }}">
                                    {{ ucfirst($payment->status) }}
                                </span>
                            </td>
                            <td class="px-6 py-4 text-right text-muted text-xs">{{ $payment->paid_at?->format('M j, Y') ?? $payment->created_at->format('M j, Y') }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        <div class="mt-6">{{ $payments->links() }}</div>
    @endif
</div>
@endsection
