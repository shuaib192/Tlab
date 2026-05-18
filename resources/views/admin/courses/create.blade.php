@extends('layouts.admin')
@section('title', 'Create Course')
@section('content')

<div class="mb-8">
    <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-4 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Courses
    </a>
    <h1 class="font-display text-3xl font-bold">Create New Course</h1>
</div>

<div class="max-w-2xl">
    @if($errors->any())
    <div class="flash-error mb-6">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('admin.courses.store') }}" class="card p-6 space-y-5">
        @csrf

        <div>
            <label class="label">Club</label>
            <select name="club_id" required class="input appearance-none">
                <option value="">Select a Club...</option>
                @foreach($clubs as $club)
                <option value="{{ $club->id }}" {{ old('club_id') == $club->id ? 'selected' : '' }}>
                    {{ $club->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="label">Course Title</label>
            <input type="text" name="title" value="{{ old('title') }}" required class="input" placeholder="e.g. Python for Kids">
        </div>

        <div>
            <label class="label">Description</label>
            <textarea name="description" rows="3" class="input resize-none" placeholder="What will students learn in this course?">{{ old('description') }}</textarea>
        </div>

        <div>
            <label class="label">Level</label>
            <div class="grid grid-cols-3 gap-3">
                @foreach(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $val => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="level" value="{{ $val }}" class="sr-only peer"
                           {{ old('level', 'beginner') === $val ? 'checked' : '' }}>
                    <div class="text-center py-3 px-4 rounded-xl border border-white/10 text-sm font-bold transition-all
                                peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:text-mint hover:border-white/30">
                        {{ $label }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Create Course</button>
            <a href="{{ route('admin.courses.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
