@extends('layouts.app')
@section('title', "{$child->name} - Progress Details")
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <a href="{{ route('teacher.progress', $course) }}" class="text-muted hover:text-ink text-sm font-semibold mb-2 inline-flex items-center gap-1">&larr; Back to Class Progress</a>

    <div class="flex items-center justify-between mb-8 mt-3">
        <div>
            <h1 class="font-black text-2xl text-ink">{{ $child->name }}</h1>
            <p class="text-muted text-sm font-semibold">{{ $course->title }} &middot; {{ $child->rank }} &middot; {{ number_format($child->xp) }} XP</p>
        </div>
    </div>

    @foreach($moduleData as $md)
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden mb-6">
        <div class="px-6 py-4 border-b border-gray-50 flex items-center justify-between">
            <h2 class="font-black text-base text-ink">{{ $md['module']->title }}</h2>
            <div class="flex items-center gap-2">
                <div class="w-20 h-2 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full bg-primary" style="width:{{ $md['progress'] }}%"></div>
                </div>
                <span class="text-xs font-bold text-primary">{{ $md['progress'] }}%</span>
            </div>
        </div>
        <div class="p-2">
            @foreach($md['lessons'] as $l)
            <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-8 h-8 rounded-lg flex items-center justify-center {{ $l['assessment_passed'] ? 'bg-primary/10 text-primary' : 'bg-gray-100 text-muted' }}">
                        {!! $l['assessment_passed'] ? '<svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>' : '<span class="text-xs font-bold">'.($loop->iteration).'</span>' !!}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-ink">{{ $l['lesson']->title }}</div>
                        <div class="text-xs text-muted flex gap-3 mt-0.5">
                            @if($l['assessment_score'])
                            <span>Score: <strong>{{ $l['assessment_score'] }}</strong></span>
                            @endif
                            @foreach($l['submissions'] as $sub)
                            <span>{{ $sub->assignment->title }}: <strong>{{ $sub->score ?? 'Ungraded' }}/{{ $sub->assignment->max_score }}</strong></span>
                            @endforeach
                        </div>
                    </div>
                </div>
                <span class="text-xs font-bold px-3 py-1.5 rounded-full {{ $l['assessment_passed'] ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-muted' }}">
                    {{ $l['assessment_passed'] ? 'Completed' : 'Pending' }}
                </span>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-black text-base text-ink mb-4">Attendance Record</h2>
        @if($attendance->isNotEmpty())
        <div class="space-y-3">
            @foreach($attendance as $a)
            <div class="flex items-center justify-between py-2 px-4 rounded-xl bg-gray-50">
                <div>
                    <div class="font-bold text-sm text-ink">{{ $a->session->title ?? 'Session' }}</div>
                    <div class="text-xs text-muted">{{ $a->session->date?->format('M j, Y') ?? 'N/A' }}</div>
                </div>
                <span class="text-xs font-bold px-3 py-1 rounded-full {{ $a->status === 'present' ? 'bg-green-50 text-green-600' : ($a->status === 'late' ? 'bg-amber-50 text-amber-600' : 'bg-red-50 text-red-600') }}">
                    {{ ucfirst($a->status) }}
                </span>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-muted/50 text-sm font-semibold py-8">No attendance records yet</p>
        @endif
    </div>
</div>
@endsection
