@extends('layouts.admin')
@section('title', 'Clubs')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Clubs</h1>
        <p class="text-cream/50 text-sm">Manage all TLab learning clubs. Each club contains multiple courses.</p>
    </div>
    <a href="{{ route('admin.clubs.create') }}" class="btn-primary self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Club
    </a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Club</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden sm:table-cell">Age Range</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden md:table-cell">Courses</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">Status</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($clubs as $club)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-display font-black text-sm flex-shrink-0"
                                 style="background:{{ $club->color_theme }}18; border:1px solid {{ $club->color_theme }}35; color:{{ $club->color_theme }}">
                                {{ strtoupper(substr($club->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-sm">{{ $club->name }}</div>
                                <div class="text-cream/40 text-xs truncate max-w-xs">{{ Str::limit($club->description, 60) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 text-sm text-cream/60 hidden sm:table-cell">{{ $club->min_age }}–{{ $club->max_age }} yrs</td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="font-display font-bold text-sm" style="color:{{ $club->color_theme }}">{{ $club->courses_count }}</span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        <span class="badge {{ $club->is_active ? 'badge-green' : 'badge-red' }}">
                            {{ $club->is_active ? 'Active' : 'Inactive' }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.clubs.edit', $club) }}" class="btn-secondary text-xs px-3 py-2">Edit</a>
                            <form method="POST" action="{{ route('admin.clubs.destroy', $club) }}"
                                  onsubmit="return confirm('Delete club {{ addslashes($club->name) }}? All courses will also be deleted.')">
                                @csrf @method('DELETE')
                                <button class="btn-danger text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-cream/30 text-sm">No clubs created yet. <a href="{{ route('admin.clubs.create') }}" class="text-mint hover:underline">Create the first one.</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($clubs->hasPages())
    <div class="px-6 py-4 border-t border-white/5">{{ $clubs->links() }}</div>
    @endif
</div>
@endsection
