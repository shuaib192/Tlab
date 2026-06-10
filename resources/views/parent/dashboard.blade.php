@extends('layouts.app')
@section('title', 'Parent Dashboard')

@section('content')

{{-- ── TOP NAV ── --}}
<nav class="sticky top-0 z-50 bg-white/80 backdrop-blur-xl border-b border-gray-100" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-8 sm:h-9 w-auto">
            </a>

            <div class="hidden sm:flex items-center gap-3">
                <span class="text-xs font-bold uppercase tracking-widest text-muted/60 bg-surface px-4 py-2 rounded-full border border-gray-200/60">
                    <span class="inline-block w-2 h-2 rounded-full bg-primary mr-2 animate-pulse"></span>
                    Parent Portal
                </span>
                <span class="text-sm font-semibold text-muted flex items-center gap-2">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $user->name }}
                </span>
                <a href="{{ route('parent.children.create') }}"
                   class="inline-flex items-center gap-1.5 bg-primary text-white px-4 py-2 rounded-xl font-bold text-xs hover:bg-primary/90 transition-all shadow-sm hover:shadow-md active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Child
                </a>
                <a href="{{ route('parent.courses.index') }}"
                   class="inline-flex items-center gap-1.5 bg-surface text-ink px-4 py-2 rounded-xl font-bold text-xs border border-gray-200 hover:bg-gray-100 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                    Browse Courses
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="p-2 rounded-xl text-muted hover:text-ink hover:bg-gray-100 transition-all">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
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
        <div x-show="mobileOpen" x-cloak class="sm:hidden pb-4 space-y-2">
            <a href="{{ route('parent.children.create') }}" class="flex items-center gap-3 w-full bg-primary text-white px-4 py-3 rounded-xl font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Add Child
            </a>
            <a href="{{ route('parent.courses.index') }}" class="flex items-center gap-3 w-full bg-surface text-ink px-4 py-3 rounded-xl font-bold text-sm border border-gray-200">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Browse Courses
            </a>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="flex items-center gap-3 w-full border border-gray-200 px-4 py-3 rounded-xl font-bold text-sm text-muted">
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

    {{-- ── HERO WELCOME ── --}}
    <div class="relative overflow-hidden rounded-3xl bg-gradient-to-br from-[#0F172A] via-[#1a2744] to-[#0F172A] p-8 sm:p-12 mb-10">
        <div class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-primary/20 to-accent/20 rounded-full blur-3xl -translate-y-1/2 translate-x-1/4"></div>
        <div class="absolute bottom-0 left-0 w-64 h-64 bg-gradient-to-tr from-violet/20 to-transparent rounded-full blur-3xl translate-y-1/2 -translate-x-1/4"></div>
        <div class="relative z-10 flex flex-col sm:flex-row sm:items-end justify-between gap-6">
            <div>
                <div class="flex items-center gap-2 mb-3">
                    <span class="inline-block w-2 h-2 rounded-full bg-primary animate-pulse"></span>
                    <span class="text-primary/80 text-xs font-bold uppercase tracking-widest">{{ now()->format('l, F j, Y') }}</span>
                </div>
                <h1 class="font-black text-3xl sm:text-4xl lg:text-5xl text-white leading-tight">
                    Welcome back, <span class="text-primary">{{ explode(' ', $user->name)[0] }}</span>
                </h1>
                <p class="text-white/50 font-semibold mt-2 max-w-xl">Track every child's STEM journey in one place — progress, achievements, and upcoming sessions.</p>
            </div>
            <div class="flex gap-3">
                <a href="{{ route('parent.children.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl active:scale-95">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Child
                </a>
                <a href="{{ route('parent.courses.index') }}" class="inline-flex items-center gap-2 bg-white/10 backdrop-blur-sm text-white px-6 py-3 rounded-2xl font-bold text-sm border border-white/10 hover:bg-white/20 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                    Browse Clubs
                </a>
            </div>
        </div>
    </div>

    {{-- ── STATS OVERVIEW ── --}}
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-10">
        @php
            $statCards = [
                ['count' => $children->count(), 'label' => 'Children', 'icon' => 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', 'from' => '#16A34A', 'to' => '#15803D', 'sublabel' => 'Total'],
                ['count' => number_format($totalXp), 'label' => 'Total XP Earned', 'icon' => 'M13 7h8m0 0v8m0-8l-8 8-4-4-6 6', 'from' => '#2563EB', 'to' => '#1D4ED8', 'sublabel' => 'Lifetime'],
                ['count' => $totalCourses, 'label' => 'Course Enrollments', 'icon' => 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', 'from' => '#7C3AED', 'to' => '#6D28D9', 'sublabel' => 'Active'],
                ['count' => $attendanceRate !== null ? $attendanceRate . '%' : '--', 'label' => 'Attendance Rate', 'icon' => 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', 'from' => '#D97706', 'to' => '#B45309', 'sublabel' => '30 Days'],
            ];
        @endphp
        @foreach($statCards as $card)
        <div class="group relative bg-white rounded-2xl border border-gray-100 shadow-sm p-5 sm:p-6 hover:shadow-lg transition-all duration-300 hover:-translate-y-0.5 overflow-hidden">
            <div class="absolute top-0 right-0 w-24 h-24 bg-gradient-to-br from-gray-50 to-transparent rounded-full -translate-y-1/2 translate-x-1/2"></div>
            <div class="relative z-10">
                <div class="flex items-center justify-between mb-3">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center shadow-sm transition-transform group-hover:scale-110" 
                         style="background:linear-gradient(135deg, {{ $card['from'] }}15, {{ $card['to'] }}10)">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $card['from'] }}">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $card['icon'] }}"/>
                        </svg>
                    </div>
                    <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:{{ $card['from'] }}10; color:{{ $card['from'] }}">{{ $card['sublabel'] }}</span>
                </div>
                <div class="font-black text-3xl text-ink mb-0.5">{{ $card['count'] }}</div>
                <div class="text-muted font-semibold text-sm">{{ $card['label'] }}</div>
            </div>
        </div>
        @endforeach
    </div>

    {{-- ── NO CHILDREN STATE ── --}}
    @if($children->isEmpty())
    <div class="relative overflow-hidden bg-white rounded-3xl border border-gray-100 shadow-sm p-12 sm:p-20 text-center">
        <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-primary/5 to-accent/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
        <div class="relative z-10">
            <div class="w-28 h-28 rounded-3xl bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center mx-auto mb-6 shadow-inner border border-primary/10">
                <svg class="w-12 h-12 text-primary/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
            </div>
            <h2 class="font-black text-2xl sm:text-3xl text-ink mb-3">Welcome to Your Family Dashboard</h2>
            <p class="text-muted font-semibold text-sm max-w-md mx-auto mb-8 leading-relaxed">
                Add your first child's profile to start tracking their STEM learning journey. 
                You'll see XP, attendance, courses, and more — all in one place.
            </p>
            <a href="{{ route('parent.children.create') }}" 
               class="inline-flex items-center gap-3 bg-primary text-white px-8 py-4 rounded-2xl font-bold text-base hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5 active:scale-95">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                Add Your First Child
            </a>
        </div>
    </div>

    @else

    {{-- ── UPCOMING SESSIONS ── --}}
    @if($upcomingSessions->isNotEmpty())
    <div class="mb-10">
        <div class="flex items-center justify-between mb-5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="font-black text-lg text-ink">Upcoming Sessions</h2>
                <span class="text-xs font-bold bg-primary/10 text-primary px-3 py-1 rounded-full">{{ $upcomingSessions->count() }} this week</span>
            </div>
        </div>
        <div class="flex gap-4 overflow-x-auto pb-2 -mx-4 px-4 snap-x snap-mandatory scrollbar-thin">
            @foreach($upcomingSessions as $session)
            <div class="flex-shrink-0 w-72 snap-start bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-lg hover:-translate-y-1 transition-all duration-300">
                <div class="flex items-center gap-3 mb-4">
                    <div class="w-11 h-11 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0 shadow-sm"
                         style="background:{{ $session['club_color'] }}15; color:{{ $session['club_color'] }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="font-bold text-sm text-ink truncate">{{ $session['course'] }}</div>
                        <div class="text-xs text-muted flex items-center gap-1">
                            <span class="inline-block w-1.5 h-1.5 rounded-full" style="background:{{ $session['club_color'] }}"></span>
                            {{ $session['club_name'] }}
                        </div>
                    </div>
                </div>
                <div class="flex items-center justify-between text-sm border-t border-gray-50 pt-3">
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
        <div class="flex items-center justify-between mb-6">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber/10 to-coral/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h2 class="font-black text-lg sm:text-xl text-ink">Your Children</h2>
                <span class="text-xs font-bold bg-gray-100 text-muted px-3 py-1.5 rounded-full">{{ $children->count() }} {{ Str::plural('child', $children->count()) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @php
                $rankData = [
                    'Explorer'       => ['color'=>'#16A34A','bg'=>'#F0FDF4','light'=>'#DCFCE7','border'=>'#86EFAC','emoji'=>'🌱','gradient'=>'from-emerald-500 to-emerald-600'],
                    'Innovator'      => ['color'=>'#2563EB','bg'=>'#EFF6FF','light'=>'#DBEAFE','border'=>'#93C5FD','emoji'=>'⚡','gradient'=>'from-blue-500 to-blue-600'],
                    'Builder'        => ['color'=>'#EA580C','bg'=>'#FFF7ED','light'=>'#FFEDD5','border'=>'#FDBA74','emoji'=>'🔨','gradient'=>'from-orange-500 to-orange-600'],
                    'Creator'        => ['color'=>'#7C3AED','bg'=>'#F5F3FF','light'=>'#EDE9FE','border'=>'#C4B5FD','emoji'=>'🎨','gradient'=>'from-violet-500 to-violet-600'],
                    'Master Inventor'=> ['color'=>'#D97706','bg'=>'#FFFBEB','light'=>'#FEF3C7','border'=>'#FCD34D','emoji'=>'🚀','gradient'=>'from-amber-500 to-amber-600'],
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

            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1">
                <div class="h-2 bg-gradient-to-r" style="background:linear-gradient(90deg, {{ $rd['color'] }}, {{ $rd['color'] }}88)"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="relative">
                            <div class="w-16 h-16 rounded-2xl font-black text-2xl flex items-center justify-center shadow-sm transition-transform group-hover:scale-105"
                                 style="background:{{ $rd['bg'] }};color:{{ $rd['color'] }};border:2px solid {{ $rd['border'] }}">
                                {{ strtoupper(substr($child->name, 0, 1)) }}
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-white shadow-sm flex items-center justify-center text-xs border border-gray-100">
                                {{ $rd['emoji'] }}
                            </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-black text-lg text-ink truncate">{{ $child->name }}</div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-muted text-xs font-semibold">Age {{ $child->age ?? 'N/A' }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs font-bold uppercase tracking-wider" style="color:{{ $rd['color'] }}">{{ $child->rank }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 p-4 rounded-xl" style="background:{{ $rd['bg'] }}">
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-ink">{{ number_format($child->xp) }} XP</span>
                            <span class="text-muted/80">{{ $progress }}% to next rank</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-white/60 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 ease-out" 
                                 style="width:{{ $progress }}%;background:linear-gradient(90deg,{{ $rd['color'] }},{{ $rd['color'] }}88)"
                                 x-data x-init="$el.style.width = '0%'; setTimeout(() => $el.style.width = '{{ $progress }}%', 200)">
                            </div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="rounded-xl p-3 text-center border border-gray-100">
                            <div class="font-black text-lg" style="color:{{ $rd['color'] }}">{{ $child->enrollments_count }}</div>
                            <div class="text-muted text-xs font-semibold">Courses</div>
                        </div>
                        <div class="rounded-xl p-3 text-center border border-gray-100">
                            <div class="font-black text-lg text-accent">{{ $attendedCount }}</div>
                            <div class="text-muted text-xs font-semibold">Attended</div>
                        </div>
                        <div class="rounded-xl p-3 text-center border border-gray-100">
                            <div class="font-black text-lg text-amber-600">{{ $child->xp }}</div>
                            <div class="text-muted text-xs font-semibold">XP</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 text-xs text-muted mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $lastActive }}
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('parent.children.switch', $child) }}"
                           class="flex-1 py-3 rounded-xl font-bold text-white text-xs text-center transition-all hover:-translate-y-0.5 shadow-sm hover:shadow-md active:scale-95"
                           style="background:linear-gradient(135deg, {{ $rd['color'] }}, {{ $rd['color'] }}cc)">
                            <span class="flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                                Dashboard
                            </span>
                        </a>
                        <a href="{{ route('parent.children.show', $child) }}"
                           class="px-4 py-3 rounded-xl border border-gray-200 text-muted text-xs font-bold hover:border-gray-300 hover:text-ink transition-all">
                            Profile
                        </a>
                        <a href="{{ route('parent.children.edit', $child) }}"
                           class="px-4 py-3 rounded-xl border border-gray-200 text-muted text-xs font-bold hover:border-gray-300 hover:text-ink transition-all">
                            Edit
                        </a>
                    </div>
                </div>
            </div>
            @endforeach

            <a href="{{ route('parent.children.create') }}"
               class="group bg-white rounded-2xl border-2 border-dashed border-gray-200 hover:border-primary/40 transition-all flex flex-col items-center justify-center p-8 min-h-[300px] hover:shadow-lg hover:-translate-y-1 duration-300">
                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:from-primary/20 group-hover:to-primary/10 transition-all">
                    <svg class="w-7 h-7 text-primary/50 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="font-black text-sm text-muted group-hover:text-primary transition-colors">Add Another Child</div>
                <div class="text-xs text-muted/50 mt-1">Click to create a new profile</div>
            </a>
        </div>
    </div>

    {{-- ── RECENT ACTIVITY ── --}}
    @if($recentActivity->isNotEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
        <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl bg-gradient-to-br from-amber/10 to-primary/10 flex items-center justify-center">
                    <svg class="w-4 h-4 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h2 class="font-black text-lg text-ink">Recent Activity</h2>
            </div>
            <span class="text-xs font-bold text-muted bg-gray-100 px-3 py-1.5 rounded-full">Across all children</span>
        </div>
        <div class="p-2">
            @foreach($recentActivity as $log)
            <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-gray-50 transition-colors">
                <div class="flex items-center gap-3">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0 shadow-sm"
                         style="background:{{ $rankData[$log->child->rank ?? 'Explorer']['bg'] ?? '#F0FDF4' }};color:{{ $rankData[$log->child->rank ?? 'Explorer']['color'] ?? '#16A34A' }}">
                        {{ strtoupper(substr($log->child->name ?? '?', 0, 1)) }}
                    </div>
                    <div>
                        <div class="font-bold text-sm text-ink">{{ $log->activity }}</div>
                        <div class="text-xs text-muted flex items-center gap-1.5 mt-0.5">
                            <span class="font-semibold" style="color:{{ $rankData[$log->child->rank ?? 'Explorer']['color'] ?? '#16A34A' }}">{{ $log->child->name ?? 'Unknown' }}</span>
                            <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                            {{ $log->created_at->diffForHumans() }}
                        </div>
                    </div>
                </div>
                <span class="font-black text-sm px-3 py-1.5 rounded-lg bg-amber-50 text-amber-600">+{{ $log->amount }} XP</span>
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
    .scrollbar-thin::-webkit-scrollbar { height: 6px; }
    .scrollbar-thin::-webkit-scrollbar-track { background: transparent; }
    .scrollbar-thin::-webkit-scrollbar-thumb { background: #D1D5DB; border-radius: 99px; }
    .scrollbar-thin::-webkit-scrollbar-thumb:hover { background: #9CA3AF; }
    [x-cloak] { display: none !important; }
    @keyframes pulse { 50% { opacity: .5; } }
    .animate-pulse { animation: pulse 2s cubic-bezier(0.4, 0, 0.6, 1) infinite; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection
