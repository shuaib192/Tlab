@extends('layouts.admin')
@section('title', 'Schedule Live Session')
@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.live.index') }}" class="btn-secondary text-xs font-mono">
            &larr; Back to Tower
        </a>
        <span class="text-cream/30">/</span>
        <span class="text-cream/60 font-mono text-xs uppercase">// SCHEDULE LIVE SESSION //</span>
    </div>

    <div class="card p-6 sm:p-8 border-2 border-white/10 rounded-2xl shadow-[6px_6px_0px_rgba(0,0,0,0.5)]">
        <h1 class="font-display text-2xl sm:text-3xl font-black text-cream mb-2">
            Schedule Live Session
        </h1>
        <p class="text-cream/50 text-xs font-mono mb-8">
            Fabricate a broadcast conduit. Students receive the private room link inside their course dashboards when the session goes live.
        </p>

        @if($errors->any())
        <div class="mb-6 p-4 rounded-xl bg-red-500/10 border border-red-500/30 text-red-300 text-xs font-mono">
            @foreach($errors->all() as $error)
                <div>! {{ $error }}</div>
            @endforeach
        </div>
        @endif

        <form method="POST" action="{{ route('admin.live.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div class="sm:col-span-2">
                    <label class="label font-mono">Broadcast Title</label>
                    <input type="text" name="title" id="title" value="{{ old('title') }}" required
                           class="input font-semibold" placeholder="e.g. Astro-Tech Live: Rocket Telemetry">
                </div>

                <div>
                    <label class="label font-mono">Link to Upcoming Class (optional)</label>
                    <select name="class_session_id" id="classSession" class="input">
                        <option value="">— Standalone (no class session link) —</option>
                        @foreach($classSessions as $cs)
                        <option value="{{ $cs->id }}"
                                data-course="{{ $cs->course_id }}"
                                data-title="{{ $cs->title ?: ($cs->course?->title.' session') }}"
                                data-date="{{ $cs->date?->format('Y-m-d') }}"
                                data-time="{{ $cs->start_time }}"
                                {{ old('class_session_id') == $cs->id ? 'selected' : '' }}>
                            {{ $cs->date?->format('M j') }} · {{ $cs->start_time }} — {{ Str::limit($cs->course?->title, 40) }} / {{ $cs->cohort?->name }}
                        </option>
                        @endforeach
                    </select>
                </div>

                <div>
                    <label class="label font-mono">Course (auto-filled from class)</label>
                    <select name="course_id" id="courseSelect" class="input">
                        <option value="">— None —</option>
                        @foreach($courses as $course)
                        <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                            {{ $course->title }}
                        </option>
                        @endforeach
                    </select>
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div class="sm:col-span-2">
                    <label class="label font-mono">Broadcast Start (local time)</label>
                    <input type="datetime-local" name="scheduled_at" id="scheduledAt"
                           value="{{ old('scheduled_at') }}" required class="input font-mono">
                </div>
                <div>
                    <label class="label font-mono">Duration (minutes)</label>
                    <input type="number" name="duration_minutes" id="duration" min="15" max="480"
                           value="{{ old('duration_minutes', 60) }}" required class="input font-mono">
                </div>
            </div>

            <div>
                <label class="label font-mono">Initial State</label>
                <div class="flex gap-6">
                    <label class="flex items-center gap-2 text-sm text-cream/70 cursor-pointer">
                        <input type="radio" name="status" value="scheduled" checked class="accent-mint">
                        Standby (scheduled)
                    </label>
                    <label class="flex items-center gap-2 text-sm text-cream/70 cursor-pointer">
                        <input type="radio" name="status" value="live" class="accent-mint">
                        Go live immediately
                    </label>
                </div>
            </div>

            <div class="flex items-center justify-end gap-3 pt-4 border-t border-white/5">
                <a href="{{ route('admin.live.index') }}" class="btn-secondary text-xs font-mono">Abort</a>
                <button type="submit" class="btn-primary text-xs uppercase tracking-wider font-mono shadow-[4px_4px_0px_#000]">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 10l4.553-2.276A1 1 0 0121 8.618v6.764a1 1 0 01-1.447.894L15 14M5 18h8a2 2 0 002-2V8a2 2 0 00-2-2H5a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                    Fabricate Session
                </button>
            </div>
        </form>
    </div>
</div>

@push('scripts')
<script>
    const classSelect = document.getElementById('classSession');
    const courseSelect = document.getElementById('courseSelect');
    const titleInput = document.getElementById('title');
    const scheduledAt = document.getElementById('scheduledAt');
    const duration = document.getElementById('duration');

    classSelect.addEventListener('change', function () {
        const opt = this.options[this.selectedIndex];
        if (!opt.value) return;
        if (opt.dataset.course) courseSelect.value = opt.dataset.course;
        if (opt.dataset.title) titleInput.value = opt.dataset.title;
        if (opt.dataset.date && opt.dataset.time) {
            const time = opt.dataset.time.slice(0, 5);
            scheduledAt.value = opt.dataset.date + 'T' + time;
        }
    });
</script>
@endpush
@endsection