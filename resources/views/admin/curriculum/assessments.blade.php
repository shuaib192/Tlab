@extends('layouts.admin')

@section('title', "Assessment - {$lesson->title}")

@section('content')
    <div class="flex items-center justify-between mb-6">
        <div>
            <div class="text-xs font-bold text-white/40 uppercase tracking-wider mb-2">
                <a href="{{ route('admin.curriculum.modules', $lesson->module->course) }}" class="hover:text-mint transition-colors">{{ $lesson->module->course->title }}</a>
                /
                <a href="{{ route('admin.curriculum.lessons', $lesson->module) }}" class="hover:text-mint transition-colors">{{ $lesson->module->title }}</a>
                / Assessment
            </div>
            <h1 class="text-2xl font-bold">{{ $lesson->title }} — Assessment</h1>
        </div>
        @if(!$lesson->assessment)
            <button onclick="document.getElementById('create-modal').classList.remove('hidden')" class="btn-primary">
                + Add Assessment
            </button>
        @endif
    </div>

    @if(session('success'))
        <div class="alert alert-success mb-4">{{ session('success') }}</div>
    @endif

    @if($lesson->assessment)
        <div class="card p-5 mb-6">
            <div class="flex items-center justify-between">
                <div>
                    <h3 class="font-bold">{{ $lesson->assessment->title }}</h3>
                    <p class="text-sm text-white/60 mt-1">Passing score: {{ $lesson->assessment->passing_score }} &middot; Max attempts: {{ $lesson->assessment->max_attempts ?? 3 }}</p>
                </div>
                <span class="badge badge-green">{{ $lesson->assessment->questions->count() }} questions</span>
            </div>
        </div>

        <div class="flex items-center justify-between mb-4">
            <h2 class="text-lg font-bold">Questions ({{ $lesson->assessment->questions->count() }})</h2>
            <button onclick="document.getElementById('question-modal').classList.remove('hidden')" class="btn-primary btn-sm">
                + Add Question
            </button>
        </div>

        <div class="card overflow-hidden">
            @if($lesson->assessment->questions->count())
                <div class="overflow-x-auto">
                    <table class="w-full text-sm">
                        <thead>
                            <tr class="border-b border-white/5 text-xs font-bold text-white/40 uppercase tracking-wider">
                                <th class="text-left px-5 py-3">#</th>
                                <th class="text-left px-5 py-3">Question</th>
                                <th class="text-center px-5 py-3">Type</th>
                                <th class="text-center px-5 py-3">Points</th>
                                <th class="text-center px-5 py-3">Answer</th>
                                <th class="text-right px-5 py-3">Actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($lesson->assessment->questions as $i => $question)
                                <tr class="table-row">
                                    <td class="px-5 py-3 text-white/40">{{ $question->sort_order ?? $i + 1 }}</td>
                                    <td class="px-5 py-3 font-medium max-w-xs truncate">{{ $question->question_text }}</td>
                                    <td class="px-5 py-3 text-center">
                                        <span class="badge badge-sky text-xs">{{ str_replace('_', ' ', $question->type) }}</span>
                                    </td>
                                    <td class="px-5 py-3 text-center">{{ $question->points }}</td>
                                    <td class="px-5 py-3 text-center text-xs text-white/60 max-w-[120px] truncate">{{ $question->correct_answer }}</td>
                                    <td class="px-5 py-3 text-right">
                                        <form method="POST" action="{{ route('admin.curriculum.questions.destroy', $question) }}" class="inline" onsubmit="return confirm('Delete this question?')">
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
                    <p>No questions yet. Click "Add Question" to start building.</p>
                </div>
            @endif
        </div>
    @endif

    {{-- Create Assessment Modal --}}
    <div id="create-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/60 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-2xl p-6 w-full max-w-lg mx-4 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold">Create Assessment</h3>
                <button onclick="document.getElementById('create-modal').classList.add('hidden')" class="text-white/40 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.curriculum.assessments.store', $lesson) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Title</label>
                    <input type="text" name="title" class="input w-full" required maxlength="255" value="{{ $lesson->title }} Quiz">
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="label">Passing Score</label>
                        <input type="number" name="passing_score" class="input w-full" required min="1" value="3">
                    </div>
                    <div>
                        <label class="label">Max Attempts</label>
                        <input type="number" name="max_attempts" class="input w-full" min="1" max="99" value="3">
                    </div>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('create-modal').classList.add('hidden')" class="btn-secondary btn-sm">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Create</button>
                </div>
            </form>
        </div>
    </div>

    {{-- Add Question Modal --}}
    <div id="question-modal" class="fixed inset-0 z-50 flex items-center justify-center hidden bg-black/60 backdrop-blur-sm">
        <div class="bg-gray-900 rounded-2xl p-6 w-full max-w-xl mx-4 shadow-2xl border border-white/10">
            <div class="flex items-center justify-between mb-5">
                <h3 class="text-lg font-bold">Add Question</h3>
                <button onclick="document.getElementById('question-modal').classList.add('hidden')" class="text-white/40 hover:text-white text-xl leading-none">&times;</button>
            </div>
            <form method="POST" action="{{ route('admin.curriculum.questions.store', $lesson->assessment) }}" class="space-y-4">
                @csrf
                <div>
                    <label class="label">Question</label>
                    <textarea name="question_text" class="input w-full" rows="2" required maxlength="5000"></textarea>
                </div>
                <div class="grid grid-cols-2 gap-3">
                    <div>
                        <label class="label">Type</label>
                        <select name="type" class="input w-full">
                            <option value="multiple_choice">Multiple Choice</option>
                            <option value="text">Text / Fill-in</option>
                        </select>
                    </div>
                    <div>
                        <label class="label">Points</label>
                        <input type="number" name="points" class="input w-full" required min="1" max="999" value="1">
                    </div>
                </div>
                <div>
                    <label class="label">Correct Answer</label>
                    <input type="text" name="correct_answer" class="input w-full" required maxlength="1000" placeholder="For multiple choice, enter the option text exactly">
                </div>
                <div>
                    <label class="label">Options JSON (for multiple choice)</label>
                    <textarea name="options" class="input w-full" rows="2" placeholder='["Option A", "Option B", "Option C", "Option D"]'></textarea>
                </div>
                <div class="flex justify-end gap-3 pt-2">
                    <button type="button" onclick="document.getElementById('question-modal').classList.add('hidden')" class="btn-secondary btn-sm">Cancel</button>
                    <button type="submit" class="btn-primary btn-sm">Add Question</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('keydown', function(e) {
            if (e.key === 'Escape') {
                document.getElementById('create-modal').classList.add('hidden');
                document.getElementById('question-modal').classList.add('hidden');
            }
        });
    </script>
@endsection
