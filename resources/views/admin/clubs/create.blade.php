@extends('layouts.admin')
@section('title', 'Create Club')
@section('content')

<div class="mb-8">
    <a href="{{ route('admin.clubs.index') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-4 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Clubs
    </a>
    <h1 class="font-display text-3xl font-bold">Create New Club</h1>
</div>

<div class="max-w-2xl">
    @if($errors->any())
    <div class="flash-error mb-6">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('admin.clubs.store') }}" class="card p-6 space-y-5">
        @csrf

        <div>
            <label class="label">Club Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required class="input" placeholder="e.g. STEM Club">
        </div>

        <div>
            <label class="label">Description</label>
            <textarea name="description" rows="3" class="input resize-none" placeholder="What will children learn in this club?">{{ old('description') }}</textarea>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="label">Minimum Age</label>
                <input type="number" name="min_age" value="{{ old('min_age', 3) }}" min="1" max="18" class="input">
            </div>
            <div>
                <label class="label">Maximum Age</label>
                <input type="number" name="max_age" value="{{ old('max_age', 15) }}" min="1" max="18" class="input">
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="label">Brand Color</label>
                <div class="flex items-center gap-3">
                    <input type="color" name="color_theme" value="{{ old('color_theme', '#4E9966') }}"
                           class="h-12 w-16 rounded-lg cursor-pointer border border-white/10 bg-transparent">
                    <span class="text-cream/50 text-sm">Pick a color for this club's theme</span>
                </div>
            </div>
            <div>
                <label class="label">Icon Key <span class="font-normal text-cream/30">(optional)</span></label>
                <input type="text" name="icon" value="{{ old('icon') }}" class="input" placeholder="e.g. chip, lightbulb">
            </div>
        </div>

        <div class="flex items-center gap-3 pt-2">
            <input type="hidden" name="is_active" value="0">
            <input type="checkbox" name="is_active" id="is_active" value="1" class="w-4 h-4 rounded accent-mint"
                   {{ old('is_active', 1) ? 'checked' : '' }}>
            <label for="is_active" class="text-sm font-semibold text-cream/70">Active (visible to parents and children)</label>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Create Club</button>
            <a href="{{ route('admin.clubs.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
