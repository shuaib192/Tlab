@extends('layouts.teacher')

@section('title', 'Assignments — ' . $course->title)

@section('content')
    <div class="card p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">
                    <a href="{{ route('teacher.course', $course) }}" class="hover:text-mint transition-colors">{{ $course->title }}</a>
                    &nbsp;/&nbsp; Assignments
                </div>
                <h1 class="text-2xl font-bold">Assignments</h1>
                <p class="text-sm text-cream/60 mt-1">{{ $assignments->count() }} total assignments</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('teacher.assignments.create', $course) }}" class="btn-primary btn-sm no-underline">Create Assignment</a>
                <a href="{{ route('teacher.course', $course) }}" class="btn-secondary btn-sm no-underline">Back to Course</a>
            </div>
        </div>
    </div>

    @if($assignments->count())
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
            @foreach($assignments as $assignment)
                <div class="card p-5 flex flex-col">
                    <div class="flex items-start justify-between mb-3">
                        <span class="badge {{ $assignment->submissions_count > 0 ? 'badge-green' : 'badge-gray' }} text-xs">
                            {{ $assignment->submissions_count }} submission{{ $assignment->submissions_count !== 1 ? 's' : '' }}
                        </span>
                        @if($assignment->due_date)
                            <span class="text-xs text-cream/40">
                                @if($assignment->due_date->isPast())
                                    <span class="text-terra">{{ $assignment->due_date->format('M d') }}</span>
                                @else
                                    {{ $assignment->due_date->format('M d, Y') }}
                                @endif
                            </span>
                        @endif
                    </div>
                    <h3 class="font-bold text-sm mb-1">{{ $assignment->title }}</h3>
                    @if($assignment->max_score)
                        <p class="text-xs text-cream/50 mb-3">Max score: {{ $assignment->max_score }}</p>
                    @endif
                    <div class="mt-auto pt-3 flex items-center justify-between">
                        <span class="text-xs text-cream/40">
                            @if($assignment->due_date)
                                Due {{ $assignment->due_date->diffForHumans() }}
                            @else
                                No due date
                            @endif
                        </span>
                        <a href="{{ route('teacher.grade', $assignment) }}" class="btn-primary btn-sm text-xs no-underline">
                            Grade
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-cream/5 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-cream/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-cream/50 font-medium">No assignments found for this course.</p>
            <p class="text-xs text-cream/30 mt-1">Assignments are created through the admin panel or curriculum builder.</p>
        </div>
    @endif
@endsection
