@extends('layouts.admin')

@section('title', "Lessons - {$module->title}")

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="text-xs font-bold text-white/40 uppercase tracking-wider mb-1">
                <a href="{{ route('admin.curriculum.modules', $module->course) }}" class="hover:text-mint transition-colors">{{ $module->course->title }}</a>
                / Lessons
            </div>
            <h1 class="text-2xl font-bold">{{ $module->title }} — Lessons</h1>
        </div>
        <button onclick="document.getElementById('create-modal').classList.remove('hidden')" class="btn-primary">
            + Add Lesson
        </button>
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    <div class="card overflow-hidden">
        @if($module->lessons->count())
            <div class="overflow-x-auto">
                <table class="w-full text-sm">
                    <thead>
                        <tr class="border-b border-white/5 text-xs font-bold text-white/40 uppercase tracking-wider">
                            <th class="text-left px-5 py-3">#</th>
                            <th class="text-left px-5 py-3">Title</th>
                            <th class="text-center px-5 py-3">Type</th>
                            <th class="text-center px-5 py-3">Duration</th>
                            <th class="text-center px-5 py-3">Assessment</th>
                            <th class="text-right px-5 py-3">Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($module->lessons as $i => $lesson)
                            <tr class="table-row">
                                <td class="px-5 py-3 text-white/40">{{ $lesson->sort_order ?? $i + 1 }}</td>
                                <td class="px-5 py-3 font-medium">{{ $lesson->title }}</td>
                                <td class="px-5 py-3 text-center">
                                    <span class="badge badge-sky text-xs">{{ $lesson->type ?? 'text' }}</span>
                                </td>
                                <td class="px-5 py-3 text-center text-white/60">{{ $lesson->duration ?? '—' }} min</td>
                                <td class="px-5 py-3 text-center">
                                    @if($lesson->assessment)
                                        <a href="{{ route('admin.curriculum.assessments', $lesson) }}" class="text-mint hover:underline text-xs">{{ $lesson->assessment->questions->count() }} questions</a>
                                    @else
                                        <span class="text-white/30 text-xs">None</span>
                                    @endif
                                </td>
                                <td class="px-5 py-3 text-right">
                                    <a href="{{ route('admin.curriculum.assessments', $lesson) }}" class="btn-secondary btn-sm text-xs">Assessment</a>
                                    <button onclick="editLesson({{ $lesson->id }}, '{{ $lesson->title }}', '{{ $lesson->type }}', '{{ $lesson->video_url }}', {{ $lesson->duration ?? 0 }}, {{ $lesson->sort_order ?? $i + 1 }})" class="btn-secondary btn-sm text-xs">Edit</button>
                                    <form method="POST" action="{{ route('admin.curriculum.lessons.destroy', $lesson) }}" class="inline" onsubmit="return confirm('Delete this lesson?')">
                                        @csrf @method('DELETE')
                                        <button class="btn-danger btn-sm text-xs">Delete</button>
                                    </form>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        @else
            <div class="p-8 text-center text-white/40">
                <p>No lessons yet. Click "Add Lesson" to start building.</p>
            </div>
        @endif
    </div>

    {{-- Create Modal --}}
    <div id="create-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/60 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-2xl p-6 w-full max-w-lg mx-4 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold">Create Lesson</h3>
                <button onclick="document.getElementById('create-modal').classList.add('hidden')" class="text-white/40 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.curriculum.lessons.store', $module) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Title</label>
                    <input type="text" name="title" class="input w-full" required maxlength="255">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="label">Type</label>
                        <select name="type" class="input w-full">
                            <option value="text">Text</option>
                            <option value="video">Video</option>
                            <option value="quiz">Quiz</option>
                            <option value="assignment">Assignment</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Duration (min)</label>
                        <input type="number" name="duration" class="input w-full" min="1" max="999">
                    </div>
                </div>
                <div>
                    <label class="label">Video URL (for video type)</label>
                    <input type="url" name="video_url" class="input w-full" placeholder="https://vimeo.com/... or https://youtube.com/...">
                </div>
                <div>
                    <label class="label">Content</label>
                    <textarea name="content" class="input w-full" rows="4"></textarea>
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input type="number" name="sort_order" class="input w-24" min="0" value="{{ $module->lessons->count() }}">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="btn-secondary btn-sm">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Create</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Edit Modal --}}
    <div id="edit-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/60 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-2xl p-6 w-full max-w-lg mx-4 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold">Edit Lesson</h3>
                <button onclick="document.getElementById('edit-modal').classList.add('hidden')" class="text-white/40 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form method="POST" action="" id="edit-lesson-form" class="space-y-4">
                @csrf @method('PUT')
                <div>
                    <label class="label">Title</label>
                    <input type="text" name="title" id="edit-title" class="input w-full" required maxlength="255">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="label">Type</label>
                        <select name="type" id="edit-type" class="input w-full">
                            <option value="text">Text</option>
                            <option value="video">Video</option>
                            <option value="quiz">Quiz</option>
                            <option value="assignment">Assignment</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Duration (min)</label>
                        <input type="number" name="duration" id="edit-duration" class="input w-full" min="1" max="999">
                    </div>
                </div>
                <div>
                    <label class="label">Video URL</label>
                    <input type="url" name="video_url" id="edit-video-url" class="input w-full">
                </div>
                <div>
                    <label class="label">Sort Order</label>
                    <input type="number" name="sort_order" id="edit-sort" class="input w-24" min="0">
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('edit-modal').classList.add('hidden')" class="btn-secondary btn-sm">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Update</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        function editLesson(id, title, type, videoUrl, duration, sortOrder) {
            document.getElementById('edit-lesson-form').action = '{{ url("admin/curriculum/lessons") }}/' + id;
            document.getElementById('edit-title').value = title;
            document.getElementById('edit-type').value = type;
            document.getElementById('edit-video-url').value = videoUrl;
            document.getElementById('edit-duration').value = duration;
            document.getElementById('edit-sort').value = sortOrder;
            document.getElementById('edit-modal').classList.remove('hidden');
        }
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('create-modal').classList.add('hidden');
                document.getElementById('edit-modal').classList.add('hidden');
            }
        });
    </script>
@endsection
