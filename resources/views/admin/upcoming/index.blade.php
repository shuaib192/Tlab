@extends('layouts.admin')
@section('title', 'Upcoming Classes')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Upcoming Classes</h1>
        <p class="text-cream/50 text-sm">Schedule and manage upcoming classes for students — visible to all enrolled learners.</p>
    </div>
    <button onclick="document.getElementById('create-modal').classList.toggle('hidden')" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Schedule Class
    </button>
</div>

{{-- Create form (inline) --}}
<div id="create-modal" class="hidden card p-6 mb-8">
    <h3 class="font-bold text-cream mb-4">Schedule Upcoming Class</h3>
    <form method="POST" action="{{ route('admin.upcoming.store') }}" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="label">Cohort *</label>
                <select name="cohort_id" required class="input">
                    <option value="">Select cohort</option>
                    @foreach($cohorts as $cohort)
                        <option value="{{ $cohort->id }}">{{ $cohort->name }} — {{ $cohort->course->title ?? 'Course #'.$cohort->course_id }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Class Title *</label>
                <input type="text" name="title" required class="input" placeholder="e.g. STEAM Robotics — Intro to Sensors">
            </div>
            <div>
                <label class="label">Date *</label>
                <input type="date" name="date" required class="input" min="{{ date('Y-m-d') }}">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="label">Start Time *</label>
                    <input type="time" name="start_time" required class="input">
                </div>
                <div>
                    <label class="label">End Time *</label>
                    <input type="time" name="end_time" required class="input">
                </div>
            </div>
            <div class="md:col-span-2">
                <label class="label">Meeting URL</label>
                <input type="url" name="meeting_url" class="input" placeholder="https://meet.google.com/... or Zoom link">
            </div>
            <div class="md:col-span-2">
                <label class="label">Notes</label>
                <textarea name="notes" rows="2" class="input" placeholder="What will students learn? Materials needed?"></textarea>
            </div>
        </div>
        <div class="flex gap-3">
            <button type="submit" class="btn-primary">Schedule Class</button>
            <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="btn-secondary">Cancel</button>
        </div>
    </form>
</div>

{{-- Upcoming --}}
<div class="card overflow-hidden mb-8">
    <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
        <h2 class="font-display font-bold">Scheduled — Upcoming</h2>
        <span class="badge badge-green">{{ $upcoming->count() }} upcoming</span>
    </div>
    @if($upcoming->isEmpty())
        <div class="px-6 py-12 text-center text-cream/30 text-sm">No upcoming classes scheduled. Use "Schedule Class" to create one.</div>
    @else
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Class</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40 hidden md:table-cell">Cohort / Course</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">When</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">Status</th>
                    <th class="text-right px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($upcoming as $s)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-sm">{{ $s->title }}</div>
                        @if($s->meeting_url)<a href="{{ $s->meeting_url }}" target="_blank" class="text-mint text-xs hover:underline">Join link →</a>@endif
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell text-sm text-cream/60">
                        {{ $s->cohort->name ?? '—' }}<br><span class="text-xs text-cream/40">{{ $s->course->title ?? '' }}</span>
                    </td>
                    <td class="px-6 py-4 text-sm">
                        <span class="font-bold text-cream">{{ \Carbon\Carbon::parse($s->date)->format('d M Y') }}</span><br>
                        <span class="text-xs text-cream/50">{{ substr($s->start_time,0,5) }} – {{ substr($s->end_time,0,5) }}</span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell"><span class="badge badge-green">{{ $s->status }}</span></td>
                    <td class="px-6 py-4 text-right"><a href="{{ route('admin.upcoming.show', $s) }}" class="btn-secondary text-xs px-3 py-2">Manage</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @endif
</div>

{{-- Past --}}
@if($past->isNotEmpty())
<div class="card overflow-hidden">
    <div class="px-6 py-4 border-b border-white/5">
        <h2 class="font-display font-bold text-cream/60">Recent — Past Classes</h2>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <tbody>
                @foreach($past as $s)
                <tr class="table-row opacity-60">
                    <td class="px-6 py-3 text-sm">{{ $s->title }} — {{ \Carbon\Carbon::parse($s->date)->format('d M') }} <span class="text-cream/40">{{ substr($s->start_time,0,5) }}</span></td>
                    <td class="px-6 py-3 text-right"><a href="{{ route('admin.upcoming.show', $s) }}" class="text-mint text-xs hover:underline">View</a></td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endif

@endsection
