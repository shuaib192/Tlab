@extends('layouts.app')
@section('title', $child->name . ' — Achievements')

@section('content')
<div class="max-w-4xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center bg-amber-50">
                <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <h1 class="font-black text-2xl text-ink">{{ $child->name }}'s Achievements</h1>
            <span class="text-xs font-bold bg-amber-50 text-amber-600 px-3 py-1.5 rounded-full">{{ count($earnedIds) }} / {{ count($achievements) }} unlocked</span>
        </div>
    </div>

    @php
        $categories = $achievements->groupBy('category');
    @endphp

    @foreach($categories as $category => $catAchievements)
    <div class="mb-10">
        <h2 class="font-black text-lg text-ink mb-4 capitalize">{{ $category }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($catAchievements as $achievement)
            @php $earned = in_array($achievement->id, $earnedIds); @endphp
            <div class="relative rounded-2xl p-5 transition-all duration-300 {{ $earned ? 'bg-white border-2 border-amber-200 shadow-sm' : 'bg-gray-50 border-2 border-dashed border-gray-200 opacity-60' }}">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-2xl flex-shrink-0 {{ $earned ? 'bg-amber-50' : 'bg-gray-100' }}">
                        {{ $earned ? ($achievement->icon ?? '🏆') : '🔒' }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-sm {{ $earned ? 'text-ink' : 'text-muted' }}">{{ $achievement->name }}</div>
                        <div class="text-xs text-muted mt-0.5">{{ $achievement->description }}</div>
                        @if($achievement->xp_reward > 0)
                        <div class="text-xs font-bold text-amber-600 mt-1.5">{{ $achievement->xp_reward }} XP</div>
                        @endif
                    </div>
                    @if($earned)
                    <svg class="w-5 h-5 text-emerald-500 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="bg-gradient-to-br from-amber-50 to-amber-100/50 rounded-3xl p-6 sm:p-8 text-center mt-8">
        <div class="w-16 h-16 rounded-2xl bg-amber-200/50 flex items-center justify-center mx-auto mb-4">
            <svg class="w-8 h-8 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
        <h2 class="font-black text-xl text-ink mb-2">Total XP from Achievements</h2>
        <div class="font-black text-4xl text-amber-600">{{ number_format($totalXpFromAchievements) }} XP</div>
        <p class="text-muted text-sm mt-2">Keep learning to unlock more achievements!</p>
    </div>
</div>
@endsection
