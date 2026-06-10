@extends('layouts.app')

@section('title', $child->name . "'s Dashboard")

@php
    $rankColors = [
        'Explorer'       => ['bg'=>'#F0FDF4','text'=>'#16A34A','border'=>'#86EFAC','emoji'=>'🌱','gradient'=>'from-emerald-500 to-emerald-600'],
        'Innovator'      => ['bg'=>'#EFF6FF','text'=>'#2563EB','border'=>'#93C5FD','emoji'=>'⚡','gradient'=>'from-blue-500 to-blue-600'],
        'Builder'        => ['bg'=>'#FFF7ED','text'=>'#EA580C','border'=>'#FDBA74','emoji'=>'🔨','gradient'=>'from-orange-500 to-orange-600'],
        'Creator'        => ['bg'=>'#F5F3FF','text'=>'#7C3AED','border'=>'#C4B5FD','emoji'=>'🎨','gradient'=>'from-violet-500 to-violet-600'],
        'Master Inventor'=> ['bg'=>'#FFFBEB','text'=>'#D97706','border'=>'#FCD34D','emoji'=>'🚀','gradient'=>'from-amber-500 to-amber-600'],
    ];
    $rc = $rankColors[$child->rank] ?? $rankColors['Explorer'];
    $progress = $child->rank_progress;
@endphp

@section('content')
{{-- Top Bar --}}
<div class="sticky top-0 z-30 bg-white/90 backdrop-blur-xl border-b border-gray-100 px-4 sm:px-6">
    <div class="flex items-center justify-between h-14 max-w-6xl mx-auto">
        <div class="flex items-center gap-2 min-w-0">
            <div class="w-8 h-8 rounded-lg flex items-center justify-center font-black text-xs italic flex-shrink-0" style="background:linear-gradient(135deg,#16A34A,#15803D);color:white">T</div>
            <span class="font-bold text-sm text-ink truncate">{{ $child->name }}'s Space</span>
        </div>
        <div class="flex items-center gap-2">
            @if($isChildAuth ?? false)
                <form method="POST" action="{{ route('child.logout') }}">
                    @csrf
                    <button class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-muted hover:text-ink hover:bg-gray-100 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            @else
                <a href="{{ route('parent.dashboard') }}" class="flex items-center gap-1.5 px-3 py-2 rounded-xl text-xs font-bold text-muted hover:text-ink hover:bg-gray-100 transition-all">
                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Back to Parent
                </a>
            @endif
        </div>
    </div>
</div>

