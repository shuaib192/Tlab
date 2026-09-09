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
                @if($session->meeting_url)
                    <a href="{{ $session->meeting_url }}" target="_blank" rel="noopener noreferrer" class="btn-accent btn-sm no-underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                        Join Meeting
                    </a>
                @endif
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
            <div class="flex items-center gap-4">
                @if($students->count())
                    <label class="flex items-center gap-2 text-xs text-cream/60 cursor-pointer select-none">
                        <input type="checkbox" id="bulk-all" class="accent-mint" />
                        Mark all Present
                    </label>
                @endif
                <span class="text-xs text-cream/40">{{ $students->count() }} students</span>
            </div>
        </div>

        @if($students->count())
            <form method="POST" action="{{ route('teacher.session.attendance', $session) }}" id="attendance-form">
                @csrf
                <input type="hidden" name="bulk_present" id="bulk-present-field" value="0">
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
                                    $isOld = $attendance && $attendance->marked_at && $attendance->marked_at->diffInHours(now()) >= 24;
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
                                                class="input text-xs py-2 px-3 w-36 attendance-select"
                                                data-child-id="{{ $student->id }}">
                                            <option value="present" {{ $attendance && $attendance->status === 'present' ? 'selected' : '' }}>Present</option>
                                            <option value="absent" {{ $attendance && $attendance->status === 'absent' ? 'selected' : '' }}>Absent</option>
                                            <option value="late" {{ $attendance && $attendance->status === 'late' ? 'selected' : '' }}>Late</option>
                                            <option value="excused" {{ $attendance && $attendance->status === 'excused' ? 'selected' : '' }}>Excused</option>
                                        </select>
                                        @if($isOld)
                                            <div class="text-[10px] text-amber-400/80 mt-1">
                                                Last marked {{ $attendance->marked_at->diffForHumans() }} — reason required to change
                                            </div>
                                        @endif
                                        @if($errors->has("attendance.{$student->id}.edit_reason"))
                                            <div class="text-[10px] text-red-400 mt-1">
                                                {{ $errors->first("attendance.{$student->id}.edit_reason") }}
                                            </div>
                                        @endif
                                    </td>
                                    <td class="px-5 py-3">
                                        <input type="text" name="attendance[{{ $student->id }}][notes]"
                                               value="{{ $attendance->notes ?? '' }}"
                                               placeholder="Optional note..."
                                               class="input text-xs py-2 px-3 w-full max-w-[200px]">
                                        @if($isOld)
                                            <input type="text" name="attendance[{{ $student->id }}][edit_reason]"
                                                   placeholder="Reason for edit (required)..."
                                                   class="input text-xs py-2 px-3 w-full max-w-[250px] mt-1 edit-reason"
                                                   data-child-id="{{ $student->id }}">
                                        @endif
                                    </td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
                <div class="px-5 py-4 border-t border-white/5 flex justify-end gap-3">
                    <button type="button" id="bulk-confirm-btn" class="btn-accent btn-sm hidden">
                        Confirm Bulk Mark
                    </button>
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

    {{-- Bulk confirm modal --}}
    <div id="bulk-modal" class="fixed inset-0 z-50 items-center justify-center bg-black/60 hidden">
        <div class="card p-6 max-w-sm mx-4">
            <h3 class="text-lg font-bold mb-2">Mark all as Present?</h3>
            <p class="text-sm text-cream/60 mb-4">
                This will mark <strong id="bulk-count">0</strong> students as Present.
                Absent/Late/Excused rows will be skipped — mark exceptions first.
            </p>
            <div class="flex justify-end gap-3">
                <button type="button" id="bulk-cancel" class="btn-secondary btn-sm">Cancel</button>
                <button type="button" id="bulk-proceed" class="btn-primary btn-sm">Confirm</button>
            </div>
        </div>
    </div>

    @push('scripts')
    <script>
    document.addEventListener('DOMContentLoaded', () => {
        const form = document.getElementById('attendance-form');
        const bulkAll = document.getElementById('bulk-all');
        const bulkField = document.getElementById('bulk-present-field');
        const bulkBtn = document.getElementById('bulk-confirm-btn');
        const bulkModal = document.getElementById('bulk-modal');
        const bulkCount = document.getElementById('bulk-count');
        const bulkCancel = document.getElementById('bulk-cancel');
        const bulkProceed = document.getElementById('bulk-proceed');
        const selects = document.querySelectorAll('.attendance-select');

        // Bulk mark flow
        bulkAll.addEventListener('change', () => {
            if (bulkAll.checked) {
                let count = 0;
                selects.forEach(sel => {
                    if (sel.value !== 'present') count++;
                    sel.value = 'present';
                });
                bulkField.value = '1';
                if (count > 0) {
                    bulkBtn.classList.remove('hidden');
                    bulkCount.textContent = selects.length;
                } else {
                    form.submit();
                }
            } else {
                bulkField.value = '0';
                bulkBtn.classList.add('hidden');
            }
        });

        bulkBtn.addEventListener('click', () => {
            bulkModal.classList.remove('hidden');
            bulkModal.classList.add('flex');
        });

        bulkCancel.addEventListener('click', () => {
            bulkModal.classList.add('hidden');
            bulkModal.classList.remove('flex');
            bulkAll.checked = false;
            bulkField.value = '0';
            bulkBtn.classList.add('hidden');
        });

        bulkProceed.addEventListener('click', () => {
            bulkModal.classList.add('hidden');
            bulkModal.classList.remove('flex');
            form.submit();
        });
    });
    </script>
    @endpush
@endsection
