@extends('layouts.parent')
@section('title', 'Course Catalog')

@section('parent-content')
@include('parent.partials.flow-nav', ['label' => 'Find Course'])

<main class="flow-body min-h-screen px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto">

        @if(session('success'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-xl border-2 border-[#1B1B1E] bg-[#E9F7EF] font-bold text-sm mb-8" style="box-shadow:5px 5px 0 rgba(27,27,30,.12)">
                <svg class="w-5 h-5 text-[#16A34A] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        <div class="mb-12 text-center">
            <div class="inline-flex items-center gap-2 px-4 py-1.5 rounded-full border-2 border-[#1B1B1E] bg-white mb-5" style="box-shadow:4px 4px 0 rgba(27,27,30,.12)">
                <span class="w-2 h-2 rounded-full bg-[#16A34A]"></span>
                <span class="text-xs font-black uppercase tracking-widest">TLab Club Catalogue</span>
            </div>
            <h1 class="font-black text-3xl sm:text-5xl tracking-tight" style="color:#1B1B1E">Pick a Club,</h1>
            <h1 class="font-black text-3xl sm:text-5xl tracking-tight text-[#16A34A]">Start an Adventure.</h1>
            <p class="mt-3 font-semibold text-sm sm:text-base max-w-xl mx-auto" style="color:#1B1B1E99">
                Browse the clubs below, then choose a course and enrol your child in seconds.
            </p>
        </div>

        @php
            $clubThemes = [
                'green'  => '#16A34A',
                'blue'   => '#2563EB',
                'orange' => '#EA580C',
                'violet' => '#7C3AED',
            ];
        @endphp

        @if($clubs->isEmpty())
            <div class="paper-card p-12 sm:p-20 text-center">
                <div class="w-20 h-20 mx-auto mb-6 border-2 border-[#1B1B1E] rounded-2xl grid place-items-center bg-white" style="box-shadow:5px 5px 0 rgba(27,27,30,.12)">
                    <svg class="w-9 h-9 text-[#1B1B1E]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h2 class="font-black text-2xl mb-3" style="color:#1B1B1E">No Clubs Just Yet</h2>
                <p class="font-semibold text-sm max-w-md mx-auto" style="color:#1B1B1E99">Clubs are being added. Check back soon to explore.</p>
            </div>
        @else
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-7">
                @foreach($clubs as $club)
                    @php
                        $accent = $clubThemes[$club->color_theme] ?? $clubThemes['green'];
                        $courseCount = $club->courses->count();
                    @endphp
                    <div class="paper-card group transition-transform hover:-translate-y-1 p-6 sm:p-8" style="border-top:8px solid {{ $accent }}">
                        <div class="flex items-start gap-5 mb-6">
                            <div class="w-16 h-16 rounded-xl border-2 border-[#1B1B1E] grid place-items-center flex-shrink-0 bg-white" style="box-shadow:4px 4px 0 {{ $accent }}">
                                <span class="font-black text-2xl" style="color:{{ $accent }}">{{ strtoupper(substr($club->name, 0, 1)) }}</span>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h2 class="font-black text-2xl" style="color:#1B1B1E">{{ $club->name }}</h2>
                                <p class="text-sm font-semibold mt-1 line-clamp-2" style="color:#1B1B1E99">{{ $club->description }}</p>
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-2 mb-6">
                            <span class="paper-chip text-white" style="background:{{ $accent }}">{{ $courseCount }} {{ Str::plural('Course', $courseCount) }}</span>
                            @if($club->icon && !preg_match('/[\x{1F300}-\x{1FAFF}]/u', $club->icon))
                                <span class="paper-chip bg-[#1B1B1E] text-white">{{ $club->icon }}</span>
                            @endif
                        </div>

                        @if($courseCount > 0)
                            <div class="space-y-2.5 mb-7">
                                @foreach($club->courses->take(3) as $course)
                                    <div class="flex items-center gap-3 px-4 py-3 rounded-xl border-2 border-[#1B1B1E]/15 bg-[#FAF7F0]">
                                        <div class="w-7 h-7 rounded-md grid place-items-center flex-shrink-0" style="background:{{ $accent }}">
                                            <svg class="w-4 h-4 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/></svg>
                                        </div>
                                        <span class="font-bold text-sm flex-1 truncate" style="color:#1B1B1E">{{ $course->title }}</span>
                                        <span class="text-xs font-bold uppercase tracking-wide" style="color:#1B1B1Eaa">{{ $course->level ?? 'All levels' }}</span>
                                    </div>
                                @endforeach
                                @if($courseCount > 3)
                                    <p class="text-center pt-1 text-xs font-bold" style="color:#1B1B1Eaa">+{{ $courseCount - 3 }} more courses in this club</p>
                                @endif
                            </div>
                        @else
                            <div class="text-center py-6 mb-7 border-2 border-dashed border-[#1B1B1E]/20 rounded-xl">
                                <p class="text-sm font-bold" style="color:#1B1B1E99">No courses yet</p>
                            </div>
                        @endif

                        <a href="{{ route('parent.courses.show', $club) }}"
                           class="btn-flat w-full" style="background:{{ $accent }};border-color:{{ $accent }}">
                            Browse Courses
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

@include('parent.partials.flow-styles')
<style>
    .line-clamp-2 { display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection