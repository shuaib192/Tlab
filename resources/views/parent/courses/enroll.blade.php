@extends('layouts.parent')
@section('title', 'Enroll in ' . $course->title)

@section('parent-content')
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">
            <a href="{{ route('home') }}" class="flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-8 sm:h-9 w-auto">
            </a>
            <div class="hidden sm:flex items-center gap-4">
                <span class="text-xs font-bold uppercase tracking-widest text-muted bg-surface px-4 py-2 rounded-full border border-gray-200">
                    Enroll
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

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    @if(session('error'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 font-bold text-sm mb-8 animate-slideDown">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    @php
        $clubThemes = [
            'green'  => ['accent' => '#16A34A', 'light' => '#F0FDF4', 'border' => '#BBF7D0'],
            'blue'   => ['accent' => '#2563EB', 'light' => '#EFF6FF', 'border' => '#BFDBFE'],
            'orange' => ['accent' => '#EA580C', 'light' => '#FFF7ED', 'border' => '#FED7AA'],
            'violet' => ['accent' => '#7C3AED', 'light' => '#F5F3FF', 'border' => '#DDD6FE'],
        ];
        $theme = $clubThemes[$course->club->color_theme ?? 'green'] ?? $clubThemes['green'];
    @endphp

    {{-- Back --}}
    <a href="{{ route('parent.courses.show', $course->club) }}"
       class="inline-flex items-center gap-2 text-muted hover:text-ink font-bold text-sm mb-8 transition-colors group">
        <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        Back to {{ $course->club->name }}
    </a>

    {{-- Course Summary --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 mb-8 reveal">
        <div class="flex items-center gap-4 mb-5">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0" style="background:{{ $theme['light'] }};color:{{ $theme['accent'] }}">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
            </div>
            <div>
                <span class="section-tag" style="color:{{ $theme['accent'] }}">{{ $course->club->name }}</span>
                <h1 class="font-black text-2xl sm:text-3xl text-ink mt-0.5">{{ $course->title }}</h1>
            </div>
        </div>

        @if($course->description)
            <p class="text-muted font-semibold text-sm leading-relaxed">{{ $course->description }}</p>
        @endif

        <div class="flex flex-wrap items-center gap-3 mt-5">
            @if($course->level)
                <span class="chip" style="background:{{ $theme['light'] }};color:{{ $theme['accent'] }}">{{ $course->level }}</span>
            @endif
            @if($course->grade_level)
                <span class="chip bg-gray-100 text-muted">Grade {{ $course->grade_level }}</span>
            @endif
            @if($course->teacher)
                <span class="chip bg-gray-100 text-muted">
                    <svg class="w-3.5 h-3.5 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    {{ $course->teacher->name }}
                </span>
            @endif
        </div>
    </div>

    {{-- Enroll Form --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 reveal">
        @if($children->isEmpty())
            <div class="text-center py-10">
                <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-amber-50 to-amber-100 flex items-center justify-center mx-auto mb-5 shadow-inner">
                    <svg class="w-10 h-10 text-amber-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h2 class="font-black text-xl text-ink mb-2">No Children Added Yet</h2>
                <p class="text-muted font-semibold text-sm max-w-sm mx-auto mb-6">Add a child profile first, then come back to enroll them in this course.</p>
                <a href="{{ route('parent.children.create') }}"
                   class="inline-flex items-center gap-3 bg-primary text-white px-8 py-4 rounded-2xl font-bold text-base hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add a Child Profile
                </a>
            </div>
        @else
            <div class="flex items-center gap-3 mb-6">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                </div>
                <h2 class="font-black text-xl text-ink">Select a Child to Enroll</h2>
            </div>

            <form method="POST" action="{{ route('parent.courses.enroll.submit', $course) }}">
                @csrf

                <div class="space-y-3 mb-8">
                    @foreach($children as $child)
                        @php
                            $isEnrolled = in_array($child->id, $enrolledChildIds);
                            $disabled = $isEnrolled ? 'disabled' : '';
                        @endphp
                        <label class="block cursor-pointer">
                            <input type="radio" name="child_profile_id" value="{{ $child->id }}"
                                   class="sr-only peer" {{ $isEnrolled ? 'disabled' : '' }} {{ old('child_profile_id') == $child->id ? 'checked' : '' }}>
                            <div class="flex items-center gap-4 px-5 py-4 rounded-2xl border-2 transition-all duration-200
                                        peer-checked:border-primary peer-checked:bg-primary/5
                                        hover:border-gray-300
                                        {{ $isEnrolled ? 'opacity-50 cursor-not-allowed border-gray-100 bg-gray-50' : 'border-gray-200 bg-white' }}">
                                <div class="w-12 h-12 rounded-xl font-black text-lg flex items-center justify-center flex-shrink-0"
                                     style="background:{{ $theme['light'] }};color:{{ $theme['accent'] }}">
                                    {{ strtoupper(substr($child->name, 0, 1)) }}
                                </div>
                                <div class="flex-1 min-w-0">
                                    <div class="font-bold text-ink">{{ $child->name }}</div>
                                    <div class="text-xs text-muted mt-0.5">
                                        Age {{ $child->age ?? 'N/A' }}
                                        @if($child->skill_level)
                                            <span class="mx-1.5">·</span>
                                            {{ ucfirst($child->skill_level) }}
                                        @endif
                                    </div>
                                </div>
                                @if($isEnrolled)
                                    <span class="chip bg-emerald-100 text-emerald-700 text-xs whitespace-nowrap">
                                        <svg class="w-3 h-3 inline mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                        Already Enrolled
                                    </span>
                                @else
                                    <div class="w-5 h-5 rounded-full border-2 transition-all peer-checked:border-primary peer-checked:bg-primary"
                                         style="border-color:{{ $theme['accent'] }}33">
                                        <div class="w-full h-full rounded-full scale-0 peer-checked:scale-100 transition-transform bg-primary"></div>
                                    </div>
                                @endif
                            </div>
                        </label>
                    @endforeach
                </div>

                @error('child_profile_id')
                    <p class="text-red-600 text-sm font-bold mb-4">{{ $message }}</p>
                @enderror

                <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-5 border border-primary/20 mb-6">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-ink">What happens next?</p>
                            <ul class="text-sm text-muted mt-2 space-y-1.5">
                                <li class="flex items-center gap-2">· Your child will be enrolled with <strong>active</strong> status</li>
                                <li class="flex items-center gap-2">· Payment status will be set to <strong>pending</strong></li>
                                <li class="flex items-center gap-2">· You can manage enrollment from your dashboard</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <button type="submit"
                        class="w-full py-4 rounded-2xl font-bold text-white text-base transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg hover:shadow-xl flex items-center justify-center gap-3"
                        style="background:{{ $theme['accent'] }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Enroll in {{ $course->title }}
                </button>
            </form>
        @endif
    </div>
</main>

<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-slideDown { animation: slideDown 0.3s ease-out; }
    [x-cloak] { display: none !important; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection
