@extends('layouts.app')

@section('title', $child->name . "'s Dashboard")

@section('content')

{{-- Top Nav --}}
<nav class="sticky top-0 z-50 px-8 py-5 flex justify-between items-center glass border-b border-white/5">
    <div class="flex items-center gap-4">
        <div class="w-10 h-10 rounded-xl flex items-center justify-center font-display text-xl font-black italic text-white"
             style="background:linear-gradient(135deg,#4E9966,#2a6e44)">T</div>
        <div>
            <div class="font-display text-lg font-bold">{{ $child->name }}'s Space</div>
            <div class="text-xs text-mint font-bold">TLab Learner Dashboard</div>
        </div>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('parent.dashboard') }}"
           class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass text-cream/60 text-sm font-bold hover:text-cream transition-all">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            Parent Dashboard
        </a>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-8 py-10">

    {{-- Hero: Child Identity --}}
    @php
        $rankColors = [
            'Explorer'       => ['gradient'=>'from-mint/20 to-transparent', 'text'=>'#4E9966', 'border'=>'rgba(78,153,102,0.4)', 'emoji'=>'🌱'],
            'Innovator'      => ['gradient'=>'from-gold/20 to-transparent',  'text'=>'#D4A224', 'border'=>'rgba(212,162,36,0.4)',  'emoji'=>'⚡'],
            'Builder'        => ['gradient'=>'from-terra/20 to-transparent', 'text'=>'#C24B1E', 'border'=>'rgba(194,75,30,0.4)',   'emoji'=>'🔨'],
            'Creator'        => ['gradient'=>'from-violet/20 to-transparent','text'=>'#6B3FA0', 'border'=>'rgba(107,63,160,0.4)',  'emoji'=>'🎨'],
            'Master Inventor'=> ['gradient'=>'from-sky/20 to-transparent',   'text'=>'#2E8BC0', 'border'=>'rgba(46,139,192,0.4)', 'emoji'=>'🚀'],
        ];
        $rc = $rankColors[$child->rank] ?? $rankColors['Explorer'];
        $progress = $child->rank_progress;

        $xpActivities = [
            'Attend Session'        => 10,
            'Complete Challenge'    => 20,
            'Teamwork'              => 10,
            'Project Presentation'  => 15,
        ];
    @endphp

    <div class="rounded-3xl p-8 mb-8 relative overflow-hidden bg-gradient-to-br {{ $rc['gradient'] }}"
         style="border:1px solid {{ $rc['border'] }}">
        {{-- Background decoration --}}
        <div class="absolute -right-10 -top-10 w-64 h-64 rounded-full blur-3xl opacity-20"
             style="background:{{ $rc['text'] }}"></div>

        <div class="flex flex-col md:flex-row items-start md:items-center gap-6 relative z-10">
            {{-- Avatar --}}
            <div class="w-24 h-24 rounded-3xl flex items-center justify-center font-display text-5xl font-black flex-shrink-0"
                 style="background:rgba(0,0,0,0.3); border:2px solid {{ $rc['border'] }}">
                {{ strtoupper(substr($child->name, 0, 1)) }}
            </div>

            {{-- Info --}}
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-1 flex-wrap">
                    <h1 class="font-display text-3xl font-bold">{{ $child->name }}</h1>
                    <span class="rank-badge text-sm" style="background:rgba(0,0,0,0.3); border:1px solid {{ $rc['border'] }}; color:{{ $rc['text'] }}">
                        {{ $rc['emoji'] }} {{ $child->rank }}
                    </span>
                </div>
                <p class="text-cream/50 mb-4">Age {{ $child->age ?? 'N/A' }} • {{ ucfirst($child->skill_level) }} level learner</p>

                {{-- XP Progress --}}
                <div class="max-w-md">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-bold" style="color:{{ $rc['text'] }}">{{ number_format($child->xp) }} XP Total</span>
                        <span class="text-cream/50">{{ $child->xp_to_next_rank }} XP to next rank</span>
                    </div>
                    <div class="xp-bar">
                        <div class="xp-fill" id="xp-main-bar" data-progress="{{ $progress }}" style="width:0%"></div>
                    </div>
                </div>
            </div>

            {{-- XP Stat --}}
            <div class="text-center md:text-right">
                <div class="font-display text-5xl font-black" style="color:{{ $rc['text'] }}">{{ number_format($child->xp) }}</div>
                <div class="text-cream/50 text-sm font-bold uppercase tracking-widest">Total XP</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Left Column: Enrolled Courses + XP Activities --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Enrolled Courses --}}
            <div class="glass rounded-3xl p-6">
                <div class="flex items-center justify-between mb-6">
                    <h2 class="font-display text-xl font-bold">My Clubs & Courses</h2>
                    <span class="text-cream/40 text-sm">{{ $child->enrollments->count() }} enrolled</span>
                </div>

                @if($child->enrollments->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-5xl mb-3">📚</div>
                        <p class="text-cream/50">No courses enrolled yet.</p>
                        <p class="text-cream/30 text-sm mt-1">Go to the parent dashboard to enroll in a club.</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($child->enrollments as $enrollment)
                        @php
                            $clubColor = [
                                'stem-club'      => '#4E9966',
                                'brain-club'     => '#D4A224',
                                'art-craft-club' => '#C24B1E',
                                'leadership-club'=> '#6B3FA0',
                            ][$enrollment->course->club->slug ?? ''] ?? '#4E9966';
                        @endphp
                        <div class="flex items-center gap-4 p-4 rounded-xl bg-white/5 border border-white/5 hover:border-white/10 transition-all">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold"
                                 style="background:{{ $clubColor }}20; color:{{ $clubColor }}">
                                {{ strtoupper(substr($enrollment->course->club->name ?? 'C', 0, 1)) }}
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-sm">{{ $enrollment->course->title ?? 'Course' }}</div>
                                <div class="text-cream/50 text-xs">{{ $enrollment->course->club->name ?? 'Club' }}</div>
                            </div>
                            <span class="px-3 py-1 rounded-full text-xs font-bold"
                                  style="background:{{ $enrollment->status == 'active' ? 'rgba(78,153,102,0.15)' : 'rgba(250,245,232,0.05)' }};
                                         color:{{ $enrollment->status == 'active' ? '#4E9966' : 'rgba(250,245,232,0.5)' }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent XP Activity --}}
            <div class="glass rounded-3xl p-6">
                <h2 class="font-display text-xl font-bold mb-6">Recent XP Activity</h2>

                @if($child->xpLogs->isEmpty())
                    <div class="text-center py-10">
                        <div class="text-4xl mb-3">⭐</div>
                        <p class="text-cream/50">No XP earned yet. Start a session!</p>
                    </div>
                @else
                    <div class="space-y-3">
                        @foreach($child->xpLogs as $log)
                        <div class="flex items-center justify-between p-3 rounded-xl bg-white/5">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-lg bg-gold/10 flex items-center justify-center text-sm">⭐</div>
                                <span class="text-sm font-medium">{{ $log->activity }}</span>
                            </div>
                            <span class="font-display font-bold text-gold text-sm">+{{ $log->amount }} XP</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Right Column: Leaderboard + Rank Map --}}
        <div class="space-y-8">

            {{-- Rank Progression --}}
            <div class="glass rounded-3xl p-6">
                <h2 class="font-display text-xl font-bold mb-6">Rank Journey</h2>
                <div class="space-y-3">
                    @foreach(['Explorer'=>[0,'🌱','#4E9966'], 'Innovator'=>[200,'⚡','#D4A224'], 'Builder'=>[500,'🔨','#C24B1E'], 'Creator'=>[1000,'🎨','#6B3FA0'], 'Master Inventor'=>[2000,'🚀','#2E8BC0']] as $rankName => [$threshold, $emoji, $color])
                    @php $achieved = $child->xp >= $threshold; @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl transition-all {{ $child->rank === $rankName ? 'bg-white/10 border border-white/10' : '' }}">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0"
                             style="background: {{ $achieved ? $color . '20' : 'rgba(250,245,232,0.03)' }}; opacity: {{ $achieved ? '1' : '0.4' }}">
                            {{ $emoji }}
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-sm {{ $achieved ? '' : 'opacity-40' }}">{{ $rankName }}</div>
                            <div class="text-cream/40 text-xs">{{ number_format($threshold) }} XP</div>
                        </div>
                        @if($child->rank === $rankName)
                            <span class="text-xs px-2 py-1 rounded-full font-bold" style="background:{{ $color }}20; color:{{ $color }}">Current</span>
                        @elseif($achieved)
                            <svg class="w-4 h-4 text-mint" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Anonymous Leaderboard --}}
            <div class="glass rounded-3xl p-6">
                <h2 class="font-display text-xl font-bold mb-2">Community Board</h2>
                <p class="text-cream/40 text-xs mb-5">Anonymous weekly XP ranking</p>
                <div class="space-y-2">
                    @foreach($leaderboard->take(5) as $i => $peer)
                    <div class="flex items-center gap-3 p-2 rounded-xl {{ $peer->name === $child->name ? 'bg-mint/10 border border-mint/20' : '' }}">
                        <span class="w-6 text-center font-display font-black text-sm
                            {{ $i === 0 ? 'text-gold' : ($i === 1 ? 'text-cream/60' : ($i === 2 ? 'text-terra' : 'text-cream/30')) }}">
                            #{{ $i + 1 }}
                        </span>
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center text-sm font-bold bg-white/10">
                            {{ strtoupper(substr($peer->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 text-sm font-medium truncate">
                            @if($peer->name === $child->name)
                                {{ $child->name }} <span class="text-mint text-xs">(you)</span>
                            @else
                                {{ substr($peer->name, 0, 1) }}{{ str_repeat('•', max(2, strlen($peer->name)-1)) }}
                            @endif
                        </div>
                        <span class="text-xs font-bold text-gold">{{ number_format($peer->xp) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('xp-main-bar');
        if (bar) {
            const progress = bar.dataset.progress;
            setTimeout(() => { bar.style.width = progress + '%'; }, 300);
        }
    });
</script>
@endpush
