@extends('layouts.parent')
@section('title', 'My Invoices')

@section('parent-content')
<div class="max-w-5xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    <div class="flex items-center gap-3 mb-8">
        <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center">
            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
        </div>
        <div>
            <h1 class="font-black text-2xl text-ink">My Invoices</h1>
            <p class="text-muted text-sm">Pay online, or pay by bank transfer and upload your proof.</p>
        </div>
    </div>

    @if($invoices->isEmpty())
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
            <h2 class="font-black text-xl text-ink mb-2">No Invoices Yet</h2>
            <p class="text-muted text-sm">Invoices will appear here once issued to you.</p>
        </div>
    @else
        <div class="space-y-4">
            @foreach($invoices as $invoice)
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 flex flex-wrap items-center gap-4">
                <div class="flex-1 min-w-48">
                    <div class="font-mono text-xs font-bold text-muted mb-1">{{ $invoice->invoice_number }}</div>
                    <div class="font-black text-xl text-ink">&#8358;{{ number_format($invoice->amount) }}</div>
                    <div class="text-xs text-muted mt-1">Due {{ $invoice->due_date?->format('M j, Y') }}</div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-lg" style="background:{{ $invoice->status === 'paid' ? '#F0FDF4' : '#FFFBEB' }};color:{{ $invoice->status === 'paid' ? '#16A34A' : '#D97706' }}">
                    {{ ucfirst($invoice->status) }}
                </span>
                @if($invoice->status !== 'paid')
                <details class="w-full sm:w-auto">
                    <summary class="cursor-pointer select-none text-xs font-bold text-primary bg-primary/5 rounded-xl px-4 py-2.5">Pay by bank transfer</summary>
                    <div class="mt-4 sm:mt-2 w-full sm:w-96 rounded-2xl bg-gray-50 border border-gray-100 p-5">
                        <form method="POST" action="{{ route('payment.proof') }}" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="invoice_id" value="{{ $invoice->id }}">
                            <label class="block text-xs font-bold text-muted mb-2">Upload transfer proof (image or PDF, max 8&nbsp;MB)</label>
                            <input type="file" name="proof" accept="image/*,.pdf" required
                                   class="block w-full text-sm text-ink file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:bg-primary file:text-white file:text-sm file:font-bold hover:file:bg-primary/90">
                            <button class="mt-4 w-full bg-ink text-white rounded-xl px-5 py-2.5 text-sm font-bold">Submit proof</button>
                        </form>
                    </div>
                </details>
                @endif
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $invoices->links() }}</div>
    @endif
</div>
@endsection