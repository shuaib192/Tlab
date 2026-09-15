@extends('layouts.admin')
@section('title', 'Programme Registrations')

@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">

    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-black text-2xl text-ink">Programme Registrations</h1>
            <p class="text-muted text-sm">Foundational Skills Programme — who has registered and paid</p>
        </div>
    </div>

    <form method="GET" class="flex flex-wrap gap-3 mb-6">
        <select name="status" class="border border-gray-200 rounded-xl px-4 py-2.5 text-sm font-bold text-ink bg-white">
            <option value="">All statuses</option>
            @foreach(['pending','paid','failed'] as $s)
                <option value="{{ $s }}" @selected(request('status')===$s)>{{ ucfirst($s) }}</option>
            @endforeach
        </select>
        <button class="bg-ink text-white rounded-xl px-5 py-2.5 text-sm font-bold" type="submit">Filter</button>
        @if(request('status'))
            <a href="{{ route('admin.programme-registrations.index') }}" class="border border-gray-200 rounded-xl px-5 py-2.5 text-sm font-bold text-muted">Clear</a>
        @endif
    </form>

    <div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Paid Revenue</div>
            <div class="font-black text-3xl text-ink">&#8358;{{ number_format($totalRevenue) }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Paid Registrations</div>
            <div class="font-black text-3xl text-primary">{{ $paidCount }}</div>
        </div>
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5">
            <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Pending Payments</div>
            <div class="font-black text-3xl text-amber-600">{{ $pendingCount }}</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
            <table class="w-full text-sm">
                <thead>
                    <tr class="bg-gray-50">
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase">Child</th>
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase">Parent</th>
                        <th class="text-left px-6 py-4 font-black text-ink text-xs uppercase">Programme</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase">Amount</th>
                        <th class="text-center px-6 py-4 font-black text-ink text-xs uppercase">Status</th>
                        <th class="text-right px-6 py-4 font-black text-ink text-xs uppercase">Date</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-gray-50">
                    @foreach($registrations as $registration)
                    <tr class="hover:bg-gray-50/50 cursor-pointer" onclick="window.location='{{ route('admin.programme-registrations.show', $registration) }}'">
                        <td class="px-6 py-4">
                            <span class="font-semibold text-ink">{{ $registration->child_name }}</span>
                            <span class="text-xs text-muted block">Age {{ $registration->child_age }} · {{ ucfirst($registration->device) }}</span>
                        </td>
                        <td class="px-6 py-4">
                            <span class="font-semibold text-ink">{{ $registration->parent_name }}</span>
                            <span class="text-xs text-muted block">{{ $registration->email }} · {{ $registration->phone }}</span>
                        </td>
                        <td class="px-6 py-4 text-muted">{{ $registration->programme }}</td>
                        <td class="px-6 py-4 text-right font-bold text-ink">&#8358;{{ number_format($registration->amount) }}</td>
                        <td class="px-6 py-4 text-center">
                            <span class="text-xs font-bold px-3 py-1.5 rounded-lg" style="background:{{ $registration->status === 'paid' ? '#F0FDF4' : ($registration->status === 'pending' ? '#FFFBEB' : '#FEF2F2') }};color:{{ $registration->status === 'paid' ? '#16A34A' : ($registration->status === 'pending' ? '#D97706' : '#DC2626') }}">
                                {{ ucfirst($registration->status) }}
                            </span>
                        </td>
                        <td class="px-6 py-4 text-right text-muted text-xs">{{ $registration->created_at->format('M j, Y') }}</td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    <div class="mt-6">{{ $registrations->links() }}</div>
</div>
@endsection