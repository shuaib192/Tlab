@extends('layouts.admin')
@section('title', 'Enrollments')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Enrollments</h1>
        <p class="text-cream/50 text-sm">Manage child course enrollments and payment status.</p>
    </div>
    <a href="{{ route('admin.enrollments.create') }}" class="btn-primary self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Enroll a Child
    </a>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <select name="status" class="input w-auto appearance-none">
        <option value="">All Statuses</option>
        <option value="active"    {{ request('status') === 'active'    ? 'selected' : '' }}>Active</option>
        <option value="completed" {{ request('status') === 'completed' ? 'selected' : '' }}>Completed</option>
        <option value="dropped"   {{ request('status') === 'dropped'   ? 'selected' : '' }}>Dropped</option>
    </select>
    <select name="payment_status" class="input w-auto appearance-none">
        <option value="">All Payment</option>
        <option value="paid"    {{ request('payment_status') === 'paid'    ? 'selected' : '' }}>Paid</option>
        <option value="pending" {{ request('payment_status') === 'pending' ? 'selected' : '' }}>Pending</option>
    </select>
    <button type="submit" class="btn-primary">Filter</button>
    @if(request()->hasAny(['status','payment_status']))
    <a href="{{ route('admin.enrollments.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Child</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden sm:table-cell">Course</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden md:table-cell">Status</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">Payment</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($enrollments as $enrollment)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-sm">{{ $enrollment->child->name ?? 'N/A' }}</div>
                        <div class="text-cream/40 text-xs sm:hidden">{{ $enrollment->course->title ?? 'N/A' }}</div>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell">
                        <div class="font-semibold text-sm">{{ $enrollment->course->title ?? 'N/A' }}</div>
                        <div class="text-cream/40 text-xs">{{ $enrollment->course->club->name ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="badge {{ $enrollment->status === 'active' ? 'badge-green' : ($enrollment->status === 'completed' ? 'badge-gold' : 'badge-red') }}">
                            {{ ucfirst($enrollment->status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        <span class="badge {{ $enrollment->payment_status === 'paid' ? 'badge-green' : 'badge-gold' }}">
                            {{ ucfirst($enrollment->payment_status) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            {{-- Inline quick-update form --}}
                            <form method="POST" action="{{ route('admin.enrollments.update', $enrollment) }}" class="flex gap-1">
                                @csrf @method('PUT')
                                <select name="status" class="text-xs bg-white/5 border border-white/10 rounded-lg px-2 py-1.5 text-cream/70 focus:outline-none focus:border-mint">
                                    <option value="active"    {{ $enrollment->status === 'active'    ? 'selected' : '' }}>Active</option>
                                    <option value="completed" {{ $enrollment->status === 'completed' ? 'selected' : '' }}>Completed</option>
                                    <option value="dropped"   {{ $enrollment->status === 'dropped'   ? 'selected' : '' }}>Dropped</option>
                                </select>
                                <select name="payment_status" class="text-xs bg-white/5 border border-white/10 rounded-lg px-2 py-1.5 text-cream/70 focus:outline-none focus:border-mint">
                                    <option value="pending" {{ $enrollment->payment_status === 'pending' ? 'selected' : '' }}>Pending</option>
                                    <option value="paid"    {{ $enrollment->payment_status === 'paid'    ? 'selected' : '' }}>Paid</option>
                                </select>
                                <button type="submit" class="text-xs px-3 py-1.5 rounded-lg bg-mint/10 text-mint border border-mint/20 font-bold hover:bg-mint/20 transition-all">Save</button>
                            </form>
                            <form method="POST" action="{{ route('admin.enrollments.destroy', $enrollment) }}"
                                  onsubmit="return confirm('Remove this enrollment?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger text-xs py-1.5">Remove</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-cream/30 text-sm">No enrollments found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($enrollments->hasPages())
    <div class="px-6 py-4 border-t border-white/5">{{ $enrollments->links() }}</div>
    @endif
</div>
@endsection
