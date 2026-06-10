@extends('layouts.teacher')

@section('title', 'Dashboard')

@section('content')
    {{-- Stats --}}
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-8">
        <div class="stat-card">
            <div class="stat-value text-mint">{{ $courses->count() }}</div>
            <div class="stat-label">Courses Teaching</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-gold">{{ $activeCohorts }}</div>
            <div class="stat-label">Active Cohorts</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-sky">{{ $totalStudents }}</div>
            <div class="stat-label">Total Students</div>
        </div>
        <div class="stat-card">
            <div class="stat-value text-violet">{{ $upcomingSessions->count() }}</div>
            <div class="stat-label">Upcoming Sessions</div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
        {{-- My Courses --}}
        <div class="lg:col-span-2">
            <div class="flex items-center justify-between mb-4">
                <h2 class="text-lg font-bold">My Courses</h2>
                <span class="badge badge-green">{{ $courses->count() }} active</span>
            </div>
            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                @forelse($courses as $course)
                    <a href="{{ route('teacher.course', $course) }}" class="card p-5 block hover:border-mint/30 transition-all group">
                        <div class="flex items-start justify-between mb-3">
                            <h3 class="font-bold text-base group-hover:text-mint transition-colors">{{ $course->title }}</h3>
                            <svg class="w-4 h-4 text-cream/30 group-hover:text-mint transition-colors flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </div>
                        <div class="flex items-center gap-4 text-xs text-cream/50">
                            <span>{{ $course->cohorts_count }} cohorts</span>
                            <span>{{ $course->enrollments_count }} students</span>
                        </div>
                    </a>
                @empty
                    <div class="card p-8 text-center text-cream/40 col-span-2">
                        <p>You are not assigned to any courses yet.</p>
                    </div>
                @endforelse
            </div>
        </div>

        {{-- Today's Sessions --}}
        <div>
            <h2 class="text-lg font-bold mb-4">Today's Sessions</h2>
            <div class="space-y-3">
                @forelse($todaySessions as $session)
                    <a href="{{ route('teacher.session', $session) }}" class="card p-4 block hover:border-mint/30 transition-all group">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-sm group-hover:text-mint transition-colors">{{ $session->title }}</span>
                            <span class="badge badge-green btn-sm">{{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }}</span>
                        </div>
                        <div class="text-xs text-cream/50">
                            {{ $session->course->title }} &middot; {{ $session->cohort->name ?? 'No cohort' }}
                        </div>
                    </a>
                @empty
                    <div class="card p-6 text-center text-cream/40">
                        <p>No sessions scheduled for today.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>

    {{-- Upcoming Sessions --}}
    <div class="mb-8" id="sessions">
        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Upcoming Sessions</h2>
            <span class="badge badge-gray">{{ $upcomingSessions->count() }} upcoming</span>
        </div>
        <div class="card overflow-hidden">
            @if($upcomingSessions->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                                <th class="text-left px-5 py-3">Date</th>
                                <th class="text-left px-5 py-3">Time</th>
                                <th class="text-left px-5 py-3">Session</th>
                                <th class="text-left px-5 py-3">Course</th>
                                <th class="text-left px-5 py-3">Cohort</th>
                                <th class="text-right px-5 py-3">Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($upcomingSessions as $session)
                                <tr class="table-row">
                                    <td class="px-5 py-3 font-medium">{{ $session->date->format('M d, Y') }}</td>
                                    <td class="px-5 py-3 text-cream/60">{{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }}</td>
                                    <td class="px-5 py-3">{{ $session->title }}</td>
                                    <td class="px-5 py-3 text-cream/60">{{ $session->course->title }}</td>
                                    <td class="px-5 py-3">{{ $session->cohort->name ?? '—' }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <a href="{{ route('teacher.session', $session) }}" class="btn-primary btn-sm text-xs no-underline">Attendance</a>
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            @else
                <div class="p-8 text-center text-cream/40">
                    <p>No upcoming sessions.</p>
                </div>
            @endif
        </div>
    </div>

    {{-- Quick Actions --}}
    <div>
        <h2 class="text-lg font-bold mb-4">Quick Actions</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4">
            <a href="{{ route('teacher.dashboard') }}" class="card p-5 flex items-center gap-4 hover:border-mint/30 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-mint/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-sm group-hover:text-mint transition-colors">View Schedule</div>
                    <div class="text-xs text-cream/40">Check upcoming sessions</div>
                </div>
            </a>
            <a href="{{ route('teacher.dashboard') }}#assignments" class="card p-5 flex items-center gap-4 hover:border-gold/30 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-gold/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                </div>
                <div>
                    <div class="font-bold text-sm group-hover:text-gold transition-colors">Grade Assignments</div>
                    <div class="text-xs text-cream/40">Review student work</div>
                </div>
            </a>
            <a href="{{ route('teacher.dashboard') }}" class="card p-5 flex items-center gap-4 hover:border-sky/30 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-sky/10 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-sky" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <div class="font-bold text-sm group-hover:text-sky transition-colors">View Students</div>
                    <div class="text-xs text-cream/40">Manage cohorts &amp; rosters</div>
                </div>
            </a>
            <a href="{{ url('/') }}" class="card p-5 flex items-center gap-4 hover:border-cream/20 transition-all group">
                <div class="w-10 h-10 rounded-lg bg-cream/5 flex items-center justify-center flex-shrink-0">
                    <svg class="w-5 h-5 text-cream/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                </div>
                <div>
                    <div class="font-bold text-sm group-hover:text-cream transition-colors">View Site</div>
                    <div class="text-xs text-cream/40">Go to TLab homepage</div>
                </div>
            </a>
        </div>
    </div>
@endsection
