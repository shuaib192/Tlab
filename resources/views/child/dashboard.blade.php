@extends('layouts.app')

@section('title', $child->name . "'s Dashboard")

@section('content')

{{-- Top Nav --}}
<nav class="sticky top-0 z-50 px-4 sm:px-8 py-4 flex justify-between items-center" style="background:rgba(15,22,16,0.9); backdrop-filter:blur(20px); border-bottom:1px solid rgba(250,245,232,0.06)">
    <div class="flex items-center gap-3">
        <div class="w-9 h-9 rounded-xl flex items-center justify-center font-black text-base italic text-white shadow-lg"
             style="background:linear-gradient(135deg,#4E9966,#2a6e44)">T</div>
        <div class="hidden sm:block">
            <div class="font-bold text-sm text-cream">{{ $child->name }}'s Space</div>
            <div class="text-[10px] uppercase tracking-widest font-bold" style="color:#4E9966">Learner Dashboard</div>
        </div>
    </div>
    <div class="flex items-center gap-3">
        @if($isChildAuth ?? false)
            <form method="POST" action="{{ route('child.logout') }}">
                @csrf
                <button type="submit"
                   class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition-all"
                   style="background:rgba(250,245,232,0.05); color:rgba(250,245,232,0.5); border:1px solid rgba(250,245,232,0.08)"
                   onmouseover="this.style.background='rgba(250,245,232,0.1)';this.style.color='rgba(250,245,232,0.8)'"
                   onmouseout="this.style.background='rgba(250,245,232,0.05)';this.style.color='rgba(250,245,232,0.5)'">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        @else
            <a href="{{ route('parent.dashboard') }}"
               class="flex items-center gap-2 px-4 py-2.5 rounded-xl font-bold text-xs transition-all"
               style="background:rgba(250,245,232,0.05); color:rgba(250,245,232,0.5); border:1px solid rgba(250,245,232,0.08)"
               onmouseover="this.style.background='rgba(250,245,232,0.1)';this.style.color='rgba(250,245,232,0.8)'"
               onmouseout="this.style.background='rgba(250,245,232,0.05)';this.style.color='rgba(250,245,232,0.5)'">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Parent Dashboard
            </a>
        @endif
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-8 py-8" style="background:#0F1612">

    @php
        $rankColors = [
            'Explorer'       => ['bg'=>'rgba(78,153,102,0.12)', 'text'=>'#4E9966', 'border'=>'rgba(78,153,102,0.3)', 'glow'=>'rgba(78,153,102,0.15)', 'emoji'=>'🌱', 'gradient'=>'from-[#4E9966] to-[#2a6e44]'],
            'Innovator'      => ['bg'=>'rgba(212,162,36,0.12)',  'text'=>'#D4A224', 'border'=>'rgba(212,162,36,0.3)',  'glow'=>'rgba(212,162,36,0.15)',  'emoji'=>'⚡', 'gradient'=>'from-[#D4A224] to-[#b8921e]'],
            'Builder'        => ['bg'=>'rgba(194,75,30,0.12)',   'text'=>'#C24B1E', 'border'=>'rgba(194,75,30,0.3)',   'glow'=>'rgba(194,75,30,0.15)',   'emoji'=>'🔨', 'gradient'=>'from-[#C24B1E] to-[#a33d19]'],
            'Creator'        => ['bg'=>'rgba(107,63,160,0.12)',  'text'=>'#6B3FA0', 'border'=>'rgba(107,63,160,0.3)',  'glow'=>'rgba(107,63,160,0.15)',  'emoji'=>'🎨', 'gradient'=>'from-[#6B3FA0] to-[#563586]'],
            'Master Inventor'=> ['bg'=>'rgba(46,139,192,0.12)', 'text'=>'#2E8BC0', 'border'=>'rgba(46,139,192,0.3)', 'glow'=>'rgba(46,139,192,0.15)', 'emoji'=>'🚀', 'gradient'=>'from-[#2E8BC0] to-[#2473a0]'],
        ];
        $rc = $rankColors[$child->rank] ?? $rankColors['Explorer'];
        $progress = $child->rank_progress;
    @endphp

    {{-- ── HERO ── --}}
    <div class="relative overflow-hidden rounded-3xl mb-8 p-8 sm:p-10"
         style="background:linear-gradient(135deg, #141A16 0%, #1a221d 100%); border:1px solid {{ $rc['border'] }}">
        <div class="absolute -right-16 -top-16 w-80 h-80 rounded-full blur-3xl" style="background:{{ $rc['glow'] }}"></div>
        <div class="absolute -left-16 -bottom-16 w-64 h-64 rounded-full blur-3xl" style="background:{{ $rc['glow'] }}"></div>
        
        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-6">
            <div class="relative">
                <div class="w-24 h-24 rounded-3xl flex items-center justify-center font-black text-5xl shadow-xl"
                     style="background:{{ $rc['bg'] }}; border:2px solid {{ $rc['border'] }}; color:{{ $rc['text'] }}">
                    {{ strtoupper(substr($child->name, 0, 1)) }}
                </div>
                <div class="absolute -top-2 -right-2 w-8 h-8 rounded-full flex items-center justify-center text-base shadow-lg"
                     style="background:{{ $rc['text'] }}20; border:2px solid {{ $rc['border'] }}">
                    {{ $rc['emoji'] }}
                </div>
            </div>
            <div class="flex-1">
                <div class="flex items-center gap-3 mb-1 flex-wrap">
                    <h1 class="font-black text-3xl sm:text-4xl text-cream">{{ $child->name }}</h1>
                    <span class="inline-flex items-center gap-1.5 px-4 py-1.5 rounded-full text-sm font-bold"
                          style="background:{{ $rc['bg'] }}; border:1px solid {{ $rc['border'] }}; color:{{ $rc['text'] }}">
                        {{ $rc['emoji'] }} {{ $child->rank }}
                    </span>
                </div>
                <p class="text-cream/40 text-sm mb-4">Age {{ $child->age ?? 'N/A' }} · {{ ucfirst($child->skill_level) }} level learner</p>
                <div class="max-w-lg">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="font-bold" style="color:{{ $rc['text'] }}">{{ number_format($child->xp) }} XP Total</span>
                        <span class="text-cream/40">{{ $child->xp_to_next_rank }} XP to next rank</span>
                    </div>
                    <div class="h-3 rounded-full overflow-hidden" style="background:rgba(250,245,232,0.06)">
                        <div class="h-full rounded-full transition-all duration-1000 ease-out relative overflow-hidden"
                             id="xp-main-bar" data-progress="{{ $progress }}"
                             style="width:0%; background:linear-gradient(90deg, {{ $rc['text'] }}, {{ $rc['text'] }}88)">
                            <div class="absolute inset-0" style="background:linear-gradient(90deg, transparent, rgba(255,255,255,0.15), transparent); animation:shimmer 2s infinite"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center sm:text-right flex-shrink-0">
                <div class="font-black text-5xl sm:text-6xl" style="color:{{ $rc['text'] }}">{{ number_format($child->xp) }}</div>
                <div class="text-cream/30 text-xs font-bold uppercase tracking-widest mt-1">Total XP</div>
            </div>
        </div>
    </div>

    {{-- ── MAIN GRID ── --}}
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- ── LEFT: Courses + XP ── --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Enrolled Courses --}}
            <div class="rounded-3xl p-6 sm:p-8" style="background:#141A16; border:1px solid rgba(250,245,232,0.06)">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(78,153,102,0.12)">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#4E9966"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h2 class="font-bold text-lg text-cream">My Clubs & Courses</h2>
                    </div>
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full" style="background:rgba(78,153,102,0.1); color:#4E9966">{{ $child->enrollments->count() }} enrolled</span>
                </div>

                @if($child->enrollments->isEmpty())
                    <div class="text-center py-16">
                        <div class="text-6xl mb-4">📚</div>
                        <p class="text-cream/50 font-semibold">No courses enrolled yet.</p>
                        <p class="text-cream/30 text-sm mt-1">Ask a parent to enroll you in a club!</p>
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

                            $totalLessons = $enrollment->course->modules->sum(fn($m) => $m->lessons->count());
                            $completedLessonIds = $completedAssessmentIds ?? [];
                            $completedLessons = 0;
                            foreach ($enrollment->course->modules as $mod) {
                                foreach ($mod->lessons as $lsn) {
                                    if ($lsn->assessment && in_array($lsn->assessment->id, $completedLessonIds)) {
                                        $completedLessons++;
                                    }
                                }
                            }
                            $courseProgress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;
                        @endphp
                        <a href="{{ route('child.course', $enrollment->id) }}"
                           class="flex items-center gap-4 p-5 rounded-2xl transition-all group"
                           style="background:rgba(250,245,232,0.03); border:1px solid rgba(250,245,232,0.06)"
                           onmouseover="this.style.background='rgba(250,245,232,0.06)'; this.style.borderColor='{{ $clubColor }}40'"
                           onmouseout="this.style.background='rgba(250,245,232,0.03)'; this.style.borderColor='rgba(250,245,232,0.06)'">
                            <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-lg font-bold flex-shrink-0 shadow-sm"
                                 style="background:{{ $clubColor }}15; color:{{ $clubColor }}">
                                {{ strtoupper(substr($enrollment->course->club->name ?? 'C', 0, 1)) }}
                            </div>
                            <div class="flex-1 min-w-0">
                                <div class="font-bold text-sm text-cream group-hover:opacity-80 transition-opacity">{{ $enrollment->course->title ?? 'Course' }}</div>
                                <div class="text-cream/40 text-xs mt-0.5">{{ $enrollment->course->club->name ?? 'Club' }}</div>
                                @if($totalLessons > 0)
                                <div class="flex items-center gap-3 mt-3">
                                    <div class="flex-1 max-w-[160px] h-2 rounded-full" style="background:rgba(250,245,232,0.08)">
                                        <div class="h-full rounded-full transition-all duration-700"
                                             style="width:{{ $courseProgress }}%; background:linear-gradient(90deg, {{ $clubColor }}, {{ $clubColor }}88)"></div>
                                    </div>
                                    <span class="text-xs font-bold" style="color:{{ $clubColor }}">{{ $completedLessons }}/{{ $totalLessons }}</span>
                                </div>
                                @endif
                            </div>
                            <span class="px-3 py-1.5 rounded-full text-xs font-bold flex-shrink-0"
                                  style="background:{{ $enrollment->status == 'active' ? 'rgba(78,153,102,0.12)' : 'rgba(250,245,232,0.04)' }};
                                         color:{{ $enrollment->status == 'active' ? '#4E9966' : 'rgba(250,245,232,0.4)' }}">
                                {{ ucfirst($enrollment->status) }}
                            </span>
                            <svg class="w-5 h-5 flex-shrink-0 transition-all group-hover:translate-x-1" style="color:rgba(250,245,232,0.15)" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent XP Activity --}}
            <div class="rounded-3xl p-6 sm:p-8" style="background:#141A16; border:1px solid rgba(250,245,232,0.06)">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(212,162,36,0.12)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#D4A224"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <h2 class="font-bold text-lg text-cream">Recent XP Activity</h2>
                </div>

                @if($child->xpLogs->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">⭐</div>
                        <p class="text-cream/50 font-semibold">No XP earned yet. Start a lesson!</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($child->xpLogs as $log)
                        <div class="flex items-center justify-between p-4 rounded-xl transition-all"
                             style="background:rgba(250,245,232,0.03)"
                             onmouseover="this.style.background='rgba(250,245,232,0.06)'"
                             onmouseout="this.style.background='rgba(250,245,232,0.03)'">
                            <div class="flex items-center gap-3">
                                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm" style="background:rgba(212,162,36,0.1)">
                                    <span style="color:#D4A224">⭐</span>
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-cream">{{ $log->activity }}</div>
                                    <div class="text-xs" style="color:rgba(250,245,232,0.35)">{{ $log->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <span class="font-black text-sm px-3 py-1.5 rounded-lg" style="background:rgba(212,162,36,0.1); color:#D4A224">+{{ $log->amount }} XP</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- ── RIGHT: Leaderboard + Ranks ── --}}
        <div class="space-y-8">

            {{-- Rank Journey --}}
            <div class="rounded-3xl p-6 sm:p-8" style="background:#141A16; border:1px solid rgba(250,245,232,0.06)">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:{{ $rc['bg'] }}">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $rc['text'] }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h2 class="font-bold text-lg text-cream">Rank Journey</h2>
                </div>
                <div class="space-y-2">
                    @foreach([
                        ['Explorer', 0, '#4E9966', '🌱'],
                        ['Innovator', 200, '#D4A224', '⚡'],
                        ['Builder', 500, '#C24B1E', '🔨'],
                        ['Creator', 1000, '#6B3FA0', '🎨'],
                        ['Master Inventor', 2000, '#2E8BC0', '🚀'],
                    ] as [$rankName, $threshold, $color, $emoji])
                    @php $achieved = $child->xp >= $threshold; @endphp
                    <div class="flex items-center gap-3 p-3.5 rounded-2xl transition-all"
                         style="background:{{ $child->rank === $rankName ? $color . '10' : 'transparent' }}; border:1px solid {{ $child->rank === $rankName ? $color . '25' : 'transparent' }}">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center text-lg flex-shrink-0"
                             style="background:{{ $achieved ? $color . '15' : 'rgba(250,245,232,0.02)' }}; opacity:{{ $achieved ? '1' : '0.3' }}">
                            {{ $emoji }}
                        </div>
                        <div class="flex-1">
                            <div class="font-bold text-sm" style="color:{{ $achieved ? '#FAF5E8' : 'rgba(250,245,232,0.35)' }}">{{ $rankName }}</div>
                            <div style="color:rgba(250,245,232,0.3)" class="text-xs">{{ number_format($threshold) }} XP</div>
                        </div>
                        @if($child->rank === $rankName)
                            <span class="text-xs font-bold px-3 py-1.5 rounded-full" style="background:{{ $color }}15; color:{{ $color }}">Current</span>
                        @elseif($achieved)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20" style="color:#4E9966"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Leaderboard --}}
            <div class="rounded-3xl p-6 sm:p-8" style="background:#141A16; border:1px solid rgba(250,245,232,0.06)">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center" style="background:rgba(212,162,36,0.12)">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:#D4A224"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h2 class="font-bold text-lg text-cream">Community Board</h2>
                </div>
                <p style="color:rgba(250,245,232,0.3)" class="text-xs mb-5">Anonymous XP ranking</p>
                <div class="space-y-2">
                    @foreach($leaderboard->take(5) as $i => $peer)
                    <div class="flex items-center gap-3 p-3 rounded-xl transition-all"
                         style="background:{{ $peer->name === $child->name ? 'rgba(78,153,102,0.08)' : 'rgba(250,245,232,0.02)' }}; border:1px solid {{ $peer->name === $child->name ? 'rgba(78,153,102,0.2)' : 'transparent' }}">
                        <span class="w-6 text-center font-black text-sm"
                              style="color:{{ $i === 0 ? '#D4A224' : ($i === 1 ? 'rgba(250,245,232,0.5)' : ($i === 2 ? '#C24B1E' : 'rgba(250,245,232,0.2)')) }}">
                            #{{ $i + 1 }}
                        </span>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold"
                             style="background:rgba(250,245,232,0.06); color:rgba(250,245,232,0.6)">
                            {{ strtoupper(substr($peer->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 text-sm font-medium truncate" style="color:rgba(250,245,232,0.7)">
                            @if($peer->name === $child->name)
                                {{ $child->name }} <span style="color:#4E9966" class="text-xs">(you)</span>
                            @else
                                {{ substr($peer->name, 0, 1) }}{{ str_repeat('•', max(2, strlen($peer->name)-1)) }}
                            @endif
                        </div>
                        <span class="text-xs font-bold" style="color:#D4A224">{{ number_format($peer->xp) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    @keyframes shimmer {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }
</style>

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
