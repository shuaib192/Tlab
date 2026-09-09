@extends('layouts.teacher')
@section('title', 'Curriculum — ' . $course->title)
@section('content')
    <div class="card p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">
                    <a href="{{ route('teacher.course', $course) }}" class="hover:text-mint transition-colors">{{ $course->title }}</a>
                    &nbsp;/&nbsp; Curriculum
                </div>
                <h1 class="text-2xl font-bold">Curriculum Builder</h1>
                <p class="text-xs text-cream/50 mt-1">Modules hold lessons. Publish lessons so students can access them.</p>
            </div>
            <a href="{{ route('teacher.course', $course) }}" class="btn-secondary btn-sm no-underline">Back</a>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="space-y-4">
            <div class="card p-5">
                <h2 class="text-sm font-bold mb-4">Add Module</h2>
                <form method="POST" action="{{ route('teacher.modules.store', $course) }}">
                    @csrf
                    <div class="mb-3">
                        <label class="label">Module Title</label>
                        <input type="text" name="title" class="input" placeholder="e.g. Introduction to Scratch" required>
                    </div>
                    <div class="mb-3">
                        <label class="label">Description (optional)</label>
                        <textarea name="description" rows="3" class="input" placeholder="What is this module about?"></textarea>
                    </div>
                    <button type="submit" class="btn-primary btn-sm w-full justify-center">Add Module</button>
                </form>
            </div>
        </div>

        <div class="lg:col-span-2 space-y-4">
            @forelse($course->modules as $index => $module)
                <div class="card overflow-hidden">
                    <div class="px-5 py-4 border-b border-white/5 flex items-center justify-between gap-3">
                        <div>
                            <span class="text-xs font-bold text-mint mr-2">MODULE {{ $module->sort_order ?? $index + 1 }}</span>
                            <span class="font-bold">{{ $module->title }}</span>
                        </div>
                        <div class="flex items-center gap-2">
                            <details class="relative">
                                <summary class="btn-secondary btn-sm text-xs cursor-pointer">Edit</summary>
                                <div class="absolute right-0 top-full mt-2 w-80 card p-4 z-10">
                                    <form method="POST" action="{{ route('teacher.modules.update', $module) }}">
                                        @csrf
                                        @method('PUT')
                                        <div class="mb-3">
                                            <label class="label">Module Title</label>
                                            <input type="text" name="title" value="{{ $module->title }}" class="input" required>
                                        </div>
                                        <div class="mb-3">
                                            <label class="label">Description</label>
                                            <textarea name="description" rows="3" class="input">{{ $module->description }}</textarea>
                                        </div>
                                        <div class="mb-3">
                                            <label class="label">Order</label>
                                            <input type="number" name="sort_order" value="{{ $module->sort_order }}" class="input" min="0">
                                        </div>
                                        <button type="submit" class="btn-primary btn-sm w-full justify-center">Save Module</button>
                                    </form>
                                </div>
                            </details>
                            <form method="POST" action="{{ route('teacher.modules.destroy', $module) }}"
                                  onsubmit="return confirm('Delete this module and all its lessons?');">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn-secondary btn-sm text-xs text-terra">Delete</button>
                            </form>
                        </div>
                    </div>

                    <div class="px-5 py-4 space-y-3">
                        @if($module->description)
                            <p class="text-sm text-cream/50">{{ $module->description }}</p>
                        @endif

                        @forelse($module->lessons as $lesson)
                            <div class="flex items-center justify-between gap-3 p-3 rounded-lg bg-cream/5">
                                <div class="min-w-0">
                                    <div class="font-semibold text-sm truncate">{{ $lesson->title }}</div>
                                    <div class="text-xs text-cream/40 flex items-center gap-2">
                                        <span>{{ ucfirst($lesson->type) }}</span>
                                        @if($lesson->duration) <span>{{ $lesson->duration }} min</span> @endif
                                        @if($lesson->assessment) <span class="text-gold">has quiz</span> @endif
                                        @if($lesson->assignments_count !== null) <span>{{ $lesson->assignments_count }} assignment(s)</span> @endif
                                    </div>
                                </div>
                                <div class="flex items-center gap-2 flex-shrink-0">
                                    <details class="relative">
                                        <summary class="btn-secondary btn-sm text-xs cursor-pointer">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                                        </summary>
                                        <div class="absolute right-0 top-full mt-2 w-80 card p-4 z-10">
                                            <form method="POST" action="{{ route('teacher.lessons.update', $lesson) }}">
                                                @csrf
                                                @method('PUT')
                                                <div class="mb-3">
                                                    <label class="label">Lesson Title</label>
                                                    <input type="text" name="title" value="{{ $lesson->title }}" class="input" required>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="label">Type</label>
                                                    <select name="type" class="input">
                                                        <option value="text" {{ $lesson->type === 'text' ? 'selected' : '' }}>Text</option>
                                                        <option value="video" {{ $lesson->type === 'video' ? 'selected' : '' }}>Video</option>
                                                        @if($lesson->type === 'quiz')
                                                            <option value="quiz" selected disabled>Quiz (manage in Admin)</option>
                                                        @endif
                                                    </select>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="label">Video URL (optional)</label>
                                                    <input type="url" name="video_url" value="{{ $lesson->video_url }}" class="input">
                                                </div>
                                                <div class="mb-3">
                                                    <label class="label">Content / Notes</label>
                                                    <textarea name="content" rows="3" class="input">{{ $lesson->content }}</textarea>
                                                </div>
                                                <div class="mb-3">
                                                    <label class="label">Duration (minutes)</label>
                                                    <input type="number" name="duration" value="{{ $lesson->duration }}" class="input" min="1" max="999">
                                                </div>
                                                <button type="submit" class="btn-primary btn-sm w-full justify-center">Save Lesson</button>
                                            </form>
                                        </div>
                                    </details>
                                    <form method="POST" action="{{ route('teacher.lessons.destroy', $lesson) }}"
                                          onsubmit="return confirm('Delete this lesson?');">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit" class="btn-secondary btn-sm text-xs text-terra">Delete</button>
                                    </form>
                                </div>
                            </div>
                        @empty
                            <p class="text-xs text-cream/40 py-2">No lessons yet in this module.</p>
                        @endforelse

                        <details>
                            <summary class="text-xs font-bold text-mint cursor-pointer hover:text-cream transition-colors inline-flex items-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                                Add Lesson
                            </summary>
                            <div class="mt-3 card p-4">
                                <form method="POST" action="{{ route('teacher.lessons.store', $module) }}">
                                    @csrf
                                    <div class="mb-3">
                                        <label class="label">Lesson Title</label>
                                        <input type="text" name="title" class="input" placeholder="e.g. Your First Sprite" required>
                                    </div>
                                    <div class="grid grid-cols-2 gap-3 mb-3">
                                        <div>
                                            <label class="label">Type</label>
                                            <select name="type" class="input">
                                                <option value="text">Text</option>
                                                <option value="video">Video</option>
                                            </select>
                                        </div>
                                        <div>
                                            <label class="label">Duration (minutes)</label>
                                            <input type="number" name="duration" class="input" placeholder="e.g. 15" min="1" max="999">
                                        </div>
                                    </div>
                                    <div class="mb-3">
                                        <label class="label">Video URL (optional)</label>
                                        <input type="url" name="video_url" class="input" placeholder="https://youtube.com/...">
                                    </div>
                                    <div class="mb-3">
                                        <label class="label">Content / Notes</label>
                                        <textarea name="content" rows="3" class="input" placeholder="Lesson body text..."></textarea>
                                    </div>
                                    <button type="submit" class="btn-primary btn-sm w-full justify-center">Add Lesson</button>
                                </form>
                            </div>
                        </details>
                    </div>
                </div>
            @empty
                <div class="card p-10 text-center">
                    <p class="text-cream/50 font-medium">No modules yet.</p>
                    <p class="text-xs text-cream/30 mt-1">Create your first module to start building the course.</p>
                </div>
            @endforelse
        </div>
    </div>
@endsection