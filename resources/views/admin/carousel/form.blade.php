@extends('layouts.admin')
@section('title', $slide ? 'Edit Slide' : 'New Slide')

@section('content')

<div class="flex items-center gap-4 mb-8">
    <a href="{{ route('admin.carousel.index') }}" class="w-9 h-9 rounded-xl bg-white/5 hover:bg-white/10 flex items-center justify-center transition-all">
        <svg class="w-4 h-4 text-cream/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    </a>
    <div>
        <h1 class="font-display text-2xl font-bold">{{ $slide ? 'Edit Slide' : 'New Carousel Slide' }}</h1>
        <p class="text-cream/50 text-sm">{{ $slide ? 'Update this announcement slide.' : 'Create a new homepage announcement or promotional slide.' }}</p>
    </div>
</div>

<div class="card p-8 max-w-2xl">
    <form method="POST"
          action="{{ $slide ? route('admin.carousel.update', $slide) : route('admin.carousel.store') }}"
          enctype="multipart/form-data">
        @csrf
        @if($slide) @method('PUT') @endif

        @if($errors->any())
            <div class="mb-6 p-4 rounded-xl text-sm font-semibold" style="background:rgba(194,75,30,0.1);border:1px solid rgba(194,75,30,0.3);color:#C24B1E">
                @foreach($errors->all() as $err)<p>{{ $err }}</p>@endforeach
            </div>
        @endif

        <div class="space-y-6">
            <div>
                <label class="block text-cream/60 text-xs font-bold uppercase tracking-wider mb-2">Slide Title *</label>
                <input type="text" name="title" required value="{{ old('title', $slide?->title) }}"
                       placeholder="e.g. New Robotics Sessions Starting!"
                       class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-cream text-sm font-semibold focus:outline-none focus:border-mint/50 transition-colors">
            </div>

            <div>
                <label class="block text-cream/60 text-xs font-bold uppercase tracking-wider mb-2">Description</label>
                <textarea name="body" rows="3"
                          placeholder="Short description or promotional copy..."
                          class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-cream text-sm font-semibold focus:outline-none focus:border-mint/50 transition-colors resize-none">{{ old('body', $slide?->body) }}</textarea>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-cream/60 text-xs font-bold uppercase tracking-wider mb-2">Link URL</label>
                    <input type="url" name="link" value="{{ old('link', $slide?->link) }}"
                           placeholder="https://..."
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-cream text-sm font-semibold focus:outline-none focus:border-mint/50 transition-colors">
                </div>
                <div>
                    <label class="block text-cream/60 text-xs font-bold uppercase tracking-wider mb-2">Link Text</label>
                    <input type="text" name="link_text" value="{{ old('link_text', $slide?->link_text ?? 'Learn More') }}"
                           placeholder="Learn More"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-cream text-sm font-semibold focus:outline-none focus:border-mint/50 transition-colors">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4">
                <div>
                    <label class="block text-cream/60 text-xs font-bold uppercase tracking-wider mb-2">Background Colour</label>
                    <div class="flex items-center gap-3">
                        <input type="color" name="bg_color" value="{{ old('bg_color', $slide?->bg_color ?? '#F0FDF4') }}"
                               class="w-12 h-10 rounded-lg border border-white/10 bg-transparent cursor-pointer">
                        <input type="text" id="hex_display" value="{{ old('bg_color', $slide?->bg_color ?? '#F0FDF4') }}"
                               class="flex-1 bg-white/5 border border-white/10 rounded-xl px-4 py-2.5 text-cream text-sm font-semibold focus:outline-none" readonly>
                    </div>
                </div>
                <div>
                    <label class="block text-cream/60 text-xs font-bold uppercase tracking-wider mb-2">Sort Order</label>
                    <input type="number" name="sort_order" min="0" value="{{ old('sort_order', $slide?->sort_order ?? 0) }}"
                           class="w-full bg-white/5 border border-white/10 rounded-xl px-4 py-3 text-cream text-sm font-semibold focus:outline-none focus:border-mint/50 transition-colors">
                </div>
            </div>

            <div>
                <label class="block text-cream/60 text-xs font-bold uppercase tracking-wider mb-2">Slide Image</label>
                @if($slide?->image)
                    <div class="mb-3">
                        <img src="{{ $slide->image }}" alt="Current" class="h-28 w-auto rounded-xl object-cover border border-white/10">
                        <p class="text-cream/40 text-xs mt-1">Upload a new image to replace the current one.</p>
                    </div>
                @endif
                <input type="file" name="image" accept="image/*"
                       class="w-full text-cream/70 text-sm file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:font-bold file:text-xs file:cursor-pointer"
                       style="file:background:rgba(78,153,102,0.2);file:color:#4E9966">
                <p class="text-cream/30 text-xs mt-2">Max 2MB. JPEG, PNG or WebP recommended.</p>
            </div>

            <div class="flex items-center gap-3 py-4 border-t border-white/5">
                <label class="relative inline-flex items-center cursor-pointer">
                    <input type="checkbox" name="active" value="1" class="sr-only peer"
                           {{ old('active', $slide?->active ?? true) ? 'checked' : '' }}>
                    <div class="w-11 h-6 rounded-full peer transition-all peer-checked:bg-mint bg-white/10 peer-focus:ring-2 peer-focus:ring-mint/30"></div>
                    <div class="absolute left-0.5 top-0.5 w-5 h-5 bg-white rounded-full transition-all peer-checked:translate-x-5"></div>
                </label>
                <span class="text-cream/70 text-sm font-bold">Show on homepage</span>
            </div>
        </div>

        <div class="flex gap-3 mt-8 pt-6 border-t border-white/5">
            <button type="submit"
                    class="flex-1 py-3.5 rounded-xl font-bold text-white text-sm transition-all hover:scale-[1.01]"
                    style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
                {{ $slide ? 'Save Changes' : 'Create Slide' }}
            </button>
            <a href="{{ route('admin.carousel.index') }}"
               class="px-6 py-3.5 rounded-xl bg-white/5 hover:bg-white/10 text-cream/60 text-sm font-bold transition-all">
                Cancel
            </a>
        </div>
    </form>
</div>

@push('scripts')
<script>
    const colorInput = document.querySelector('input[type="color"]');
    const hexDisplay = document.getElementById('hex_display');
    if (colorInput && hexDisplay) {
        colorInput.addEventListener('input', () => hexDisplay.value = colorInput.value);
    }
</script>
@endpush

@endsection
