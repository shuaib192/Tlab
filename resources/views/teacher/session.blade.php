@extends('layouts.teacher')

@section('title', $session->title)

@section('content')
    {{-- Session Info --}}
    <div class="card p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">
                    <a href="{{ route('teacher.course', $session->course) }}" class="hover:text-mint transition-colors">{{ $session->course->title }}</a>
                    &nbsp;/&nbsp;
                    <a href="{{ route('teacher.cohort', $session->cohort) }}" class="hover:text-mint transition-colors">{{ $session->cohort->name }}</a>
                    &nbsp;/&nbsp; Session
                </div>
                <h1 class="text-2xl font-bold">{{ $session->title }}</h1>
                <div class="flex items-center gap-4 mt-2 text-sm text-cream/60">
                    <span>{{ $session->date->format('l, M d, Y') }}</span>
                    <span>{{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} &ndash; {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}</span>
                    @if($session->status)
                        <span class="badge {{ $session->status === 'completed' ? 'badge-green' : 'badge-gold' }}">{{ $session->status }}</span>
                    @endif
                </div>
            </div>
            <div class="flex items-center gap-2">
                <a href="{{ route('teacher.cohort', $session->cohort) }}" class="btn-secondary btn-sm no-underline">Back to Cohort</a>
            </div>
        </div>
        @if($session->notes)
            <div class="mt-4 p-4 rounded-lg bg-cream/5 text-sm text-cream/70">
                {{ $session->notes }}
            </div>
        @endif
    </div>

    {{-- Attendance Grid --}}
    <div class="card overflow-hidden">
        <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
            <h2 class="text-lg font-bold">Attendance</h2>
            <span class="text-xs text-cream/40">{{ $students->count() }} students</span>
        </div>

        @if($students->count())
            <form method="POST" action="{{ route('teacher.session.attendance', $session) }}" id="attendance-form">
                @csrf
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                                <th class="text-left px-5 py-3 w-8">#</th>
                                <th class="text-left px-5 py-3">Student</th>
                                <th class="text-left px-5 py-3">Status</th>
                                <th class="text-left px-5 py-3">Notes</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($students as $i => $student)
                                @php
                                    $attendance = $attendanceMap->get($student->id);
                                @endphp
                                <tr class="table-row">
                                    <td class="px-5 py-3 text-cream/40 text-xs">{{ $i + 1 }}</td>
                                    <td class="px-5 py-3">
                                        <div class="flex items-center gap-3">
                                            <div class="w-8 h-8 rounded-full bg-mint/10 border border-mint/20 flex items-center justify-center text-xs font-bold text-mint flex-shrink-0">
                                                {{ strtoupper(substr($student->name, 0, 1)) }}
                                            </div>
                                            <div>
                                                <div class="font-medium">{{ $student->name }}</div>
                                                <div class="text-xs text-cream/40">{{ $student->xp }} XP</div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="px-5 py-3">
                                        <select name="attendance[{{ $student->id }}][status]"
                                                class="input text-xs py-2 px-3 w-36">
                                            <option value="present" {{ $attendance && $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="absent" {{ $attendance && $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="late" {{ $attendance && $attendance->status === 'late' ? 'selected' : '' }}>Late</option>
                                            <option value="excused" {{ $attendance && $attendance->status === 'excused' ? 'selected' : '' }}>Excused</option>
                                        </select>
                                    </td>
                                    <td class="px-5 py-3">
                                        <input type="text" name="attendance[{{ $student->id }}][notes]"
                                               value="{{ $attendance->notes ?? '' }}"
                                               placeholder="Optional note..."
                                               class="input text-xs py-2 px-3 w-full max-w-[200px]">
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-white/5 flex justify-end">
                    <button type="submit" class="btn-primary">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                        Save Attendance
                    </button>
                </div>
            </form>
        @else
            <div class="p-8 text-center text-cream/40">
                <p>No students assigned to this cohort.</p>
            </div>
        @endif
    </div>
@endsection
