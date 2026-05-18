@extends('layouts.admin')
@section('title', 'Children')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Children</h1>
        <p class="text-cream/50 text-sm">All child profiles. Sorted by XP. Use the XP award tool to reward learners.</p>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}"
           class="input flex-1 max-w-xs" placeholder="Search by name...">
    <select name="rank" class="input w-auto appearance-none">
        <option value="">All Ranks</option>
        @foreach(['Explorer','Innovator','Builder','Creator','Master Inventor'] as $rank)
        <option value="{{ $rank }}" {{ request('rank') === $rank ? 'selected' : '' }}>{{ $rank }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-primary">Filter</button>
    @if(request()->hasAny(['search','rank']))
    <a href="{{ route('admin.children.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Child</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden sm:table-cell">Parent</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden md:table-cell">Rank</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">XP</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @php
                $rankColors = ['Explorer'=>'#4E9966','Innovator'=>'#D4A224','Builder'=>'#C24B1E','Creator'=>'#6B3FA0','Master Inventor'=>'#2E8BC0'];
                @endphp
                @forelse($children as $child)
                @php $color = $rankColors[$child->rank] ?? '#4E9966'; @endphp
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold flex-shrink-0"
                                 style="background:{{ $color }}15; border:1px solid {{ $color }}30; color:{{ $color }}">
                                {{ strtoupper(substr($child->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-sm">{{ $child->name }}</div>
                                <div class="text-cream/40 text-xs">Age {{ $child->age ?? 'N/A' }} &bull; {{ ucfirst($child->skill_level) }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell text-cream/60 text-sm">{{ $child->parent->name ?? 'Unknown' }}</td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="text-xs font-bold" style="color:{{ $color }}">{{ $child->rank }}</span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell">
                        <span class="font-display font-bold text-sm text-gold">{{ number_format($child->xp) }}</span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.children.show', $child) }}" class="btn-secondary text-xs px-3 py-2">View</a>
                            <form method="POST" action="{{ route('admin.children.destroy', $child) }}"
                                  onsubmit="return confirm('Delete {{ addslashes($child->name) }}\'s profile?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-cream/30 text-sm">No child profiles found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($children->hasPages())
    <div class="px-6 py-4 border-t border-white/5">{{ $children->links() }}</div>
    @endif
</div>
@endsection
