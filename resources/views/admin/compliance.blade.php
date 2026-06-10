@extends('layouts.admin')
@section('title', 'Compliance Log')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Compliance Log</h1>
        <p class="text-cream/50 text-sm">Audit trail of platform activity.</p>
    </div>
</div>

{{-- Filters --}}
<div class="card p-5 mb-6">
    <form method="GET" class="grid grid-cols-1 sm:grid-cols-4 gap-4">
        <div>
            <label class="label">Action Type</label>
            <select name="action" class="input">
                <option value="">All</option>
                <option value="xp_award" {{ request('action') === 'xp_award' ? 'selected' : '' }}>XP Awards</option>
                <option value="enrollment" {{ request('action') === 'enrollment' ? 'selected' : '' }}>Enrollments</option>
                <option value="communication" {{ request('action') === 'communication' ? 'selected' : '' }}>Communications</option>
                <option value="upload" {{ request('action') === 'upload' ? 'selected' : '' }}>Uploads</option>
            </select>
        </div>
        <div>
            <label class="label">From Date</label>
            <input type="date" name="from" class="input" value="{{ request('from') }}">
        </div>
        <div>
            <label class="label">To Date</label>
            <input type="date" name="to" class="input" value="{{ request('to') }}">
        </div>
        <div class="flex items-end gap-2">
            <button type="submit" class="btn-primary flex-1">Filter</button>
            <a href="{{ route('admin.compliance.index') }}" class="btn-secondary flex-1">Clear</a>
        </div>
    </form>
</div>

{{-- Activity List --}}
<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Type</th>
                    <th class="text-left px-5 py-3">Description</th>
                    <th class="text-left px-5 py-3">User</th>
                    <th class="text-left px-5 py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($activities as $activity)
                <tr class="table-row">
                    <td class="px-5 py-3">
                        <span class="badge {{ 
                            Str::startsWith($activity['type'], 'xp') ? 'badge-green' : 
                            (Str::startsWith($activity['type'], 'enrollment') ? 'badge-gold' : 
                            (Str::startsWith($activity['type'], 'communication') ? 'badge-gray' : 'badge-red')) 
                        }}">
                            {{ str_replace('_', ' ', $activity['type']) }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-cream/80 max-w-md truncate">{{ $activity['description'] }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ $activity['user_name'] }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ \Carbon\Carbon::parse($activity['created_at'])->format('M d, Y g:i A') }}</td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-5 py-12 text-center text-cream/40">No activity found matching the filters.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
