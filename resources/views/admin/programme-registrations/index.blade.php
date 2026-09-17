@extends('layouts.admin')
@section('title', 'Programme Registrations')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Programme Registrations</h1>
        <p class="text-cream/50 text-sm">Foundational Skills Programme — who has registered and paid.</p>
    </div>
    <div class="flex items-center gap-3">
        <span class="badge badge-green">Foundational Skills</span>
        <span class="text-xs font-bold text-cream/40">{{ $totalCount }} total application{{ $totalCount === 1 ? '' : 's' }}</span>
    </div>
</div>

{{-- Stats --}}
<div class="grid grid-cols-1 sm:grid-cols-2 xl:grid-cols-4 gap-4 mb-8">
    <div class="card p-5 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(78,153,102,0.15);color:#4E9966;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2z"/></svg>
        </div>
        <div>
            <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Paid Revenue</div>
            <div class="font-display font-bold text-2xl text-cream">&#8358;{{ number_format($totalRevenue) }}</div>
            <div class="text-xs text-cream/30 font-semibold mt-1">Confirmed payments</div>
        </div>
    </div>

    <div class="card p-5 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(78,153,102,0.15);color:#4E9966;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Paid Registrations</div>
            <div class="font-display font-bold text-2xl text-cream">{{ $paidCount }}</div>
            <div class="text-xs text-cream/30 font-semibold mt-1">Learners secured</div>
        </div>
    </div>

    <div class="card p-5 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(212,162,36,0.15);color:#D4A224;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
        </div>
        <div>
            <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Pending Payments</div>
            <div class="font-display font-bold text-2xl text-cream">{{ $pendingCount }}</div>
            <div class="text-xs text-cream/30 font-semibold mt-1">Awaiting checkout</div>
        </div>
    </div>

    <div class="card p-5 flex items-start gap-4">
        <div class="w-11 h-11 rounded-xl flex items-center justify-center flex-shrink-0" style="background:rgba(194,75,30,0.15);color:#C24B1E;">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
        </div>
        <div>
            <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Failed Payments</div>
            <div class="font-display font-bold text-2xl text-cream">{{ $failedCount }}</div>
            <div class="text-xs text-cream/30 font-semibold mt-1">Checkout abandoned</div>
        </div>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <input type="text" name="q" value="{{ request('q') }}"
           class="input sm:max-w-xs" placeholder="Search child, parent, email or ref...">
    <select name="status" class="input sm:w-auto appearance-none">
        <option value="">All Statuses</option>
        @foreach(['pending','paid','failed'] as $s)
            <option value="{{ $s }}" @selected(request('status') === $s)>{{ ucfirst($s) }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-primary">Filter</button>
    @if(request()->hasAny(['q','status']))
        <a href="{{ route('admin.programme-registrations.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

{{-- Table --}}
<div class="card overflow-hidden">
    @if($registrations->isEmpty())
        <div class="py-20 text-center">
            <div class="w-14 h-14 mx-auto mb-4 rounded-2xl flex items-center justify-center" style="background:rgba(250,245,232,0.06);color:rgba(250,245,232,0.3);">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <div class="text-cream font-bold mb-1">No registrations found</div>
            <div class="text-sm text-cream/40">Try clearing your filters, or share the enrolment link.</div>
        </div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Child</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Parent</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">Programme</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden md:table-cell">Payment</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Amount</th>
                    <th class="text-center px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">Date</th>
                </tr>
            </thead>
            <tbody>
                @foreach($registrations as $registration)
                <tr class="table-row cursor-pointer" onclick="window.location='{{ route('admin.programme-registrations.show', $registration) }}'">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <span class="w-9 h-9 rounded-full flex items-center justify-center font-bold text-xs flex-shrink-0" style="background:rgba(78,153,102,0.18);color:#6FBE8B;">
                                {{ strtoupper(substr($registration->child_name, 0, 1)) }}{{ strtoupper(substr($registration->child_name, strpos($registration->child_name, ' ') ? strpos($registration->child_name, ' ') + 1 : 1, 1)) }}
                            </span>
                            <div>
                                <div class="font-bold text-cream text-sm">{{ $registration->child_name }}</div>
                                <div class="text-xs text-cream/40">Age {{ $registration->child_age }} &middot; {{ ucfirst($registration->device) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <div class="font-semibold text-cream text-sm">{{ $registration->parent_name }}</div>
                        <div class="text-xs text-cream/40">{{ $registration->email }} &middot; {{ $registration->phone }}</div>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        <span class="text-sm text-cream/70">{{ $registration->programme }}</span>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="badge {{ $registration->payment_option === 'full' ? 'badge-gold' : 'badge-gray' }}">{{ $registration->payment_option === 'full' ? 'Full' : 'Monthly' }}</span>
                    </td>
                    <td class="px-6 py-4 text-right font-display font-bold text-cream">&#8358;{{ number_format($registration->amount) }}</td>
                    <td class="px-6 py-4 text-center">
                        <span class="badge {{ $registration->status === 'paid' ? 'badge-green' : ($registration->status === 'pending' ? 'badge-gold' : 'badge-red') }}">
                            {{ $registration->status === 'paid' ? 'Paid' : ucfirst($registration->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 text-right text-xs text-cream/40 hidden lg:table-cell">{{ $registration->created_at->format('M j, Y') }}</td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

<div class="mt-6">{{ $registrations->links() }}</div>

@endsection