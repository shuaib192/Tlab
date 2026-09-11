@extends('layouts.parent')
@section('title', $club->name)

@section('parent-content')
@include('parent.partials.flow-nav', ['label' => 'Course Details'])

<main class="flow-body min-h-screen px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="max-w-6xl mx-auto">

        @include('parent.partials.stepper', ['step' => 2, 'club' => $club])

        @if(session('success'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-xl border-2 border-[#1B1B1E] bg-[#E9F7EF] font-bold text-sm mb-8" style="box-shadow:5px 5px 0 rgba(27,27,30,.12)">
                <svg class="w-5 h-5 text-[#16A34A] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif
        @if(session('error'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-xl border-2 border-[#1B1B1E] bg-[#FDECEC] font-bold text-sm mb-8" style="box-shadow:5px 5px 0 rgba(27,27,30,.12)">
                <svg class="w-5 h-5 text-[#DC2626] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @php
            $clubThemes = [
                'green'  => '#16A34A',
                'blue'   => '#2563EB',
                'orange' => '#EA580C',
                'violet' => '#7C3AED',
            ];
            $accent = $clubThemes[$club->color_theme] ?? $clubThemes['green'];
        @endphp

        <div class="paper-card mb-10 overflow-hidden" style="border-top:10px solid {{ $accent }}">
            <div class="p-8 sm:p-10">
                <div class="flex items-center gap-5 mb-6">
                    <div class="w-20 h-20 rounded-xl border-2 border-[#1B1B1E] grid place-items-center flex-shrink-0 bg-white" style="box-shadow:5px 5px 0 {{ $accent }}">
                        <span class="font-black text-3xl" style="color:{{ $accent }}">{{ strtoupper(substr($club->name, 0, 1)) }}</span>
                    </div>
                    <div>
                        <span class="paper-chip text-white" style="background:{{ $accent }}">{{ $courses->count() }} {{ Str::plural('Course', $courses->count()) }}</span>
                        <h1 class="font-black text-3xl sm:text-4xl tracking-tight mt-2" style="color:#1B1B1E">{{ $club->name }}</h1>
                    </div>
                </div>
                <p class="font-semibold text-sm sm:text-base max-w-2xl leading-relaxed" style="color:#1B1B1E99">{{ $club->description }}</p>
            </div>
        </div>

        @if($courses->isEmpty())
            <div class="paper-card p-12 sm:p-20 text-center">
                <div class="w-20 h-20 mx-auto mb-6 border-2 border-[#1B1B1E] rounded-2xl grid place-items-center bg-white" style="box-shadow:5px 5px 0 rgba(27,27,30,.12)">
                    <svg class="w-9 h-9 text-[#1B1B1E]/40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
                </div>
                <h2 class="font-black text-2xl mb-3" style="color:#1B1B1E">No Courses Here Yet</h2>
                <p class="font-semibold text-sm max-w-md mx-auto mb-8" style="color:#1B1B1E99">This club hasn't published any courses yet. Check back soon.</p>
                <a href="{{ route('parent.courses.index') }}" class="btn-flat soft">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
                    Browse Other Clubs
                </a>
            </div>
        @else
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-7">
                @foreach($courses as $course)
                    <div class="paper-card group transition-transform hover:-translate-y-1 p-6" style="border-top:8px solid {{ $accent }}">
                        <div class="flex items-start gap-4 mb-4">
                            <div class="w-12 h-12 rounded-xl border-2 border-[#1B1B1E] grid place-items-center flex-shrink-0 bg-white" style="box-shadow:3px 3px 0 {{ $accent }}">
                                <svg class="w-6 h-6" style="color:{{ $accent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                            </div>
                            <div class="flex-1 min-w-0">
                                <h3 class="font-black text-lg" style="color:#1B1B1E">{{ $course->title }}</h3>
                                <span class="paper-chip mt-1.5 text-white" style="background:{{ $accent }}">{{ $course->level ?? 'All levels' }}</span>
                            </div>
                        </div>

                        @if($course->description)
                            <p class="text-sm font-semibold leading-relaxed mb-5 line-clamp-3" style="color:#1B1B1E99">{{ $course->description }}</p>
                        @endif

                        <div class="flex flex-wrap items-center gap-2 mb-6">
                            @if($course->grade_level)
                                <span class="paper-chip bg-[#1B1B1E] text-white">Grade {{ $course->grade_level }}</span>
                            @endif
                            @if($course->fee)
                                <span class="paper-chip text-white" style="background:{{ $accent }}">₦{{ number_format($course->fee) }}</span>
                            @endif
                            @if($course->teacher)
                                <span class="paper-chip bg-white text-[#1B1B1E] border-2 border-[#1B1B1E]">{{ $course->teacher->name }}</span>
                            @endif
                        </div>

                        <a href="{{ route('parent.courses.enroll', $course) }}"
                           class="btn-flat w-full" style="background:{{ $accent }};border-color:{{ $accent }}">
                            Enrol Now
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        </a>
                    </div>
                @endforeach
            </div>
        @endif
    </div>
</main>

@include('parent.partials.flow-styles')
<style>
    .line-clamp-3 { display: -webkit-box; -webkit-line-clamp: 3; -webkit-box-orient: vertical; overflow: hidden; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection