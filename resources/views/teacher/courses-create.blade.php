@extends('layouts.teacher')
@section('title', 'Create Course')
@section('content')
    <div class="card p-6 mb-6">
        <div class="flex items-center justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Curriculum Builder</div>
                <h1 class="text-2xl font-bold">Create a New Course</h1>
            </div>
            <a href="{{ route('teacher.dashboard') }}" class="btn-secondary btn-sm no-underline">Back to Dashboard</a>
        </div>
    </div>

    <div class="card p-6 max-w-2xl">
        <form method="POST" action="{{ route('teacher.courses.store') }}">
            @csrf
            <div class="mb-5">
                <label class="label">Club</label>
                <select name="club_id" class="input" required>
                    <option value="">Select a club...</option>
                    @foreach($clubs as $club)
                        <option value="{{ $club->id }}">{{ $club->name }}</option>
                    @endforeach
                </select>
                @error('club_id') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-5">
                <label class="label">Course Title</label>
                <input type="text" name="title" class="input" placeholder="e.g. Creative Coding with Scratch" required>
                @error('title') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>
            <div class="mb-5">
                <label class="label">Description</label>
                <textarea name="description" rows="5" class="input" placeholder="What will students learn?"></textarea>
            </div>
            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="label">Level (optional)</label>
                    <input type="text" name="level" class="input" placeholder="e.g. Beginner">
                </div>
                <div>
                    <label class="label">Grade Level (optional)</label>
                    <input type="text" name="grade_level" class="input" placeholder="e.g. Grades 4-6">
                </div>
            </div>
            <div class="mb-6 flex items-center gap-3">
                <input type="hidden" name="is_published" value="0">
                <input type="checkbox" name="is_published" value="1" class="accent-mint" checked>
                <label class="label mb-0">Publish immediately</label>
            </div>
            <button type="submit" class="btn-primary">Create Course</button>
        </form>
    </div>
@endsection