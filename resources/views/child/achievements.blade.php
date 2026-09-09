@extends('layouts.child')
@section('title', $child->name . ' — Achievements')

@section('content')
<div class="max-w-4xl mx-auto">
    <div class="flex items-center justify-between mb-8 reveal pop-in">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-2xl bg-gold/15 border-2 border-gold/30 grid place-items-center">
                <svg class="w-5 h-5 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
            </div>
            <h1 class="font-display font-extrabold text-2xl text-cream">{{ $child->name }}'s Achievements</h1>
            <span class="sticker px-3 py-1.5 bg-gold/15 text-gold">{{ count($earnedIds) }} / {{ count($achievements) }} unlocked</span>
        </div>
    </div>

    @php
        $categories = $achievements->groupBy('category');
    @endphp

    @foreach($categories as $category => $catAchievements)
    <div class="mb-10 reveal">
        <h2 class="font-display font-extrabold text-lg text-cream mb-4 capitalize">{{ $category }}</h2>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
            @foreach($catAchievements as $achievement)
            @php $earned = in_array($achievement->id, $earnedIds); @endphp
            <div class="relative rounded-[1.4rem] p-5 transition-all duration-300 {{ $earned ? 'candy-card hard-shadow-sm border-cream/20' : 'bg-surface/40 border-2 border-dashed border-cream/15 opacity-70' }}">
                <div class="flex items-start gap-4">
                    <div class="w-12 h-12 rounded-2xl grid place-items-center text-2xl flex-shrink-0 border-2 {{ $earned ? 'bg-gold/15 border-gold/30' : 'bg-cream/5 border-cream/10' }}">
                        @if($earned)
                            @if($achievement->icon)
                                <span class="leading-none">{{ $achievement->icon }}</span>
                            @else
                                <svg class="w-6 h-6 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                            @endif
                        @else
                            <svg class="w-6 h-6 text-cream/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                        @endif
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-black text-sm {{ $earned ? 'text-cream' : 'text-cream/50' }}">{{ $achievement->name }}</div>
                        <div class="text-xs text-cream/40 font-semibold mt-0.5">{{ $achievement->description }}</div>
                        @if($achievement->xp_reward > 0)
                        <div class="text-xs font-black text-gold mt-1.5">{{ $achievement->xp_reward }} XP</div>
                        @endif
                    </div>
                    @if($earned)
                    <svg class="w-5 h-5 text-mint flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endforeach

    <div class="candy-card hard-shadow rounded-[2rem] p-6 sm:p-8 text-center mt-8 reveal"
         style="background:linear-gradient(160deg,rgba(255,217,61,.16),rgba(255,107,181,.10))">
        <div class="w-16 h-16 rounded-2xl bg-gold/20 border-2 border-gold/30 grid place-items-center mx-auto mb-4">
            <svg class="w-8 h-8 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
        </div>
        <h2 class="font-display font-extrabold text-xl text-cream mb-2">Total XP from Achievements</h2>
        <div class="font-display font-extrabold text-4xl text-gold">{{ number_format($totalXpFromAchievements) }} XP</div>
        <p class="text-cream/50 text-sm mt-2 font-bold">Keep learning to unlock more achievements!</p>
    </div>
</div>
@endsection
