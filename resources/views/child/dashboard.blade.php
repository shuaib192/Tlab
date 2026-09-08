@extends('layouts.child')

@section('title', $child->name . "'s Mission Control")

@php
    $rankColors = [
        'Explorer'       => ['c'=>'#4DFFA2','emoji'=>'🌱'],
        'Innovator'      => ['c'=>'#5AD7FF','emoji'=>'⚡'],
        'Builder'        => ['c'=>'#FFD93D','emoji'=>'🔧'],
        'Creator'        => ['c'=>'#FF6BB5','emoji'=>'🎨'],
        'Master Inventor'=> ['c'=>'#9B7BFF','emoji'=>'🚀'],
    ];
    $rc = $rankColors[$child->rank] ?? $rankColors['Explorer'];
    $first = explode(' ', $child->name)[0];
    $planetPath = [
        ['Explorer', 0, '🌱', '#4DFFA2'],
        ['Innovator', 200, '⚡', '#5AD7FF'],
        ['Builder', 500, '🔧', '#FFD93D'],
        ['Creator', 1000, '🎨', '#FF6BB5'],
        ['Master Inventor', 2000, '🚀', '#9B7BFF'],
    ];
    $missionColors = [
        'stem-club'      => ['c'=>'#4DFFA2','emoji'=>'🔬'],
        'brain-club'     => ['c'=>'#5AD7FF','emoji'=>'🧠'],
        'art-craft-club' => ['c'=>'#FF6B4D','emoji'=>'🎨'],
        'leadership-club'=> ['c'=>'#9B7BFF','emoji'=>'⭐'],
    ];
@endphp

@section('content')

