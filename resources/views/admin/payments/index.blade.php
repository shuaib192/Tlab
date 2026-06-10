@extends('layouts.admin')
@section('title', 'Payments')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-black text-2xl text-ink">Payments</h1>
            <p class="text-muted text-sm">Manage all platform payments</p>
        </div>
    </div>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Total Revenue</div>
            <div class="font-black text-3xl text-ink">&#8358;{{ number_format($totalRevenue) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Successful Payments</div>
            <div class="font-black text-3xl text-primary">{{ $successfulCount }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Pending</div>
            <div class="font-black text-3xl text-amber-600">{{ $pendingCount }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase">Ref</th>
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase">User</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase">Amount</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase">Status</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($payments as $payment)
                    <tr class="hover:bg-gray-50/50 cursor-pointer" onclick="window.location='{{ route('admin.payments.show', $payment) }}'">
                        <td class="px-6 py-4 font-mono text-xs text-muted font-semibold">{{ $payment->reference }}</td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-ink">{{ $payment->user->name }}</span>
                            <span class="text-xs text-muted block">{{ $payment->user->email }}</span>
                        </td>
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
</div>
@endsection
