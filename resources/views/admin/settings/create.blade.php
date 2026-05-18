@extends('layouts.admin')
@section('title', 'Add Setting')
@section('content')

<div class="mb-8">
    <a href="{{ route('admin.settings.index') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-4 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Settings
    </a>
    <h1 class="font-display text-3xl font-bold">Add Custom Setting</h1>
    <p class="text-cream/50 text-sm mt-1">Create any new platform setting — it will immediately appear in the settings panel.</p>
</div>

<div class="max-w-xl">
    @if($errors->any())
    <div class="flash-error mb-6">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('admin.settings.store') }}" class="card p-6 space-y-5">
        @csrf

        <div>
            <label class="label">Setting Key <span class="font-normal text-cream/30">(unique identifier, e.g. site_name)</span></label>
            <input type="text" name="key" value="{{ old('key') }}" required class="input font-mono" placeholder="site_name">
        </div>

        <div>
            <label class="label">Label <span class="font-normal text-cream/30">(human readable)</span></label>
            <input type="text" name="label" value="{{ old('label') }}" required class="input" placeholder="Site Name">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="label">Group</label>
                <input type="text" name="group" value="{{ old('group', 'general') }}" required class="input" placeholder="general">
                <p class="text-cream/30 text-xs mt-1">e.g. general, appearance, contact, gamification</p>
            </div>
            <div>
                <label class="label">Input Type</label>
                <select name="type" class="input appearance-none">
                    <option value="text"     {{ old('type') === 'text'     ? 'selected' : '' }}>Text</option>
                    <option value="textarea" {{ old('type') === 'textarea' ? 'selected' : '' }}>Textarea</option>
                    <option value="color"    {{ old('type') === 'color'    ? 'selected' : '' }}>Color Picker</option>
                    <option value="number"   {{ old('type') === 'number'   ? 'selected' : '' }}>Number</option>
                    <option value="boolean"  {{ old('type') === 'boolean'  ? 'selected' : '' }}>Toggle (Boolean)</option>
                    <option value="image"    {{ old('type') === 'image'    ? 'selected' : '' }}>Image URL</option>
                </select>
            </div>
        </div>

        <div>
            <label class="label">Default Value <span class="font-normal text-cream/30">(optional)</span></label>
            <input type="text" name="value" value="{{ old('value') }}" class="input">
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Create Setting</button>
            <a href="{{ route('admin.settings.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