{{-- HERO — candy welcome panel --}}
<section class="relative overflow-hidden rounded-[2rem] border-[3px] border-cream/25 hard-shadow mb-8 reveal pop-in"
         style="background:linear-gradient(135deg,#FFD93D 0%,#FFC94D 55%,#FFB347 100%)">
    <div class="absolute -right-10 -top-10 text-7xl rotate-12 select-none opacity-20">🚀</div>
    <div class="absolute -left-8 -bottom-12 text-8xl -rotate-12 select-none opacity-10">🪐</div>

    <div class="relative z-10 p-6 sm:p-8 flex flex-col sm:flex-row items-start sm:items-center gap-5">
        <div class="relative flex-shrink-0">
            <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-[1.4rem] grid place-items-center font-display font-extrabold text-4xl sm:text-5xl text-space border-[3px] border-space bg-cream shadow-[6px_6px_0_#0a0718]">
                {{ strtoupper(substr($child->name, 0, 1)) }}
            </div>
            <div class="absolute -top-2 -right-2 w-9 h-9 rounded-full grid place-items-center text-lg bg-cream border-[2.5px] border-space shadow-[3px_3px_0_#0a0718] bounce-in">
                {{ $rc['emoji'] }}
            </div>
        </div>

        <div class="flex-1 min-w-0">
            <div class="flex items-center gap-2 flex-wrap mb-1">
                <h1 class="font-display font-extrabold text-3xl sm:text-4xl text-space leading-none">Hey {{ $first }}! 👋</h1>
                <span class="sticker bg-space text-cream px-3 py-1 text-xs font-black">
                    {{ $rc['emoji'] }} {{ $child->rank }}
                </span>
            </div>
            <p class="text-space/60 font-extrabold text-sm mt-1">
                {{ $child->age ? 'Age ' . $child->age . ' · ' : '' }}{{ ucfirst($child->skill_level) }} level · mission status: LOCKED &amp; LOADED
            </p>

            <div class="mt-4 max-w-md">
                <div class="flex justify-between items-end text-xs font-black mb-1.5">
                    <span class="sticker bg-space text-gold px-2.5 py-1 text-[11px]">⚡ ENERGY</span>
                    <span class="text-space/70 font-bold">{{ number_format($child->xp) }} / {{ number_format($child->xp_to_next_rank) }} to next rank</span>
                </div>
                <div class="h-4 rounded-full bg-space/20 border-2 border-space overflow-hidden relative">
                    <div class="h-full rounded-full relative transition-all duration-1000 ease-out" id="xp-bar" data-progress="{{ $child->rank_progress }}"
                         style="width:0%;background:#171033">
                        <span class="absolute -right-2 top-1/2 -translate-y-1/2 text-sm">🚀</span>
                    </div>
                </div>
            </div>
        </div>

        <div class="flex-shrink-0 text-center px-5 py-3 rounded-2xl bg-cream border-[3px] border-space shadow-[5px_5px_0_#0a0718]">
            <div class="font-display font-extrabold text-3xl text-space tabular-nums">{{ number_format($child->xp) }}</div>
            <div class="text-space/50 text-[10px] font-black uppercase tracking-widest mt-0.5">Total XP</div>
        </div>
    </div>
</section>

{{-- PLANET PATH — the rank ladder as orbiting planets --}}
<section class="candy-card hard-shadow p-5 sm:p-6 mb-8 reveal" data-delay="60">
    <div class="flex items-center justify-between flex-wrap gap-2 mb-5">
        <h2 class="font-display font-extrabold text-lg text-cream flex items-center gap-2">
            <span class="text-xl">🪐</span> YOUR PLANET PATH
        </h2>
        <span class="museum text-mint blink-caret">// RANK UP BY EARNING XP //</span>
    </div>
    <div class="flex items-start justify-between gap-1 sm:gap-2 overflow-x-auto pb-2">
        @foreach($planetPath as [$rankName, $threshold, $emoji, $color])
            @php
                $achieved = $child->xp >= $threshold;
                $isCurrent = $child->rank === $rankName;
            @endphp
            <div class="flex flex-col items-center flex-shrink-0 px-1" style="min-width:74px">
                <div class="planet-core {{ (!$achieved && !$isCurrent) ? 'planet-locked' : '' }} relative w-16 h-16 sm:w-18 sm:h-18 rounded-full grid place-items-center text-2xl sm:text-3xl border-[3px] border-space mb-2"
                     style="background:radial-gradient(circle at 35% 30%, {{ $color }}, #FFFFFFFF 180%); box-shadow:0 0 0 3px {{ $color . '55' }}, 4px 4px 0 #0a0718">
                    {{ $emoji }}
                    @if($isCurrent)
                        <span class="absolute -top-2 -right-2 text-[10px] font-black bg-cream text-space border-2 border-space rounded-full px-1.5 py-0.5 shadow-[2px_2px_0_#0a0718]">YOU</span>
                    @elseif($achieved)
                        <span class="absolute -top-1 -right-1 text-xs">✅</span>
                    @endif
                </div>
                <div class="text-center">
                    <div class="text-xs font-black {{ $isCurrent ? 'text-mint' : (($achieved ? 'text-cream' : 'text-cream/40')) }}">{{ $rankName }}</div>
                    <div class="text-[10px] font-bold {{ $achieved || $isCurrent ? 'text-cream/50' : 'text-cream/25' }}">{{ number_format($threshold) }} XP</div>
                </div>
            </div>
        @endforeach
    </div>
</section>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- LEFT: missions + activity --}}
    <div class="lg:col-span-2 space-y-6">

        {{-- MY MISSIONS --}}
        <section class="candy-card hard-shadow p-5 sm:p-6 reveal" data-delay="100">
            <div class="flex items-center justify-between mb-5">
                <h2 class="font-display font-extrabold text-lg text-cream flex items-center gap-2">
                    <span class="text-xl">🗺️</span> MY MISSIONS
                </h2>
                <span class="text-xs font-black bg-cream/10 text-cream/70 border-2 border-cream/15 rounded-full px-3 py-1">{{ $child->enrollments->count() }} locked in</span>
            </div>

            @if($child->enrollments->isEmpty())
                <div class="text-center py-12">
                    <div class="text-6xl mb-4 float inline-block">📦</div>
                    <p class="text-cream/70 font-extrabold">No missions yet!</p>
                    <p class="text-cream/40 text-sm font-bold mt-1">Ask your parent to unlock something fun 🎯</p>
                </div>
            @else
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    @foreach($child->enrollments as $enrollment)
                    @php
                        $cc = $missionColors[$enrollment->course->club->slug ?? ''] ?? ['c'=>'#FFD93D','emoji'=>'📖'];
                        $totalLessons = $enrollment->course->modules->sum(fn($m) => $m->lessons->count());
                        $completedLessons = 0;
                        foreach ($enrollment->course->modules as $mod) {
                            foreach ($mod->lessons as $lsn) {
                                if ($lsn->assessment && in_array($lsn->assessment->id, $completedAssessmentIds)) {
                                    $completedLessons++;
                                }
                            }
                        }
                        $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                    @endphp
                    <a href="{{ route('child.course', $enrollment->id) }}"
                       class="group relative rounded-[1.4rem] bg-cream border-[3px] border-space p-5 hard-shadow-sm transition-all duration-250 hover:-translate-y-1 hover:rotate-[0.6deg] hover:shadow-[8px_8px_0_#0a0718] active:scale-[0.98] block">
                        <div class="flex items-center gap-3 mb-4">
                            <div class="w-12 h-12 rounded-2xl grid place-items-center text-2xl border-[2.5px] border-space flex-shrink-0 shadow-[3px_3px_0_#0a0718]"
                                 style="background:{{ $cc['c'] }}">
                                {{ $cc['emoji'] }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-display font-extrabold text-sm text-space truncate">{{ $enrollment->course->title ?? 'Mission' }}</div>
                                <div class="text-[11px] font-black text-space/50 truncate">{{ $enrollment->course->club->name ?? 'Club' }}</div>
                            </div>
                        </div>

                        @if($totalLessons > 0)
                        <div class="flex items-center gap-3 mb-4">
                            <div class="flex-1 h-3 rounded-full border-2 border-space bg-white overflow-hidden">
                                <div class="h-full transition-all duration-700 relative" style="width:{{ $courseProgress }}%;background:{{ $cc['c'] }}">
                                    <span class="absolute -right-2 top-1/2 -translate-y-1/2 text-xs">🚀</span>
                                </div>
                            </div>
                            <span class="text-xs font-black text-space tabular-nums">{{ $completedLessons }}/{{ $totalLessons }}</span>
                        </div>
                        @endif

                        <div class="flex items-center justify-between pt-3 border-t-2 border-space/10">
                            <span class="sticker px-2.5 py-1 text-[10px] font-black text-space" style="background:{{ $enrollment->status === 'active' ? 'rgba(77,255,162,.7)' : 'rgba(255,246,233,.6)' }}">
                                {{ $enrollment->status === 'active' ? 'ACTIVE' : ucfirst($enrollment->status) }}
                            </span>
                            <span class="inline-flex items-center gap-1 text-xs font-black text-space group-hover:translate-x-1 transition-transform">
                                CONTINUE
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                        </div>
                    </a>
                    @endforeach
                </div>
            @endif
        </section>

        {{-- XP ACTIVITY --}}
        <section class="candy-card hard-shadow p-5 sm:p-6 reveal" data-delay="140">
            <h2 class="font-display font-extrabold text-lg text-cream flex items-center gap-2 mb-5">
                <span class="text-xl">🎉</span> BIG XP MOMENTS
            </h2>
            @if($child->xpLogs->isEmpty())
                <div class="text-center py-10">
                    <div class="text-5xl mb-4 float">⭐</div>
                    <p class="text-cream/70 font-extrabold">No XP yet — go complete a mission!</p>
                </div>
            @else
                <div class="space-y-3">
                    @foreach($child->xpLogs as $log)
                    <div class="flex items-center justify-between gap-3 rounded-2xl border-2 border-cream/10 bg-surface/60 px-4 py-3 hover:border-cream/25 transition-colors">
                        <div class="flex items-center gap-3 min-w-0">
                            <div class="w-10 h-10 rounded-xl grid place-items-center text-lg border-2 border-space shadow-[2px_2px_0_#0a0718]" style="background:rgba(255,217,61,.9)">⭐</div>
                            <div class="min-w-0">
                                <div class="text-sm font-black text-cream truncate">{{ $log->activity }}</div>
                                <div class="text-[11px] font-bold text-cream/40">{{ $log->created_at->diffForHumans() }}</div>
                            </div>
                        </div>
                        <span class="sticker px-2.5 py-1 bg-gold text-space text-sm font-black flex-shrink-0">+{{ $log->amount }} XP</span>
                    </div>
                    @endforeach
                </div>
            @endif
        </section>
    </div>

    {{-- RIGHT: top pilots --}}
    <div class="space-y-6">
        <section class="candy-card hard-shadow p-5 sm:p-6 reveal" data-delay="180">
            <h2 class="font-display font-extrabold text-lg text-cream flex items-center gap-2 mb-1">
                <span class="text-xl">🏆</span> TOP PILOTS
            </h2>
            <p class="text-cream/40 text-xs font-bold mb-5">Who's leading the galaxy right now?</p>
            <div class="space-y-2.5">
                @foreach($leaderboard->take(5) as $i => $peer)
                @php
                    $medals = ['🥇','🥈','🥉'];
                    $isYou = $peer->name === $child->name;
                @endphp
                <div class="flex items-center gap-3 rounded-2xl border-2 px-3 py-2.5 transition-all {{ $isYou ? 'border-mint bg-mint/10' : 'border-cream/10 bg-surface/50' }}">
                    <span class="w-7 text-center font-black text-lg">
                        @if($i < 3)<span>{{ $medals[$i] }}</span>@else<span class="text-cream/30 text-xs">#{{ $i + 1 }}</span>@endif
                    </span>
                    <div class="w-9 h-9 rounded-xl grid place-items-center text-sm border-2 border-space shadow-[2px_2px_0_#0a0718] flex-shrink-0" style="background:{{ $isYou ? '#4DFFA2' : 'rgba(255,246,233,.12)' }}">
                        {{ $isYou ? '👤' : strtoupper(substr($peer->name, 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0 text-sm font-black truncate {{ $isYou ? 'text-mint' : 'text-cream/90' }}">
                        {{ $isYou ? 'You 👋' : substr($peer->name, 0, 1) }}{{ str_repeat('•', max(2, strlen($peer->name) - 1)) }}
                    </div>
                    <span class="text-xs font-black text-gold tabular-nums">{{ number_format($peer->xp) }}</span>
                </div>
                @endforeach
            </div>
        </section>

        <section class="relative overflow-hidden candy-card hard-shadow p-5 sm:p-6 reveal" data-delay="220"
                 style="background:linear-gradient(160deg,rgba(90,215,255,.16),rgba(155,123,255,.12))">
            <div class="absolute -right-6 -bottom-8 text-7xl rotate-12 select-none opacity-20 float">🧪</div>
            <div class="museum text-sky mb-2 blink-caret">// DID YOU KNOW //</div>
            <p class="text-cream/80 font-extrabold text-sm leading-relaxed">
                Completing quizzes fires at <span class="text-gold">+XP</span> · finishing a module pops confetti 🎊
                · finishing a whole course unlocks your <span class="text-mint">rank-up</span>!
            </p>
        </section>
    </div>
</div>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('xp-bar');
        if (bar) {
            const progress = Math.min(parseFloat(bar.dataset.progress), 100);
            setTimeout(() => { bar.style.width = progress + '%'; }, 350);
        }
    });
</script>
@endpush