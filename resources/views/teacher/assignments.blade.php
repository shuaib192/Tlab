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
                    <div class="flex items-center gap-2 mb-3">
                        <span class="text-xs px-2 py-0.5 rounded-full bg-cream/10">
                            @if($assignment->type === 'both') File or Link
                            @elseif($assignment->type === 'file') File Upload
                            @elseif($assignment->type === 'link') Project Link
                            @elseif($assignment->type === 'canvas') Interactive Canvas
                            @else {{ $assignment->type }}
                            @endif
                        </span>
                        @if(! $assignment->is_published)
                            <span class="text-xs px-2 py-0.5 rounded-full bg-amber-500/10 text-amber-400 font-bold">Draft</span>
                        @endif
                    </div>
                    <div class="mt-auto pt-3 flex items-center justify-between gap-2">
                        <span class="text-xs text-cream/40">
                            @if($assignment->due_date)
                                Due {{ $assignment->due_date->diffForHumans() }}
                            @else
                                No due date
                            @endif
                        </span>
                        <div class="flex items-center gap-1.5">
                            <details class="relative">
                                <summary class="btn-secondary btn-sm text-xs cursor-pointer">Edit</summary>
                                <div class="absolute right-0 top-full mt-2 w-80 card p-4 z-20">
                                    <form method="POST" action="{{ route('teacher.assignments.update', $assignment) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="label">Lesson</label>
                                            <select name="lesson_id" class="input" required>
                                                @foreach($course->modules as $module)
                                                    <optgroup label="{{ $module->title }}">
                                                        @foreach($module->lessons as $lesson)
                                                            <option value="{{ $lesson->id }}" {{ $assignment->lesson_id === $lesson->id ? 'selected' : '' }}>{{ $lesson->title }}</option>
                                                        @endforeach
                                                    </optgroup>
                                                @endforeach
                                            </select>
                                        </div>
                                        <div class="mb-3">
                                            <label class="label">Assignment Title</label>
                                            <input type="text" name="title" value="{{ $assignment->title }}" class="input" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="label">Instructions</label>
                                            <textarea name="instructions" rows="3" class="input">{{ $assignment->instructions }}</textarea>
                                        </div>
                                        <div class="grid grid-cols-3 gap-3 mb-3">
                                            <div class="col-span-2">
                                                <label class="label">Submission Method</label>
                                                <select name="type" class="input">
                                                    @foreach(['file' => 'File Upload', 'link' => 'Project Link', 'both' => 'Both', 'canvas' => 'Interactive Canvas'] as $typeValue => $typeLabel)
                                                        <option value="{{ $typeValue }}" {{ $assignment->type === $typeValue ? 'selected' : '' }}>{{ $typeLabel }}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                            <div>
                                                <label class="label">Max Score</label>
                                                <input type="number" name="max_score" value="{{ $assignment->max_score }}" class="input" min="1">
                                            </div>
                                        </div>
                                        <div class="mb-3">
                                            <label class="label">Due Date (optional)</label>
                                            <input type="date" name="due_date" value="{{ $assignment->due_date?->format('Y-m-d') }}" class="input">
                                        </div>
                                        <div class="mb-4 flex items-center gap-3">
                                            <input type="hidden" name="is_published" value="0">
                                            <input type="checkbox" name="is_published" value="1" class="accent-mint" {{ $assignment->is_published ? 'checked' : '' }}>
                                            <label class="label mb-0">Published</label>
                                        </div>
                                        <button type="submit" class="btn-primary btn-sm w-full justify-center">Save Changes</button>
                                    </form>
                                </div>
                            </details>
                            <form method="POST" action="{{ route('teacher.assignments.destroy', $assignment) }}"
                                  onsubmit="return confirm('Delete this assignment and all submissions?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-secondary btn-sm text-xs text-terra">Delete</button>
                            </form>
                            <a href="{{ route('teacher.grade', $assignment) }}" class="btn-primary btn-sm text-xs no-underline">
                                Grade
                            </a>
                        </div>
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
