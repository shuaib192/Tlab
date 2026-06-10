@extends('layouts.app')
@section('title', 'Parent Dashboard')

@section('content')

{{-- ── TOP NAV ── --}}
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">
            <a href="{{ route('home') }}" class="flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-8 sm:h-9 w-auto">
            </a>

            <div class="hidden sm:flex items-center gap-4">
                <span class="text-xs font-bold uppercase tracking-widest text-muted bg-surface px-4 py-2 rounded-full border border-gray-200">
                    Parent Portal
                </span>
                <span class="text-sm font-semibold text-muted">
                    Hello, <strong class="text-ink">{{ $user->name }}</strong>
                </span>
                <a href="{{ route('parent.children.create') }}"
                   class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Child
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-sm font-bold text-muted hover:text-ink border-2 border-gray-200 hover:border-gray-300 px-4 py-2.5 rounded-xl transition-all">
                        Logout
                    </button>
                </form>
            </div>

            <button @click="mobileOpen = !mobileOpen" class="sm:hidden p-2 rounded-xl hover:bg-gray-100">
                <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>

        <div x-show="mobileOpen" x-cloak class="sm:hidden pb-4 space-y-3">
            <a href="{{ route('parent.children.create') }}"
               class="flex items-center gap-3 w-full bg-primary text-white px-5 py-3 rounded-xl font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Add Child
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 w-full border-2 border-gray-200 px-5 py-3 rounded-xl font-bold text-sm text-muted">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                    Logout
                </button>
            </form>
        </div>
    </div>
</nav>

