@extends('layouts.admin')
@section('title', 'Site Settings')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Site Settings</h1>
        <p class="text-cream/50 text-sm">Control all platform-wide configuration from here. Add custom settings anytime.</p>
    </div>
    <a href="{{ route('admin.settings.create') }}" class="btn-secondary self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Setting
    </a>
</div>

@if($settings->isEmpty())
<div class="card p-12 text-center">
    <p class="text-cream/30 mb-4">No settings configured yet.</p>
    <a href="{{ route('admin.settings.create') }}" class="btn-primary">Create the first setting</a>
</div>
@else

<form method="POST" action="{{ route('admin.settings.update') }}">
    @csrf

    @foreach($settings as $group => $groupSettings)
    <div class="card p-6 mb-6">
        <h2 class="font-display text-lg font-bold mb-5 capitalize">{{ str_replace('_', ' ', $group) }}</h2>
        <div class="space-y-5">
            @foreach($groupSettings as $i => $setting)
            <input type="hidden" name="settings[{{ $loop->index + (($settings->keys()->search($group)) * 100) }}][key]" value="{{ $setting['key'] }}">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-4 items-start">
                <div class="md:col-span-1">
                    <label class="label">{{ $setting['label'] }}</label>
                    <p class="text-cream/30 text-xs font-mono mt-0.5">{{ $setting['key'] }}</p>
                </div>
                <div class="md:col-span-2 flex items-start gap-3">
                    @if($setting['type'] === 'textarea')
                        <textarea name="settings[{{ $loop->index + (($settings->keys()->search($group)) * 100) }}][value]"
                                  rows="3" class="input resize-none flex-1">{{ $setting['value'] }}</textarea>
                    @elseif($setting['type'] === 'color')
                        <input type="color"
                               name="settings[{{ $loop->index + (($settings->keys()->search($group)) * 100) }}][value]"
                               value="{{ $setting['value'] ?? '#4E9966' }}"
                               class="h-12 w-20 rounded-lg cursor-pointer border border-white/10 bg-transparent">
                    @elseif($setting['type'] === 'boolean')
                        <select name="settings[{{ $loop->index + (($settings->keys()->search($group)) * 100) }}][value]"
                                class="input w-auto appearance-none">
                            <option value="1" {{ $setting['value'] === '1' ? 'selected' : '' }}>Enabled</option>
                            <option value="0" {{ $setting['value'] !== '1' ? 'selected' : '' }}>Disabled</option>
                        </select>
                    @else
                        <input type="{{ $setting['type'] === 'number' ? 'number' : 'text' }}"
                               name="settings[{{ $loop->index + (($settings->keys()->search($group)) * 100) }}][value]"
                               value="{{ $setting['value'] }}"
                               class="input flex-1">
                    @endif
                    <form method="POST" action="{{ route('admin.settings.destroy', $setting['id']) }}" class="flex-shrink-0"
                          onsubmit="return confirm('Delete setting \'{{ $setting['key'] }}\'?')">
                        @csrf @method('DELETE')
                        <button type="submit" class="btn-danger" title="Delete this setting">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                        </button>
                    </form>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="sticky bottom-4">
        <button type="submit" class="btn-primary shadow-lg shadow-mint/20">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/></svg>
            Save All Settings
        </button>
    </div>
</form>
@endif
@endsection
