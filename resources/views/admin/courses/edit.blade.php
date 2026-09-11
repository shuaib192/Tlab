@extends('layouts.admin')
@section('title', 'Edit Course')
@section('content')

<div class="mb-8">
    <a href="{{ route('admin.courses.index') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-4 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Courses
    </a>
    <h1 class="font-display text-3xl font-bold">Edit Course</h1>
</div>

<div class="max-w-2xl">
    @if($errors->any())
    <div class="flash-error mb-6">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('admin.courses.update', $course) }}" class="card p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="label">Club</label>
            <select name="club_id" required class="input appearance-none">
                @foreach($clubs as $club)
                <option value="{{ $club->id }}" {{ old('club_id', $course->club_id) == $club->id ? 'selected' : '' }}>
                    {{ $club->name }}
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="label">Course Title</label>
            <input type="text" name="title" value="{{ old('title', $course->title) }}" required class="input">
        </div>

        <div>
            <label class="label">Enrolment Fee (₦) <span class="opacity-60 font-normal">— leave blank for free</span></label>
            <input type="number" name="fee" value="{{ old('fee', $course->fee) }}" min="0" class="input" placeholder="e.g. 5000">
            @error('fee')
                <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p>
            @enderror
        </div>

        <div>
            <label class="label">Description</label>
            <textarea name="description" rows="3" class="input resize-none">{{ old('description', $course->description) }}</textarea>
        </div>

        <div>
            <label class="label">Level</label>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3">
                @foreach(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $val => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="level" value="{{ $val }}" class="sr-only peer"
                           {{ old('level', $course->level) === $val ? 'checked' : '' }}>
                    <div class="text-center py-3 px-4 rounded-xl border border-white/10 text-sm font-bold transition-all
                                peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:text-mint hover:border-white/30">
                        {{ $label }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('admin.courses.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
