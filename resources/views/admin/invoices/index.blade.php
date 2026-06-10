@extends('layouts.admin')
@section('title', 'Invoices')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Invoices</h1>
        <p class="text-cream/50 text-sm">Manage platform invoices.</p>
    </div>
    <a href="{{ route('admin.invoices.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Invoice
    </a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Invoice #</th>
                    <th class="text-left px-5 py-3">User</th>
                    <th class="text-left px-5 py-3">Amount</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Due Date</th>
                    <th class="text-left px-5 py-3">Paid At</th>
                    <th class="text-left px-5 py-3">Created</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoices as $invoice)
                <tr class="table-row">
                    <td class="px-5 py-3 font-mono font-bold text-sm">{{ $invoice->invoice_number }}</td>
                    <td class="px-5 py-3">{{ $invoice->user?->name ?? 'N/A' }}</td>
                    <td class="px-5 py-3 font-semibold">{{ number_format($invoice->amount / 100, 2) }} {{ $invoice->currency }}</td>
                    <td class="px-5 py-3">
                        <span class="badge {{ $invoice->status === 'paid' ? 'badge-green' : ($invoice->status === 'overdue' ? 'badge-red' : 'badge-gold') }}">
                            {{ $invoice->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-cream/60">{{ $invoice->due_date?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ $invoice->paid_at?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ $invoice->created_at->format('M d, Y') }}</td>
                    <td class="px-5 py-3 text-right">
                        <a href="{{ route('admin.invoices.download', $invoice) }}" class="btn-secondary btn-sm text-xs">
                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            PDF
                        </a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-12 text-center text-cream/40">No invoices yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $invoices->links() }}</div>
@endsection
