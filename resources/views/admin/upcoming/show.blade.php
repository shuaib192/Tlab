@extends('layouts.admin')
@section('title', 'Manage Upcoming Class')
@section('content')

<div class="mb-6">
    <a href="{{ route('admin.upcoming.index') }}" class="text-mint text-sm font-bold hover:underline">← Back to Upcoming Classes</a>
</div>

<div class="card p-6 mb-8">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div>
            <h1 class="font-display text-2xl font-bold">{{ $session->title }}</h1>
            <p class="text-cream/50 text-sm mt-1">{{ $session->cohort->name ?? '' }} · {{ $session->course->title ?? '' }}</p>
        </div>
        <span class="badge {{ $session->status === 'scheduled' ? 'badge-green' : ($session->status === 'completed' ? 'badge-gray' : 'badge-red') }}">{{ $session->status }}</span>
    </div>

    <form method="POST" action="{{ route('admin.upcoming.update', $session) }}" class="space-y-4">
        @csrf @method('PUT')
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="label">Cohort *</label>
                <select name="cohort_id" required class="input">
                    @foreach($cohorts as $cohort)
                        <option value="{{ $cohort->id }}" {{ $session->cohort_id == $cohort->id ? 'selected' : '' }}>{{ $cohort->name }} — {{ $cohort->course->title ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Class Title *</label>
                <input type="text" name="title" required class="input" value="{{ $session->title }}">
            </div>
            <div>
                <label class="label">Date *</label>
                <input type="date" name="date" required class="input" value="{{ $session->date->format('Y-m-d') }}">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="label">Start Time *</label>
                    <input type="time" name="start_time" required class="input" value="{{ substr($session->start_time,0,5) }}">
                </div>
                <div>
                    <label class="label">End Time *</label>
                    <input type="time" name="end_time" required class="input" value="{{ substr($session->end_time,0,5) }}">
                </div>
            </div>
            <div>
                <label class="label">Status</label>
                <select name="status" class="input">
                    <option value="scheduled" {{ $session->status === 'scheduled' ? 'selected' : '' }}>Scheduled</option>
                    <option value="completed" {{ $session->status === 'completed' ? 'selected' : '' }}>Completed</option>
                    <option value="cancelled" {{ $session->status === 'cancelled' ? 'selected' : '' }}>Cancelled</option>
                </select>
            </div>
            <div>
                <label class="label">Meeting URL</label>
                <input type="url" name="meeting_url" class="input" value="{{ $session->meeting_url }}">
            </div>
            <div class="md:col-span-2">
                <label class="label">Notes</label>
                <textarea name="notes" rows="3" class="input">{{ $session->notes }}</textarea>
            </div>
        </div>
        <button type="submit" class="btn-primary">Save Changes</button>
    </form>
</div>

@if($session->cohort)
<div class="card p-6">
    <h3 class="font-bold mb-3">Enrolled Students in this Cohort</h3>
    @php $enrollments = $session->cohort->enrollments()->with('child.parent')->get(); @endphp
    @if($enrollments->isEmpty())
        <p class="text-cream/30 text-sm">No students enrolled in this cohort yet.</p>
    @else
        <div class="space-y-2">
            @foreach($enrollments as $en)
            <div class="flex items-center justify-between py-2 border-b border-white/5">
                <span class="text-sm font-semibold">{{ $en->child->name ?? 'Child #'.$en->child_profile_id }}</span>
                <span class="text-xs text-cream/40">Parent: {{ $en->child->parent->name ?? '—' }} · {{ $en->child->parent->email ?? '' }}</span>
            </div>
            @endforeach
        </div>
    @endif
</div>
@endif

@endsection
