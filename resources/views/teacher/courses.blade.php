@extends('layouts.teacher')

@section('title', 'My Courses')

@section('content')
    <div class="card p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Teaching</div>
                <h1 class="text-2xl font-bold">My Courses</h1>
                <p class="text-sm text-cream/60 mt-1">{{ $courses->count() }} course{{ $courses->count() !== 1 ? 's' : '' }}</p>
            </div>
            <div class="flex gap-2">
                <a href="{{ route('teacher.courses.create') }}" class="btn-primary btn-sm no-underline">+ New Course</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-4">
        @forelse($courses as $course)
            <a href="{{ route('teacher.course', $course) }}" class="card p-5 block hover:border-mint/30 transition-all group">
                <div class="flex items-start justify-between mb-3">
                    <span class="badge badge-green text-xs">
                        @if($course->cohorts_count > 0)
                            {{ $course->cohorts_count }} cohort{{ $course->cohorts_count !== 1 ? 's' : '' }}
                        @else
                            No cohorts
                        @endif
                    </span>
                    <svg class="w-4 h-4 text-cream/30 group-hover:text-mint transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </div>
                <h3 class="font-bold text-base mb-1 group-hover:text-mint transition-colors">{{ $course->title }}</h3>
                @if($course->club)
                    <p class="text-xs text-cream/50 mb-3">{{ $course->club->name }}</p>
                @endif
                <div class="flex items-center justify-between text-xs text-cream/50">
                    <span>{{ $course->enrollments_count }} student{{ $course->enrollments_count !== 1 ? 's' : '' }}</span>
                    <span class="text-cream/30">{{ ucfirst($course->level ?? '') }}</span>
                </div>
            </a>
        @empty
            <div class="card p-12 text-center col-span-full">
                <div class="w-16 h-16 rounded-full bg-cream/5 flex items-center justify-center mx-auto mb-4">
                    <svg class="w-8 h-8 text-cream/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <p class="text-cream/50 font-medium">You are not assigned to any courses yet.</p>
                <p class="text-xs text-cream/30 mt-1">Create a new course or ask your admin to assign you one.</p>
                <div class="mt-5 flex justify-center">
                    <a href="{{ route('teacher.courses.create') }}" class="btn-primary btn-sm no-underline">+ Create your first course</a>
                </div>
            </div>
        @endforelse
    </div>
@endsection