<main class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    {{-- Flash --}}
    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm mb-8 animate-slideDown">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-end justify-between gap-4 mb-10">
        <div>
            <h1 class="font-black text-3xl sm:text-4xl text-ink">Your Family Dashboard</h1>
            <p class="text-muted font-semibold mt-1">Track every child's STEM journey in one place.</p>
        </div>
        <div class="flex items-center gap-2 text-sm text-muted">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            <span>{{ now()->format('l, F j, Y') }}</span>
        </div>
    </div>

    {{-- ── STATS OVERVIEW ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-emerald-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-emerald-600 bg-emerald-50 px-3 py-1 rounded-full">Total</span>
            </div>
            <div class="font-black text-3xl text-ink">{{ $children->count() }}</div>
            <div class="text-muted font-semibold text-sm mt-1">Children</div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-blue-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7h8m0 0v8m0-8l-8 8-4-4-6 6"/></svg>
                </div>
                <span class="text-xs font-bold text-blue-600 bg-blue-50 px-3 py-1 rounded-full">Lifetime</span>
            </div>
            <div class="font-black text-3xl text-ink">{{ number_format($totalXp) }}</div>
            <div class="text-muted font-semibold text-sm mt-1">Total XP Earned</div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-violet-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <span class="text-xs font-bold text-violet-600 bg-violet-50 px-3 py-1 rounded-full">Active</span>
            </div>
            <div class="font-black text-3xl text-ink">{{ $totalCourses }}</div>
            <div class="text-muted font-semibold text-sm mt-1">Course Enrollments</div>
        </div>

        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6 hover:shadow-md transition-shadow">
            <div class="flex items-center justify-between mb-3">
                <div class="w-11 h-11 rounded-xl bg-amber-100 flex items-center justify-center">
                    <svg class="w-5 h-5 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <span class="text-xs font-bold text-amber-600 bg-amber-50 px-3 py-1 rounded-full">30 Days</span>
            </div>
            <div class="font-black text-3xl text-ink">{{ $attendanceRate !== null ? $attendanceRate . '%' : '--' }}</div>
            <div class="text-muted font-semibold text-sm mt-1">Attendance Rate</div>
        </div>
    </div>

    {{-- ── NO CHILDREN STATE ── --}}
    @if($children->isEmpty())
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 sm:p-20 text-center">
        <div class="w-28 h-28 rounded-3xl bg-gradient-to-br from-emerald-50 to-emerald-100 flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-12 h-12 text-emerald-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
        </div>
        <h2 class="font-black text-2xl sm:text-3xl text-ink mb-3">Welcome to Your Family Dashboard</h2>
        <p class="text-muted font-semibold text-sm max-w-md mx-auto mb-8 leading-relaxed">
            Add your first child's profile to start tracking their STEM learning journey. 
            You'll see XP, attendance, courses, and more — all in one place.
        </p>
        <a href="{{ route('parent.children.create') }}" 
           class="inline-flex items-center gap-3 bg-primary text-white px-8 py-4 rounded-2xl font-bold text-base hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Add Your First Child
        </a>
    </div>

    @else

    {{-- ── UPCOMING SESSIONS ── --}}
    @if($upcomingSessions->isNotEmpty())
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-black text-lg sm:text-xl text-ink">Upcoming Sessions</h2>
            <span class="text-xs font-bold text-muted bg-gray-100 px-3 py-1.5 rounded-full">{{ $upcomingSessions->count() }} this week</span>
        </div>
        <div class="flex gap-3 overflow-x-auto pb-2 -mx-4 px-4 snap-x snap-mandatory scrollbar-thin">
            @foreach($upcomingSessions as $session)
            <div class="flex-shrink-0 w-64 snap-start bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-md transition-all">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0"
                         style="background:{{ $session['club_color'] }}15; color:{{ $session['club_color'] }}">
                        {{ strtoupper(substr($session['club_name'] ?? 'C', 0, 1)) }}
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-sm text-ink truncate">{{ $session['course'] }}</div>
                        <div class="text-xs text-muted">{{ $session['club_name'] }}</div>
                    </div>
                </div>
                <div class="flex items-center gap-3 text-sm">
                    <div class="flex items-center gap-1.5 text-muted">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                        <span class="font-semibold">{{ \Carbon\Carbon::parse($session['date'])->format('D, M j') }}</span>
                    </div>
                    <div class="flex items-center gap-1.5 text-muted">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        <span class="font-semibold">{{ \Carbon\Carbon::parse($session['start_time'])->format('g:i A') }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    {{-- ── CHILDREN GRID ── --}}
    <div class="mb-8">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-black text-lg sm:text-xl text-ink">Your Children</h2>
            <span class="text-xs font-bold text-muted bg-gray-100 px-3 py-1.5 rounded-full">{{ $children->count() }} {{ Str::plural('child', $children->count()) }}</span>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-5">
            @php
                $rankData = [
                    'Explorer'       => ['color'=>'#16A34A','bg'=>'#F0FDF4','light'=>'#DCFCE7','emoji'=>'🌱'],
                    'Innovator'      => ['color'=>'#2563EB','bg'=>'#EFF6FF','light'=>'#DBEAFE','emoji'=>'⚡'],
                    'Builder'        => ['color'=>'#EA580C','bg'=>'#FFF7ED','light'=>'#FFEDD5','emoji'=>'🔨'],
                    'Creator'        => ['color'=>'#7C3AED','bg'=>'#F5F3FF','light'=>'#EDE9FE','emoji'=>'🎨'],
                    'Master Inventor'=> ['color'=>'#D97706','bg'=>'#FFFBEB','light'=>'#FEF3C7','emoji'=>'🚀'],
                ];
            @endphp

            @foreach($children as $child)
            @php
                $rd = $rankData[$child->rank] ?? $rankData['Explorer'];
                $progress = $child->rank_progress;
                $latestLog = $child->xpLogs()->latest()->first();
                $lastActive = $latestLog ? $latestLog->created_at->diffForHumans() : 'No activity yet';
                $attendedCount = $child->attendance()->where('status', 'present')->count();
            @endphp

            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-lg transition-all duration-300 overflow-hidden group">
                <div class="h-2" style="background:linear-gradient(90deg, {{ $rd['color'] }}, {{ $rd['color'] }}88)"></div>
                <div class="p-5 sm:p-6">
                    {{-- Header --}}
                    <div class="flex items-center gap-4 mb-5">
                        <div class="w-14 h-14 rounded-2xl font-black text-xl flex items-center justify-center flex-shrink-0 shadow-sm transition-transform group-hover:scale-105"
                             style="background:{{ $rd['bg'] }};color:{{ $rd['color'] }}">
                            {{ strtoupper(substr($child->name, 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-black text-lg text-ink truncate flex items-center gap-2">
                                {{ $child->name }}
                                <span class="text-xs">{{ $rd['emoji'] }}</span>
                            </div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-muted text-xs font-semibold">Age {{ $child->age ?? 'N/A' }}</span>
                                <span class="text-gray-300">·</span>
                                <span class="text-xs font-semibold uppercase tracking-wider" style="color:{{ $rd['color'] }}">{{ $child->rank }}</span>
                            </div>
                        </div>
                    </div>

                    {{-- XP Bar --}}
                    <div class="mb-5">
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-ink">{{ number_format($child->xp) }} XP</span>
                            <span class="text-muted">{{ $progress }}% to next rank</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 ease-out" 
                                 style="width:{{ $progress }}%;background:linear-gradient(90deg,{{ $rd['color'] }},{{ $rd['color'] }}88)"
                                 x-data x-init="$el.style.width = '0%'; setTimeout(() => $el.style.width = '{{ $progress }}%', 200)">
                            </div>
                        </div>
                    </div>

                    {{-- Stats --}}
                    <div class="grid grid-cols-3 gap-2 mb-5">
                        <div class="bg-gray-50 rounded-xl p-3 text-center">
                            <div class="font-black text-lg" style="color:{{ $rd['color'] }}">{{ $child->enrollments_count }}</div>
                            <div class="text-muted text-xs font-semibold">Courses</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 text-center">
                            <div class="font-black text-lg text-accent">{{ $attendedCount }}</div>
                            <div class="text-muted text-xs font-semibold">Attended</div>
                        </div>
                        <div class="bg-gray-50 rounded-xl p-3 text-center">
                            <div class="font-black text-lg text-amber-600">{{ $child->xp }}</div>
                            <div class="text-muted text-xs font-semibold">XP</div>
                        </div>
                    </div>

                    {{-- Last active --}}
                    <div class="flex items-center gap-1.5 text-xs text-muted mb-5 px-1">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $lastActive }}
                    </div>

                    {{-- Actions --}}
                    <div class="flex gap-2">
                        <a href="{{ route('parent.children.switch', $child) }}"
                           class="flex-1 py-3 rounded-xl font-bold text-white text-xs text-center transition-all hover:-translate-y-0.5 shadow-sm hover:shadow-md"
                           style="background:{{ $rd['color'] }}">
                            View Dashboard
                        </a>
                        <a href="{{ route('parent.children.show', $child) }}"
                           class="px-4 py-3 rounded-xl border-2 border-gray-200 text-muted text-xs font-bold hover:border-gray-300 hover:text-ink transition-all">
                            Details
                        </a>
                        <a href="{{ route('parent.children.edit', $child) }}"
                           class="px-4 py-3 rounded-xl border-2 border-gray-200 text-muted text-xs font-bold hover:border-gray-300 hover:text-ink transition-all">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Add Child Card --}}
            <a href="{{ route('parent.children.create') }}"
               class="bg-white rounded-2xl border-2 border-dashed border-gray-200 hover:border-primary/40 transition-all flex flex-col items-center justify-center p-8 min-h-[300px] group">
                <div class="w-16 h-16 rounded-3xl bg-primary/10 flex items-center justify-center mb-4 group-hover:bg-primary/20 group-hover:scale-110 transition-all">
                    <svg class="w-7 h-7 text-primary/50 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="font-black text-sm text-muted group-hover:text-primary transition-colors">Add Another Child</div>
                <div class="text-xs text-muted/50 mt-1">Click to create a new profile</div>
            </a>
        </div>
    </div>

    {{-- ── RECENT ACTIVITY ── --}}
    @if($recentActivity->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-black text-lg sm:text-xl text-ink">Recent Activity</h2>
            <span class="text-xs font-bold text-muted bg-gray-100 px-3 py-1.5 rounded-full">Across all children</span>
        </div>
        <div class="space-y-1">
            @foreach($recentActivity as $log)
            <div class="flex items-center justify-between py-3 px-3 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold flex-shrink-0 bg-amber-50 text-amber-600">
                        {{ strtoupper(substr($log->child->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-ink">{{ $log->activity }}</div>
                        <div class="text-xs text-muted">
                            <span style="color:{{ $rankData[$log->child->rank ?? 'Explorer']['color'] ?? '#16A34A' }}">{{ $log->child->name ?? 'Unknown' }}</span>
                            <span class="mx-1">·</span>
                            {{ $log->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <span class="font-black text-sm text-amber-600">+{{ $log->amount }} XP</span>
            </div>
            @endforeach
        </div>
    </div>
    @endif

    @endif

</main>

<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-slideDown { animation: slideDown 0.3s ease-out; }
    .scrollbar-thin::-webkit-scrollbar { height: 4px; }
    .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 99px; }
    [x-cloak] { display: none !important; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection
