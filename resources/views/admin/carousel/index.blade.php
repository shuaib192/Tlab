@extends('layouts.admin')
@section('title', 'Carousel / Announcements')

@section('content')

<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Homepage Carousel</h1>
        <p class="text-cream/50 text-sm">Manage announcement slides shown on the public homepage.</p>
    </div>
    <a href="{{ route('admin.carousel.create') }}" class="inline-flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-white text-sm"
       style="background:linear-gradient(135deg,#0DAA9C,#0A9184)">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add Slide
    </a>
</div>

@if(session('success'))
    <div class="mb-6 px-5 py-4 rounded-2xl font-semibold text-sm" style="background:rgba(13,170,156,0.15);border:1px solid rgba(13,170,156,0.3);color:#0DAA9C">{{ session('success') }}</div>
@endif

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-gray-200">
                    <th class="text-left px-6 py-4 text-cream/40 font-bold uppercase tracking-wider text-xs">Order</th>
                    <th class="text-left px-6 py-4 text-cream/40 font-bold uppercase tracking-wider text-xs">Title</th>
                    <th class="text-left px-6 py-4 text-cream/40 font-bold uppercase tracking-wider text-xs hidden md:table-cell">Body</th>
                    <th class="text-left px-6 py-4 text-cream/40 font-bold uppercase tracking-wider text-xs">Status</th>
                    <th class="text-left px-6 py-4 text-cream/40 font-bold uppercase tracking-wider text-xs">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-white/5">
                @forelse($slides as $slide)
                <tr class="table-row hover:bg-gray-50 transition-colors">
                    <td class="px-6 py-4">
                        <span class="w-8 h-8 rounded-lg bg-gray-50 flex items-center justify-center font-bold text-cream/50 text-xs">{{ $slide->sort_order }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            @if($slide->image)
                                <img src="{{ $slide->image }}" alt="{{ $slide->title }}" class="w-12 h-10 rounded-lg object-cover flex-shrink-0">
                            @else
                                <div class="w-12 h-10 rounded-lg flex-shrink-0" style="background:{{ $slide->bg_color }}"></div>
                            @endif
                            <div class="font-semibold truncate max-w-xs">{{ $slide->title }}</div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-cream/50 hidden md:table-cell max-w-xs">
                        <p class="truncate text-xs">{{ $slide->body ?? '—' }}</p>
                    </td>
                    <td class="px-6 py-4">
                        <form method="POST" action="{{ route('admin.carousel.toggle', $slide) }}">
                            @csrf @method('PATCH')
                            <button type="submit" class="px-3 py-1 rounded-full text-xs font-bold transition-all"
                                    style="{{ $slide->active ? 'background:rgba(13,170,156,0.12);color:#0A7A6E;border:1px solid rgba(13,170,156,0.3)' : 'background:#F1F5F4;color:#5B6B69;border:1px solid #E1E8E7' }}">
                                {{ $slide->active ? 'Active' : 'Hidden' }}
                            </button>
                        </form>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-2">
                            <a href="{{ route('admin.carousel.edit', $slide) }}"
                               class="px-3 py-1.5 rounded-lg bg-gray-50 hover:bg-gray-100 text-cream/60 hover:text-cream text-xs font-bold transition-all">
                                Edit
                            </a>
                            <form method="POST" action="{{ route('admin.carousel.destroy', $slide) }}" onsubmit="return confirm('Delete this slide?')">
                                @csrf @method('DELETE')
                                <button class="px-3 py-1.5 rounded-lg text-xs font-bold transition-all"
                                        style="background:rgba(194,75,30,0.1);color:#B03F14;border:1px solid rgba(194,75,30,0.2)">
                                    Delete
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="5" class="px-6 py-16 text-center text-cream/30 text-sm">
                        No carousel slides yet.
                        <a href="{{ route('admin.carousel.create') }}" class="text-mint font-bold hover:underline ml-1">Add the first one.</a>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-gray-200">
        {{ $slides->links() }}
    </div>
</div>

@endsection