<main class="max-w-6xl mx-auto px-4 sm:px-6 py-6 sm:py-8">

    {{-- Welcome Card --}}
    <div class="relative overflow-hidden rounded-3xl p-6 sm:p-8 mb-6" style="background:linear-gradient(135deg,#F0FDF4,#DCFCE7);border:2px solid #86EFAC">
        <div class="absolute -right-8 -top-8 w-48 h-48 rounded-full bg-emerald-200/30 blur-3xl"></div>
        <div class="absolute -left-8 -bottom-8 w-40 h-40 rounded-full bg-emerald-200/20 blur-3xl"></div>
        <div class="relative z-10 flex flex-col sm:flex-row items-start sm:items-center gap-5">
            <div class="relative">
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-2xl flex items-center justify-center font-black text-4xl sm:text-5xl shadow-md" style="background:white;color:#16A34A;border:3px solid #86EFAC">
                    {{ strtoupper(substr($child->name, 0, 1)) }}
                </div>
                <div class="absolute -top-1 -right-1 w-7 h-7 rounded-full bg-white shadow flex items-center justify-center text-sm border border-gray-100" style="font-size:14px">{{ $rc['emoji'] }}</div>
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap mb-1">
                    <h1 class="font-black text-2xl sm:text-3xl text-ink truncate">Hey {{ explode(' ', $child->name)[0] }}!</h1>
                    <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold" style="background:{{ $rc['bg'] }};color:{{ $rc['text'] }};border:1px solid {{ $rc['border'] }}">
                        {{ $rc['emoji'] }} {{ $child->rank }}
                    </span>
                </div>
                <p class="text-muted/70 text-sm mb-3">Age {{ $child->age ?? 'N/A' }} · {{ ucfirst($child->skill_level) }} level</p>
                <div class="max-w-md">
                    <div class="flex justify-between text-xs font-bold mb-1.5">
                        <span style="color:{{ $rc['text'] }}">{{ number_format($child->xp) }} XP</span>
                        <span class="text-muted/60">{{ number_format($child->xp_to_next_rank) }} XP to next rank</span>
                    </div>
                    <div class="h-3 rounded-full bg-white/70 overflow-hidden shadow-inner">
                        <div class="h-full rounded-full transition-all duration-1000 ease-out relative overflow-hidden" id="xp-bar" data-progress="{{ $progress }}" style="width:0%;background:linear-gradient(90deg,#16A34A,#22C55E)">
                            <div class="absolute inset-0 bg-gradient-to-r from-transparent via-white/30 to-transparent shimmer"></div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="flex-shrink-0 text-center px-4 py-3 rounded-2xl bg-white/70 border border-emerald-200/50">
                <div class="font-black text-3xl sm:text-4xl" style="color:#16A34A">{{ number_format($child->xp) }}</div>
                <div class="text-muted/50 text-[10px] font-bold uppercase tracking-widest">Total XP</div>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6">

            {{-- My Clubs & Courses --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center justify-between mb-6">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#F0FDF4">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                        </div>
                        <h2 class="font-black text-lg text-ink">My Clubs & Courses</h2>
                        <span class="text-xs font-bold bg-gray-100 text-muted px-3 py-1.5 rounded-full">{{ $child->enrollments->count() }} enrolled</span>
                    </div>
                </div>

                @if($child->enrollments->isEmpty())
                    <div class="text-center py-12">
                        <div class="text-5xl mb-4">📚</div>
                        <p class="text-muted font-semibold">No clubs or courses yet!</p>
                        <p class="text-muted/50 text-sm mt-1">Ask your parent to enroll you in something fun 🎯</p>
                    </div>
                @else
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($child->enrollments as $enrollment)
                        @php
                            $clubColors = [
                                'stem-club'      => ['from'=>'#16A34A','to'=>'#15803D','bg'=>'#F0FDF4','text'=>'#16A34A','emoji'=>'🔬'],
                                'brain-club'     => ['from'=>'#2563EB','to'=>'#1D4ED8','bg'=>'#EFF6FF','text'=>'#2563EB','emoji'=>'🧠'],
                                'art-craft-club' => ['from'=>'#EA580C','to'=>'#C2410C','bg'=>'#FFF7ED','text'=>'#EA580C','emoji'=>'🎨'],
                                'leadership-club'=> ['from'=>'#7C3AED','to'=>'#6D28D9','bg'=>'#F5F3FF','text'=>'#7C3AED','emoji'=>'⭐'],
                            ];
                            $cc = $clubColors[$enrollment->course->club->slug ?? ''] ?? ['from'=>'#16A34A','to'=>'#15803D','bg'=>'#F0FDF4','text'=>'#16A34A','emoji'=>'📖'];

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
                           class="group block rounded-2xl border-2 overflow-hidden transition-all duration-300 hover:-translate-y-1 hover:shadow-lg active:scale-[0.98]"
                           style="border-color:{{ $cc['text'] }}20; background:white">
                            <div class="h-2" style="background:linear-gradient(90deg,{{ $cc['from'] }},{{ $cc['to'] }})"></div>
                            <div class="p-5">
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="w-12 h-12 rounded-2xl flex items-center justify-center text-xl font-bold shadow-sm" style="background:{{ $cc['bg'] }}">
                                        {{ $cc['emoji'] }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-bold text-sm text-ink truncate">{{ $enrollment->course->title ?? 'Course' }}</div>
                                        <div class="text-xs text-muted/70">{{ $enrollment->course->club->name ?? 'Club' }}</div>
                                    </div>
                                </div>

                                @if($totalLessons > 0)
                                <div class="flex items-center gap-3 mb-4">
                                    <div class="flex-1 h-2.5 rounded-full bg-gray-100 overflow-hidden">
                                        <div class="h-full rounded-full transition-all duration-700" style="width:{{ $courseProgress }}%;background:linear-gradient(90deg,{{ $cc['from'] }},{{ $cc['to'] }})"></div>
                                    </div>
                                    <span class="text-xs font-bold flex-shrink-0 px-2 py-0.5 rounded-md" style="background:{{ $cc['bg'] }};color:{{ $cc['text'] }}">{{ $completedLessons }}/{{ $totalLessons }}</span>
                                </div>
                                @endif

                                <div class="flex items-center justify-between pt-2 border-t border-gray-50">
                                    <span class="text-xs font-bold px-2.5 py-1 rounded-lg" style="background:{{ $enrollment->status == 'active' ? '#F0FDF4' : '#F9FAFB' }};color:{{ $enrollment->status == 'active' ? '#16A34A' : '#9CA3AF' }}">
                                        {{ ucfirst($enrollment->status) }}
                                    </span>
                                    <span class="inline-flex items-center gap-1 text-xs font-bold" style="color:{{ $cc['text'] }}">
                                        Continue
                                        <svg class="w-3.5 h-3.5 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                                    </span>
                                </div>
                            </div>
                        </a>
                        @endforeach
                    </div>
                @endif
            </div>

            {{-- Recent XP Activity --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#FFFBEB">
                        <svg class="w-5 h-5 text-amber-500" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z"/></svg>
                    </div>
                    <h2 class="font-black text-lg text-ink">Recent XP Activity</h2>
                </div>

                @if($child->xpLogs->isEmpty())
                    <div class="text-center py-10">
                        <div class="text-5xl mb-4">⭐</div>
                        <p class="text-muted font-semibold">No XP earned yet — time to learn!</p>
                    </div>
                @else
                    <div class="space-y-2">
                        @foreach($child->xpLogs as $log)
                        <div class="flex items-center justify-between p-4 rounded-2xl bg-gray-50 hover:bg-gray-100 transition-colors">
                            <div class="flex items-center gap-3">
                                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-base" style="background:#FFFBEB">
                                    ⭐
                                </div>
                                <div>
                                    <div class="text-sm font-bold text-ink">{{ $log->activity }}</div>
                                    <div class="text-xs text-muted">{{ $log->created_at->diffForHumans() }}</div>
                                </div>
                            </div>
                            <span class="font-black text-sm px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600">+{{ $log->amount }} XP</span>
                        </div>
                        @endforeach
                    </div>
                @endif
            </div>
        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Rank Journey --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:{{ $rc['bg'] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $rc['text'] }}"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                    </div>
                    <h2 class="font-black text-lg text-ink">Your Ranks</h2>
                </div>
                <div class="space-y-3">
                    @foreach([
                        ['Explorer', 0, '#16A34A', '🌱', 'Start your journey!'],
                        ['Innovator', 200, '#2563EB', '⚡', 'Getting brighter!'],
                        ['Builder', 500, '#EA580C', '🔨', 'Building skills!'],
                        ['Creator', 1000, '#7C3AED', '🎨', 'Creating magic!'],
                        ['Master Inventor', 2000, '#D97706', '🚀', 'Ultimate rank!'],
                    ] as [$rankName, $threshold, $color, $emoji, $desc])
                    @php $achieved = $child->xp >= $threshold; @endphp
                    <div class="flex items-center gap-3 p-3 rounded-2xl transition-all" style="background:{{ $child->rank === $rankName ? $color . '08' : 'transparent' }}; border:1px solid {{ $child->rank === $rankName ? $color . '20' : 'transparent' }}">
                        <div class="w-11 h-11 rounded-xl flex items-center justify-center text-lg flex-shrink-0 shadow-sm" style="background:{{ $achieved ? $color . '12' : '#F9FAFB' }}; opacity:{{ $achieved ? '1' : '0.4' }}">
                            {{ $emoji }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm" style="color:{{ $achieved ? '#0F172A' : '#9CA3AF' }}">{{ $rankName }}</div>
                            <div class="text-xs" style="color:{{ $achieved ? '#9CA3AF' : '#D1D5DB' }}">{{ number_format($threshold) }} XP — {{ $desc }}</div>
                        </div>
                        @if($child->rank === $rankName)
                            <span class="text-xs font-bold px-2.5 py-1 rounded-lg flex-shrink-0" style="background:{{ $color }};color:white">You</span>
                        @elseif($achieved)
                            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20" style="color:#16A34A"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @endif
                    </div>
                    @endforeach
                </div>
            </div>

            {{-- Leaderboard --}}
            <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8">
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#F0FDF4">
                        <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                    </div>
                    <h2 class="font-black text-lg text-ink">Leaderboard</h2>
                </div>
                <p class="text-xs text-muted/60 mb-5">See how you rank against other learners!</p>
                <div class="space-y-2">
                    @foreach($leaderboard->take(5) as $i => $peer)
                    @php
                        $medals = ['🥇','🥈','🥉'];
                        $isYou = $peer->name === $child->name;
                    @endphp
                    <div class="flex items-center gap-3 p-3 rounded-xl transition-all" style="background:{{ $isYou ? '#F0FDF4' : '#F9FAFB' }}; border:1px solid {{ $isYou ? '#86EFAC' : 'transparent' }}">
                        <span class="w-7 text-center font-black text-sm">
                            @if($i < 3)
                                <span class="text-base">{{ $medals[$i] }}</span>
                            @else
                                <span class="text-muted/40">#{{ $i + 1 }}</span>
                            @endif
                        </span>
                        <div class="w-9 h-9 rounded-xl flex items-center justify-center text-sm font-bold" style="background:{{ $isYou ? '#DCFCE7' : '#F3F4F6' }};color:{{ $isYou ? '#16A34A' : '#6B7280' }}">
                            {{ $isYou ? '👤' : strtoupper(substr($peer->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 text-sm font-bold truncate" style="color:{{ $isYou ? '#16A34A' : '#4B5563' }}">
                            @if($isYou)
                                You 👋
                            @else
                                {{ substr($peer->name, 0, 1) }}{{ str_repeat('•', max(2, strlen($peer->name) - 1)) }}
                            @endif
                        </div>
                        <span class="text-xs font-bold" style="color:#16A34A">{{ number_format($peer->xp) }}</span>
                    </div>
                    @endforeach
                </div>
            </div>

        </div>
    </div>
</main>

<style>
    @keyframes shimmerAnim {
        0% { transform: translateX(-100%); }
        100% { transform: translateX(200%); }
    }
    .shimmer { animation: shimmerAnim 2s infinite; }
</style>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('xp-bar');
        if (bar) {
            const progress = bar.dataset.progress;
            setTimeout(() => { bar.style.width = Math.min(progress, 100) + '%'; }, 300);
        }
    });
</script>
@endpush
