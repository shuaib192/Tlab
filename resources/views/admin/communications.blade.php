@extends('layouts.admin')
@section('title', 'Communications')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Communications</h1>
        <p class="text-cream/50 text-sm">All teacher-parent communications across the platform.</p>
    </div>
    <span class="badge badge-gray">{{ $logs->total() }} total</span>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Subject</th>
                    <th class="text-left px-5 py-3">Teacher</th>
                    <th class="text-left px-5 py-3">Parent</th>
                    <th class="text-left px-5 py-3">Child</th>
                    <th class="text-left px-5 py-3">Type</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="table-row">
                    <td class="px-5 py-3 font-medium max-w-xs truncate" title="{{ $log->subject }}">
                        {{ $log->subject }}
                        @if(!$log->is_read)
                        <span class="w-2 h-2 rounded-full bg-mint inline-block ml-2"></span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-cream/60">{{ $log->teacher?->name ?? 'N/A' }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ $log->parent?->name ?? 'N/A' }}</td>
                    <td class="px-5 py-3">{{ $log->child?->name ?? 'N/A' }}</td>
                    <td class="px-5 py-3">
                        <span class="badge {{ $log->type === 'concern' ? 'badge-red' : ($log->type === 'feedback' ? 'badge-gold' : 'badge-gray') }}">
                            {{ $log->type }}
                        </span>
                    </td>
                    <td class="px-5 py-3">
                        <span class="badge {{ $log->is_read ? 'badge-gray' : 'badge-green' }}">
                            {{ $log->is_read ? 'Read' : 'Unread' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-cream/60">{{ $log->created_at->format('M d, Y g:i A') }}</td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-5 py-12 text-center text-cream/40">No communications found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $logs->links() }}</div>
@endsection
