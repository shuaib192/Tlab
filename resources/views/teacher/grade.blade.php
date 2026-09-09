@extends('layouts.teacher')

@section('title', 'Grade — ' . $assignment->title)

@section('content')
    <div class="card p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">
                    <a href="{{ route('teacher.assignments', $assignment->lesson->module->course) }}" class="hover:text-mint transition-colors">Assignments</a>
                    &nbsp;/&nbsp; Grade
                </div>
                <h1 class="text-2xl font-bold">{{ $assignment->title }}</h1>
                <div class="flex items-center gap-3 mt-1 text-sm text-cream/60">
                    <span>{{ $submissions->count() }} submission{{ $submissions->count() !== 1 ? 's' : '' }}</span>
                    @if($assignment->max_score)
                        <span>Max score: {{ $assignment->max_score }}</span>
                    @endif
                    @if($assignment->due_date)
                        <span>Due {{ $assignment->due_date->format('M d, Y') }}</span>
                    @endif
                    <span class="text-xs px-2 py-0.5 rounded-full bg-cream/10">{{ ucfirst($assignment->type) }}</span>
                </div>
            </div>
            <a href="{{ route('teacher.assignments', $assignment->lesson->module->course) }}" class="btn-secondary btn-sm no-underline">Back to Assignments</a>
        </div>
    </div>

    @if($submissions->count())
        <div class="space-y-4">
            @foreach($submissions as $submission)
                @php
                    $versions = $allVersions[$submission->child_profile_id] ?? collect();
                    $isLate = $submission->submitted_late || ($assignment->due_date && $submission->submitted_at && $submission->submitted_at->gt($assignment->due_date->endOfDay()));
                @endphp
                <div class="card overflow-hidden">
                    <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-full bg-mint/10 border border-mint/20 flex items-center justify-center text-sm font-bold text-mint flex-shrink-0">
                                {{ strtoupper(substr($submission->child->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold">{{ $submission->child->name }}</div>
                                <div class="text-xs text-cream/40 flex items-center gap-2">
                                    <span>Submitted {{ $submission->submitted_at ? $submission->submitted_at->diffForHumans() : 'N/A' }}</span>
                                    @if($isLate)
                                        <span class="px-1.5 py-0.5 rounded bg-red-500/10 text-red-400 font-bold">Late</span>
                                    @endif
                                    @if($submission->version > 1)
                                        <span class="px-1.5 py-0.5 rounded bg-sky/10 text-sky font-bold">v{{ $submission->version }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                        <div>
                            @if($submission->status === 'graded' || $submission->status === 'approved')
                                <span class="badge badge-green">{{ $submission->status }}</span>
                            @elseif($submission->status === 'rejected')
                                <span class="badge badge-red">{{ $submission->status }}</span>
                            @elseif($submission->status === 'returned_for_revision')
                                <span class="badge badge-gold">Revision Requested</span>
                            @else
                                <span class="badge badge-gold">{{ $submission->status ?? 'pending' }}</span>
                            @endif
                        </div>
                    </div>

                    <div class="px-5 py-4">
                        @if($submission->submission_text)
                            <div class="mb-4 p-4 rounded-lg bg-cream/5 text-sm text-cream/80">
                                <div class="text-xs font-bold text-cream/40 mb-2">Student's Work</div>
                                {{ $submission->submission_text }}
                            </div>
                        @endif

                        @if($submission->link_url)
                            <div class="mb-4 p-4 rounded-lg bg-sky/5 border border-sky/10">
                                <div class="text-xs font-bold text-cream/40 mb-2">Project Link</div>
                                <a href="{{ $submission->link_url }}" target="_blank" rel="noopener noreferrer" class="text-sm text-sky hover:underline break-all">
                                    {{ $submission->link_url }}
                                </a>
                                @if($submission->link_note)
                                    <p class="text-xs text-cream/50 mt-2">{{ $submission->link_note }}</p>
                                @endif
                            </div>
                        @endif

                        @if($submission->files && $submission->files->count())
                            <div class="mb-4">
                                <div class="text-xs font-bold text-cream/40 mb-2">Attached Files</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($submission->files as $file)
                                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="btn-secondary btn-sm text-xs no-underline inline-flex items-center gap-1">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                            {{ $file->file_name }} <span class="text-cream/30">({{ round($file->file_size / 1024) }}KB)</span>
                                        </a>
                                    @endforeach
                                </div>
                            </div>
                        @elseif($submission->file_url)
                            <div class="mb-4">
                                <a href="{{ $submission->file_url }}" target="_blank" class="btn-secondary btn-sm text-xs no-underline inline-flex">
                                    <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                                    View Attachment
                                </a>
                            </div>
                        @endif

                        @if($versions->count() > 1)
                            <details class="mb-4">
                                <summary class="text-xs font-bold text-cream/40 cursor-pointer hover:text-cream/60">
                                    Version History ({{ $versions->count() }} versions)
                                </summary>
                                <div class="mt-2 space-y-2">
                                    @foreach($versions as $v)
                                        <div class="flex items-center gap-3 text-xs p-2 rounded bg-cream/5">
                                            <span class="font-bold text-cream/60">v{{ $v->version }}</span>
                                            <span class="text-cream/40">{{ $v->submitted_at->diffForHumans() }}</span>
                                            @if($v->submitted_late)
                                                <span class="px-1.5 py-0.5 rounded bg-red-500/10 text-red-400 font-bold">Late</span>
                                            @endif
                                            @if($v->score !== null)
                                                <span class="text-mint font-bold">{{ $v->score }}/{{ $assignment->max_score }}</span>
                                            @endif
                                            @if($v->files && $v->files->count())
                                                <span class="text-cream/30">{{ $v->files->count() }} file(s)</span>
                                            @endif
                                            @if($v->link_url)
                                                <a href="{{ $v->link_url }}" target="_blank" class="text-sky hover:underline">link</a>
                                            @endif
                                        </div>
                                    @endforeach
                                </div>
                            </details>
                        @endif

                        <form method="POST" action="{{ route('teacher.grade.submit', $submission) }}" class="grid grid-cols-1 md:grid-cols-3 gap-4 items-end">
                            @csrf
                            <div>
                                <label class="label">Score</label>
                                <input type="number" name="score" value="{{ $submission->score ?? '' }}"
                                       class="input" min="0" max="{{ $assignment->max_score }}" step="0.5"
                                       placeholder="0 &ndash; {{ $assignment->max_score }}" required>
                            </div>
                            <div>
                                <label class="label">Status</label>
                                <select name="status" class="input">
                                    <option value="graded" {{ $submission->status === 'graded' ? 'selected' : '' }}>Graded</option>
                                    <option value="approved" {{ $submission->status === 'approved' ? 'selected' : '' }}>Approved</option>
                                    <option value="returned_for_revision" {{ $submission->status === 'returned_for_revision' ? 'selected' : '' }}>Return for Revision</option>
                                    <option value="rejected" {{ $submission->status === 'rejected' ? 'selected' : '' }}>Rejected</option>
                                </select>
                            </div>
                            <button type="submit" class="btn-primary w-full justify-center">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
                                Submit Grade
                            </button>
                            <div class="md:col-span-3">
                                <label class="label">Feedback</label>
                                <textarea name="feedback" rows="2" class="input" placeholder="Provide feedback to the student...">{{ $submission->feedback ?? '' }}</textarea>
                            </div>
                        </form>
                    </div>
                </div>
            @endforeach
        </div>
    @else
        <div class="card p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-cream/5 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-cream/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
            </div>
            <p class="text-cream/50 font-medium">No submissions yet.</p>
            <p class="text-xs text-cream/30 mt-1">Submissions will appear here when students submit their work.</p>
        </div>
    @endif
@endsection
