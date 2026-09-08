@extends('layouts.app')
@section('title', "Progress - {$course->title}")
@section('content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8">
    <div class="flex items-center justify-between mb-8">
        <div>
            <a href="{{ route('teacher.course', $course) }}" class="text-muted hover:text-ink text-sm font-semibold mb-2 inline-flex items-center gap-1">&larr; Back to Course</a>
            <h1 class="font-black text-2xl text-ink mt-1">Student Progress</h1>
            <p class="text-muted text-sm font-semibold">{{ $course->title }}</p>
        </div>
        <div class="text-right">
            <div class="font-black text-3xl text-primary">{{ round($overallProgress) }}%</div>
            <div class="text-xs text-muted font-bold uppercase">Class Average</div>
        </div>
    </div>

    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="overflow-x-auto">
        <table class="w-full">
            <thead><tr class="border-b border-gray-50 bg-gray-50/50">
                <th class="text-left px-6 py-4 text-xs font-bold uppercase text-muted">Student</th>
                <th class="text-center px-6 py-4 text-xs font-bold uppercase text-muted">Progress</th>
                <th class="text-center px-6 py-4 text-xs font-bold uppercase text-muted">Lessons</th>
                <th class="text-center px-6 py-4 text-xs font-bold uppercase text-muted">Assignments</th>
                <th class="text-center px-6 py-4 text-xs font-bold uppercase text-muted">Avg Score</th>
                <th class="text-center px-6 py-4 text-xs font-bold uppercase text-muted">Attendance</th>
                <th class="text-center px-6 py-4 text-xs font-bold uppercase text-muted">Actions</th>
            </tr></thead>
            <tbody>
                @forelse($students as $s)
                <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center font-bold text-primary text-sm">{{ strtoupper(substr($s['child']->name, 0, 1)) }}</div>
                            <div>
                                <div class="font-bold text-sm text-ink">{{ $s['child']->name }}</div>
                                <div class="text-xs text-muted">{{ $s['child']->rank }} &middot; {{ number_format($s['child']->xp) }} XP</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <div class="flex items-center gap-2 justify-center">
                            <div class="w-24 h-2 rounded-full bg-gray-100 overflow-hidden">
                                <div class="h-full rounded-full {{ $s['progress_pct'] >= 80 ? 'bg-primary' : ($s['progress_pct'] >= 40 ? 'bg-amber' : 'bg-coral') }}" style="width:{{ $s['progress_pct'] }}%"></div>
                            </div>
                            <span class="text-xs font-bold {{ $s['progress_pct'] >= 80 ? 'text-primary' : ($s['progress_pct'] >= 40 ? 'text-amber' : 'text-coral') }}">{{ $s['progress_pct'] }}%</span>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-bold text-ink">{{ $s['completed_lessons'] }}/{{ $s['total_lessons'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-bold text-ink">{{ $s['graded_assignments'] }}/{{ $s['total_assignments'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-bold {{ is_numeric($s['avg_score']) && $s['avg_score'] >= 70 ? 'text-primary' : 'text-ink' }}">{{ $s['avg_score'] }}</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <span class="text-sm font-bold {{ $s['attendance_pct'] >= 80 ? 'text-primary' : ($s['attendance_pct'] >= 50 ? 'text-amber' : 'text-coral') }}">{{ $s['attendance_pct'] }}%</span>
                    </td>
                    <td class="px-6 py-4 text-center">
                        <a href="{{ route('teacher.progress.student', [$course, $s['child']]) }}" class="text-primary font-bold text-xs hover:underline">View Details</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="px-6 py-12 text-center text-muted/50 text-sm font-semibold">No enrolled students found.</td></tr>
                @endforelse
            </tbody>
        </table>
        </div>
    </div>
@endsection
