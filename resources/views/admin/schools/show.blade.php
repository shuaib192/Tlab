@extends('layouts.admin')
@section('title', $school->name)

@section('content')
<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.schools.index') }}" class="btn-secondary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back
    </a>
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">{{ $school->name }}</h1>
        <p class="text-cream/50 text-sm">{{ $school->city ?? '—' }}, {{ $school->state ?? '—' }} &middot; {{ $school->country }}</p>
    </div>
    <span class="badge {{ $school->status === 'active' ? 'badge-green' : 'badge-red' }} ml-auto">{{ $school->status }}</span>
</div>

{{-- School Details --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="card p-5">
        <div class="text-cream/50 text-xs font-bold uppercase tracking-wider mb-1">Email</div>
        <div class="font-semibold">{{ $school->email ?? '—' }}</div>
    </div>
    <div class="card p-5">
        <div class="text-cream/50 text-xs font-bold uppercase tracking-wider mb-1">Phone</div>
        <div class="font-semibold">{{ $school->phone ?? '—' }}</div>
    </div>
    <div class="card p-5">
        <div class="text-cream/50 text-xs font-bold uppercase tracking-wider mb-1">Max Students</div>
        <div class="font-semibold">{{ number_format($school->max_students) }}</div>
    </div>
    <div class="card p-5">
        <div class="text-cream/50 text-xs font-bold uppercase tracking-wider mb-1">Subscription</div>
        <div class="font-semibold capitalize">{{ $school->subscription_tier }}</div>
    </div>
    <div class="card p-5 lg:col-span-2">
        <div class="text-cream/50 text-xs font-bold uppercase tracking-wider mb-1">Address</div>
        <div class="font-semibold">{{ $school->address ?? '—' }}</div>
    </div>
</div>

{{-- Licenses --}}
<div class="card p-6 mb-8">
    <div class="flex items-center justify-between mb-5">
        <h2 class="font-display text-lg font-bold">Licenses</h2>
        <span class="badge badge-green">{{ $school->licenses->count() }} {{ Str::plural('license', $school->licenses->count()) }}</span>
    </div>

    @if($school->licenses->isEmpty())
    <p class="text-cream/40 text-sm text-center py-6">No licenses assigned yet.</p>
    @else
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                    <th class="text-left px-4 py-3">Type</th>
                    <th class="text-left px-4 py-3">Seats</th>
                    <th class="text-left px-4 py-3">Used</th>
                    <th class="text-left px-4 py-3">Available</th>
                    <th class="text-left px-4 py-3">Start</th>
                    <th class="text-left px-4 py-3">End</th>
                    <th class="text-left px-4 py-3">Status</th>
                </tr>
            </thead>
            <tbody>
                @foreach($school->licenses as $license)
                <tr class="table-row">
                    <td class="px-4 py-3 font-medium capitalize">{{ $license->type }}</td>
                    <td class="px-4 py-3">{{ $license->seats }}</td>
                    <td class="px-4 py-3">{{ $license->used_seats }}</td>
                    <td class="px-4 py-3 font-semibold {{ $license->seatsRemaining() > 0 ? 'text-mint' : 'text-terra' }}">
                        {{ $license->seatsRemaining() }}
                    </td>
                    <td class="px-4 py-3 text-cream/60">{{ $license->start_date?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-4 py-3 text-cream/60">{{ $license->end_date?->format('M d, Y') ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <span class="badge {{ $license->status === 'active' ? 'badge-green' : 'badge-gray' }}">
                            {{ $license->status }}
                        </span>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Add License --}}
<div class="card p-6">
    <h2 class="font-display text-lg font-bold mb-4">Add License</h2>
    <form method="POST" action="{{ route('admin.schools.licenses.store', $school) }}" class="grid grid-cols-1 sm:grid-cols-5 gap-4">
        @csrf
        <div>
            <label class="label">Type</label>
            <select name="type" class="input" required>
                <option value="annual">Annual</option>
                <option value="semester">Semester</option>
                <option value="quarterly">Quarterly</option>
            </select>
        </div>
        <div>
            <label class="label">Seats</label>
            <input type="number" name="seats" class="input" placeholder="30" required min="1">
        </div>
        <div>
            <label class="label">Start</label>
            <input type="date" name="start_date" class="input">
        </div>
        <div>
            <label class="label">End</label>
            <input type="date" name="end_date" class="input">
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">Add License</button>
        </div>
    </form>
</div>
@endsection
