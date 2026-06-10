@extends('layouts.parent')
@section('title', 'Course Catalog')

@section('parent-content')
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">
            <a href="{{ route('home') }}" class="flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-8 sm:h-9 w-auto">
            </a>
            <div class="hidden sm:flex items-center gap-4">
                <span class="text-xs font-bold uppercase tracking-widest text-muted bg-surface px-4 py-2 rounded-full border border-gray-200">
                    Course Catalog
                </span>
                <span class="text-sm font-semibold text-muted">
                    Hello, <strong class="text-ink">{{ auth()->user()->name }}</strong>
                </span>
                <a href="{{ route('parent.dashboard') }}"
                   class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
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
            <a href="{{ route('parent.dashboard') }}"
               class="flex items-center gap-3 w-full bg-primary text-white px-5 py-3 rounded-xl font-bold text-sm">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
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

    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm mb-8 animate-slideDown">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    <div class="text-center mb-12 reveal">
        <span class="section-tag text-primary">Course Catalog</span>
        <h1 class="font-black text-3xl sm:text-4xl text-ink mt-3">Explore Our Clubs & Courses</h1>
        <p class="text-muted font-semibold text-sm sm:text-base mt-2 max-w-xl mx-auto">Choose a club below to browse its courses and enroll your child in their next adventure.</p>
    </div>

    @php
        $clubThemes = [
            'green'  => ['accent' => '#16A34A', 'light' => '#F0FDF4', 'border' => '#BBF7D0', 'gradient' => 'from-emerald-500 to-emerald-600'],
            'blue'   => ['accent' => '#2563EB', 'light' => '#EFF6FF', 'border' => '#BFDBFE', 'gradient' => 'from-blue-500 to-blue-600'],
            'orange' => ['accent' => '#EA580C', 'light' => '#FFF7ED', 'border' => '#FED7AA', 'gradient' => 'from-orange-500 to-orange-600'],
            'violet' => ['accent' => '#7C3AED', 'light' => '#F5F3FF', 'border' => '#DDD6FE', 'gradient' => 'from-violet-500 to-violet-600'],
        ];
    @endphp

    @if($clubs->isEmpty())
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 sm:p-20 text-center">
            <div class="w-28 h-28 rounded-3xl bg-gradient-to-br from-gray-50 to-gray-100 flex items-center justify-center mx-auto mb-6 shadow-inner">
                <svg class="w-12 h-12 text-gray-300" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <h2 class="font-black text-2xl text-ink mb-3">No Clubs Available</h2>
            <p class="text-muted font-semibold text-sm max-w-md mx-auto">Clubs and courses are being added. Check back soon to explore our offerings.</p>
        </div>
    @else
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 sm:gap-8">
            @foreach($clubs as $club)
                @php
                    $theme = $clubThemes[$club->color_theme] ?? $clubThemes['green'];
                    $courseCount = $club->courses->count();
                @endphp
                <div class="group bg-white rounded-3xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden reveal">
                    <div class="h-2" style="background:linear-gradient(90deg, {{ $theme['accent'] }}, {{ $theme['accent'] }}88)"></div>
                    <div class="p-6 sm:p-8">
                        <div class="flex items-start gap-5 mb-6">
                            <div class="w-16 h-16 rounded-2xl flex items-center justify-center flex-shrink-0 shadow-sm" style="background:{{ $theme['light'] }};color:{{ $theme['accent'] }}">
                                <span class="font-black text-2xl">{{ strtoupper(substr($club->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h2 class="font-black text-xl sm:text-2xl text-ink group-hover:text-primary transition-colors">{{ $club->name }}</h2>
                                <p class="text-muted text-sm font-semibold mt-1 line-clamp-2">{{ $club->description }}</p>
                            </div>
                        </div>

                        <div class="flex items-center gap-3 mb-6">
                            <span class="chip" style="background:{{ $theme['light'] }};color:{{ $theme['accent'] }}">
                                <svg class="w-3.5 h-3.5 mr-1.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                                {{ $courseCount }} {{ Str::plural('Course', $courseCount) }}
                            </span>
                            @if($club->icon)
                                <span class="chip bg-gray-100 text-muted">{{ $club->icon }}</span>
                            @endif
                        </div>

                        @if($courseCount > 0)
                            <div class="space-y-3 mb-6">
                                @foreach($club->courses->take(3) as $course)
                                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl transition-colors" style="background:{{ $theme['light'] }}50">
                                        <div class="w-8 h-8 rounded-lg flex items-center justify-center flex-shrink-0" style="background:{{ $theme['light'] }};color:{{ $theme['accent'] }}">
                                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                                        </div>
                                        <span class="font-bold text-sm text-ink flex-1 truncate">{{ $course->title }}</span>
                                        <span class="text-xs font-semibold text-muted">{{ $course->level ?? 'All levels' }}</span>
                                    </div>
                                @endforeach
                                @if($courseCount > 3)
                                    <div class="text-center pt-1">
                                        <span class="text-xs font-bold text-muted">+{{ $courseCount - 3 }} more courses</span>
                                    </div>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-6 mb-4 bg-gray-50 rounded-2xl">
                                <p class="text-sm font-semibold text-muted">No courses available yet</p>
                            </div>
                        @endif

                        <a href="{{ route('parent.courses.show', $club) }}"
                           class="flex items-center justify-center gap-3 w-full py-3.5 rounded-2xl font-bold text-sm transition-all hover:-translate-y-0.5 shadow-sm hover:shadow-md"
                           style="background:{{ $theme['accent'] }};color:#fff">
                            Browse Courses
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                </div>
            @endforeach
        </div>
    @endif
</main>

<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-slideDown { animation: slideDown 0.3s ease-out; }
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
    [x-cloak] { display: none !important; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection
