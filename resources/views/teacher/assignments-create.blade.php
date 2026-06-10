@extends('layouts.teacher')
@section('title', 'Create Assignment — ' . $course->title)
@section('content')
<div class="card p-6 mb-6">
    <div class="flex items-center justify-between gap-4">
        <div>
            <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">
                <a href="{{ route('teacher.course', $course) }}" class="hover:text-mint transition-colors">{{ $course->title }}</a>
                &nbsp;/&nbsp; New Assignment
            </div>
            <h1 class="text-2xl font-bold">Create Assignment</h1>
        </div>
        <a href="{{ route('teacher.assignments', $course) }}" class="btn-secondary btn-sm no-underline">Back</a>
    </div>
</div>

<div class="card p-6 max-w-2xl">
    <form method="POST" action="{{ route('teacher.assignments.store', $course) }}">
        @csrf
        <div class="mb-5">
            <label class="label">Lesson</label>
            <select name="lesson_id" class="input" required>
                <option value="">Select lesson...</option>
                @foreach($course->modules as $module)
                <optgroup label="{{ $module->title }}">
                    @foreach($module->lessons as $lesson)
                    <option value="{{ $lesson->id }}">{{ $lesson->title }}</option>
                    @endforeach
                </optgroup>
                @endforeach
            </select>
            @error('lesson_id') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
        </div>
        <div class="mb-5">
            <label class="label">Assignment Title</label>
            <input type="text" name="title" class="input" placeholder="e.g. Week 1 Project" required>
        </div>
        <div class="mb-5">
            <label class="label">Instructions</label>
            <textarea name="instructions" rows="6" class="input" placeholder="Describe the assignment..."></textarea>
        </div>
        <div class="grid grid-cols-2 gap-4 mb-5">
            <div>
                <label class="label">Type</label>
                <select name="type" class="input">
                    <option value="text">Text</option>
                    <option value="file">File Upload</option>
                    <option value="both">Both</option>
                </select>
            </div>
            <div>
                <label class="label">Max Score</label>
                <input type="number" name="max_score" class="input" value="100" min="1">
            </div>
        </div>
        <div class="mb-6">
            <label class="label">Due Date (optional)</label>
            <input type="date" name="due_date" class="input">
        </div>
        <button type="submit" class="btn-primary">Create Assignment</button>
    </form>
</div>
@endsection
