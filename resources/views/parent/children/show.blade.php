@extends('layouts.app')

@section('title', $child->name . ' — Profile')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-8 py-12">

    {{-- Back --}}
    <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-8 transition-colors font-medium text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Dashboard
    </a>

    @if(session('success')) <div class="flash flash-success mb-6">{{ session('success') }}</div> @endif

    {{-- Header Card --}}
    @php
        $rankColors = [
            'Explorer'       => '#4E9966',
            'Innovator'      => '#D4A224',
            'Builder'        => '#C24B1E',
            'Creator'        => '#6B3FA0',
            'Master Inventor'=> '#2E8BC0',
        ];
        $color = $rankColors[$child->rank] ?? '#4E9966';
    @endphp

    <div class="glass rounded-3xl p-6 sm:p-8 mb-6 flex flex-col sm:flex-row items-start sm:items-center gap-6">
        <div class="w-20 h-20 rounded-2xl flex items-center justify-center font-display text-4xl font-black flex-shrink-0"
             style="background:{{ $color }}15; border:2px solid {{ $color }}40; color:{{ $color }}">
            {{ strtoupper(substr($child->name, 0, 1)) }}
        </div>
        <div class="flex-1">
            <div class="flex flex-wrap items-center gap-3 mb-1">
                <h1 class="font-display text-2xl sm:text-3xl font-bold">{{ $child->name }}</h1>
                <span class="rank-badge" style="background:{{ $color }}15; border:1px solid {{ $color }}40; color:{{ $color }}">
                    {{ $child->rank }}
                </span>
            </div>
            <p class="text-cream/50 text-sm">Age {{ $child->age ?? 'N/A' }} &bull; {{ ucfirst($child->skill_level) }} &bull; {{ number_format($child->xp) }} XP</p>
        </div>
        <div class="flex gap-3 w-full sm:w-auto">
            <a href="{{ route('parent.children.switch', $child) }}"
               class="flex-1 sm:flex-none text-center px-5 py-3 rounded-xl font-bold text-white text-sm transition-all hover:scale-105"
               style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
               Open Dashboard
            </a>
            <a href="{{ route('parent.children.edit', $child) }}"
               class="flex-1 sm:flex-none text-center px-5 py-3 rounded-xl glass font-bold text-cream/70 text-sm hover:text-cream transition-all">
               Edit Profile
            </a>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 gap-6">

        {{-- XP & Rank Progress --}}
        <div class="glass rounded-3xl p-6">
            <h2 class="font-display text-lg font-bold mb-5">Learning Progress</h2>
            <div class="mb-4">
                <div class="flex justify-between text-sm mb-2">
                    <span class="font-bold text-cream/70">Current XP</span>
                    <span class="font-bold" style="color:{{ $color }}">{{ number_format($child->xp) }}</span>
                </div>
                <div class="xp-bar">
                    <div class="xp-fill" style="width:{{ $child->rank_progress }}%"></div>
                </div>
                <p class="text-cream/40 text-xs mt-2">{{ $child->xp_to_next_rank }} XP to next rank</p>
            </div>

            <div class="space-y-2 mt-5">
                @foreach(['Explorer'=>[0,'#4E9966'], 'Innovator'=>[200,'#D4A224'], 'Builder'=>[500,'#C24B1E'], 'Creator'=>[1000,'#6B3FA0'], 'Master Inventor'=>[2000,'#2E8BC0']] as $r => [$t, $c])
                <div class="flex items-center justify-between px-3 py-2 rounded-xl {{ $child->rank === $r ? 'border' : '' }}"
                     style="{{ $child->rank === $r ? "background:{$c}10; border-color:{$c}40" : '' }}">
                    <span class="text-sm font-medium {{ $child->xp >= $t ? '' : 'opacity-40' }}">{{ $r }}</span>
                    <span class="text-xs text-cream/40">{{ number_format($t) }} XP</span>
                </div>
                @endforeach
            </div>
        </div>

        {{-- Enrolled Courses --}}
        <div class="glass rounded-3xl p-6">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-display text-lg font-bold">Enrolled Courses</h2>
                <span class="text-cream/40 text-sm">{{ $enrollments->count() }}</span>
            </div>
            @forelse($enrollments as $e)
            @php $clubColor = $rankColors[array_key_first($rankColors)] ?? '#4E9966'; @endphp
            <div class="flex items-center gap-3 p-3 rounded-xl bg-white/5 mb-2">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold flex-shrink-0"
                     style="background:{{ $e->course->club->color_theme ?? '#4E9966' }}15; color:{{ $e->course->club->color_theme ?? '#4E9966' }}">
                    {{ strtoupper(substr($e->course->club->name ?? 'C', 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-sm truncate">{{ $e->course->title }}</div>
                    <div class="text-cream/50 text-xs">{{ $e->course->club->name ?? '' }}</div>
                </div>
                <span class="text-xs px-2 py-1 rounded-full font-bold flex-shrink-0"
                      style="background:{{ $e->status === 'active' ? 'rgba(78,153,102,0.15)' : 'rgba(250,245,232,0.05)' }}; color:{{ $e->status === 'active' ? '#4E9966' : 'rgba(250,245,232,0.4)' }}">
                    {{ ucfirst($e->status) }}
                </span>
            </div>
            @empty
            <p class="text-cream/40 text-sm text-center py-8">No courses enrolled yet.</p>
            @endforelse
        </div>

        {{-- Recent XP Activity --}}
        <div class="glass rounded-3xl p-6 md:col-span-2">
            <h2 class="font-display text-lg font-bold mb-5">Recent XP History</h2>
            @forelse($xpLogs as $log)
            <div class="flex items-center justify-between py-3 border-b border-white/5 last:border-0">
                <div>
                    <div class="font-medium text-sm">{{ $log->activity }}</div>
                    <div class="text-cream/40 text-xs">{{ $log->created_at->diffForHumans() }}</div>
                </div>
                <span class="font-display font-bold text-sm" style="color:#D4A224">+{{ $log->amount }} XP</span>
            </div>
            @empty
            <p class="text-cream/40 text-sm text-center py-8">No XP activity recorded yet.</p>
            @endforelse
        </div>

    </div>

    {{-- Danger Zone --}}
    <div class="glass rounded-3xl p-6 mt-6 border border-terra/20">
        <h2 class="font-display text-lg font-bold mb-2 text-terra">Remove Profile</h2>
        <p class="text-cream/50 text-sm mb-4">Permanently deletes {{ $child->name }}'s profile, XP history, and all enrollments. This cannot be undone.</p>
        <form method="POST" action="{{ route('parent.children.destroy', $child) }}"
              onsubmit="return confirm('Are you sure you want to permanently delete {{ $child->name }}\'s profile?')">
            @csrf
            @method('DELETE')
            <button type="submit"
                    class="px-6 py-3 rounded-xl font-bold text-sm text-terra border border-terra/30 hover:bg-terra/10 transition-all">
                Remove This Profile
            </button>
        </form>
    </div>

</div>
@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.querySelector('.xp-fill');
        if (bar) {
            const w = bar.style.width; bar.style.width = '0%';
            setTimeout(() => { bar.style.width = w; }, 200);
        }
    });
</script>
@endpush
