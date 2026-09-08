@extends('layouts.teacher')

@section('title', $course->title)

@push('scripts')
<script>
    function copyLive(link, el) {
        navigator.clipboard.writeText(link)
            .then(() => { el.classList.add('text-mint'); })
            .catch(() => {});
    }
</script>
@endpush

@section('content')
    {{-- Course Info Header --}}
    <div class="card p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Course</div>
                <h1 class="text-2xl font-bold">{{ $course->title }}</h1>
                @if($course->description)
                    <p class="text-sm text-cream/60 mt-1 max-w-xl">{{ $course->description }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <div class="text-center px-4 py-2 rounded-lg bg-mint/10">
                    <div class="text-lg font-bold text-mint">{{ $course->cohorts_count }}</div>
                    <div class="text-xs text-cream/40">Cohorts</div>
                </div>
                <div class="text-center px-4 py-2 rounded-lg bg-sky/10">
                    <div class="text-lg font-bold text-sky">{{ $course->enrollments_count }}</div>
                    <div class="text-xs text-cream/40">Students</div>
                </div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- Cohorts --}}
        <div class="lg:col-span-2">
            <h2 class="text-lg font-bold mb-4">Cohorts</h2>
            <div class="card overflow-hidden">
                @if($cohorts->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                                    <th class="text-left px-5 py-3">Name</th>
                                    <th class="text-center px-5 py-3">Students</th>
                                    <th class="text-center px-5 py-3">Sessions</th>
                                    <th class="text-center px-5 py-3">Status</th>
                                    <th class="text-right px-5 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cohorts as $cohort)
                                    <tr class="table-row">
                                        <td class="px-5 py-3 font-medium">{{ $cohort->name }}</td>
                                        <td class="px-5 py-3 text-center">{{ $cohort->children_count }}</td>
                                        <td class="px-5 py-3 text-center">{{ $cohort->sessions_count }}</td>
                                        <td class="px-5 py-3 text-center">
                                            <span class="badge {{ $cohort->status === 'active' ? 'badge-green' : ($cohort->status === 'completed' ? 'badge-gray' : 'badge-gold') }}">
                                                {{ $cohort->status ?? 'active' }}
                                            </span>
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <a href="{{ route('teacher.cohort', $cohort) }}" class="btn-secondary btn-sm text-xs no-underline">Manage</a>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-cream/40">
                        <p>No cohorts created for this course yet.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Quick Actions --}}
        <div>
            <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
            <div class="space-y-3">
                <a href="{{ route('teacher.assignments', $course) }}" class="card p-4 flex items-center gap-3 hover:border-gold/30 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-gold/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                    </div>
                    <div>
                        <div class="font-semibold text-sm group-hover:text-gold transition-colors">View Assignments</div>
                        <div class="text-xs text-cream/40">{{ $assignments->count() }} total</div>
                    </div>
                </a>

                <a href="{{ route('teacher.dashboard') }}" class="card p-4 flex items-center gap-3 hover:border-mint/30 transition-all group">
                    <div class="w-9 h-9 rounded-lg bg-mint/10 flex items-center justify-center flex-shrink-0">
                        <svg class="w-4 h-4 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    </div>
                    <div>
                        <div class="font-semibold text-sm group-hover:text-mint transition-colors">Back to Dashboard</div>
                        <div class="text-xs text-cream/40">Return to overview</div>
                    </div>
                </a>
            </div>

            {{-- Live Sessions --}}
            <h2 class="text-lg font-bold mt-6 mb-3 flex items-center gap-2">
                <svg class="w-4 h-4 text-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                Live Sessions
            </h2>
            <div class="space-y-2">
                @forelse($liveSessions as $ls)
                    <div class="card p-3 {{ $ls->status === 'live' ? 'border-mint/40' : '' }}">
                        <div class="flex items-start justify-between gap-2">
                            <div class="min-w-0">
                                <div class="text-sm font-medium truncate">{{ $ls->title }}</div>
                                <div class="text-xs text-cream/40 mt-0.5">
                                    @if($ls->status === 'live')
                                        <span class="text-mint font-bold">● On Air</span>
                                    @elseif($ls->status === 'ended')
                                        <span class="text-cream/30">Ended</span>
                                    @else
                                        {{ $ls->scheduled_at?->format('M j, g:i A') }}
                                    @endif
                                </div>
                            </div>
                            @if($ls->status !== 'ended')
                                <div class="flex-shrink-0 flex gap-2">
                                    <button type="button" onclick="copyLive('{{ route('live.room', $ls) }}', this)"
                                            class="text-cream/40 hover:text-mint transition-colors" title="Copy join link">
                                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                                    </button>
                                    <a href="{{ route('live.room', $ls) }}" class="btn-primary btn-sm text-xs no-underline">
                                        {{ $ls->status === 'live' ? 'Open Studio' : 'Host' }}
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                @empty
                    <div class="card p-4 text-xs text-cream/40 text-center border-dashed border-white/10">
                        No live sessions scheduled yet — sessions are staged from the Admin console.
                    </div>
                @endforelse
            </div>

            {{-- Assignments Section --}}
            @if($assignments->count())
                <h2 class="text-lg font-bold mt-6 mb-3">Assignments</h2>
                <div class="space-y-2">
                    @foreach($assignments->take(5) as $assignment)
                        <a href="{{ route('teacher.grade', $assignment) }}" class="card p-3 flex items-center justify-between hover:border-gold/30 transition-all group">
                            <div class="min-w-0">
                                <div class="text-sm font-medium truncate group-hover:text-gold transition-colors">{{ $assignment->title }}</div>
                                <div class="text-xs text-cream/40">{{ $assignment->submissions_count }} submissions</div>
                            </div>
                            <svg class="w-3 h-3 text-cream/30 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    @endforeach
                </div>
            @endif
        </div>
    </div>
@endsection
