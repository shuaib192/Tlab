@extends('layouts.app')

@section('title', $lesson->title . ' — Lesson')

@push('styles')
<style>
    .glass { background:rgba(250,245,232,0.03); border:1px solid rgba(250,245,232,0.07); }
    .xp-bar { height:6px; border-radius:99px; background:rgba(250,245,232,0.08); overflow:hidden; }
    .xp-fill { height:100%; border-radius:99px; transition:width 1.2s cubic-bezier(.34,1.56,.64,1); }
    .video-container { position:relative; padding-bottom:56.25%; height:0; overflow:hidden; border-radius:16px; background:#000; }
    .video-container iframe, .video-container video { position:absolute; top:0; left:0; width:100%; height:100%; border-radius:16px; }
    .btn-mark { transition:all 0.2s; }
    .btn-mark:hover:not(.disabled) { transform:translateY(-2px); }
    .chip { display:inline-flex; align-items:center; padding:4px 10px; border-radius:99px; font-weight:700; font-size:0.7rem; letter-spacing:0.02em; }
    .reveal { opacity:0; transform:translateY(12px); will-change:transform,opacity; }
    .reveal.in { opacity:1; transform:translateY(0); transition:opacity 0.5s cubic-bezier(0.16,1,0.3,1),transform 0.5s cubic-bezier(0.16,1,0.3,1); }
</style>
@endpush

@section('content')

<nav class="sticky top-0 z-50 px-8 py-5 flex justify-between items-center glass border-b border-white/5">
    <div class="flex items-center gap-4">
        <a href="{{ $enrollment ? route('child.course', $enrollment->id) : route('child.dashboard') }}" class="w-10 h-10 rounded-xl flex items-center justify-center font-display text-xl font-black italic text-white"
           style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <div class="font-display text-lg font-bold">{{ $lesson->title }}</div>
            <div class="text-xs text-cream/60 font-bold">{{ $course->title }} / {{ $module->title }}</div>
        </div>
    </div>
    <div class="flex items-center gap-2 text-sm text-cream/40">
        @if($lesson->duration)
        <span class="flex items-center gap-1">⏱ {{ $lesson->duration }} min</span>
        @endif
        @if($lesson->type === 'video')
        <span class="chip" style="background:rgba(46,139,192,0.12);color:#2E8BC0">🎬 Video</span>
        @elseif($lesson->type === 'text')
        <span class="chip" style="background:rgba(78,153,102,0.12);color:#4E9966">📖 Text</span>
        @elseif($lesson->assessment)
        <span class="chip" style="background:rgba(212,162,36,0.12);color:#D4A224">📝 Quiz</span>
        @endif
    </div>
</nav>

<main class="max-w-4xl mx-auto px-8 py-10">

    {{-- Module Progress --}}
    <div class="flex items-center gap-3 mb-8 text-sm">
        <span class="text-cream/50 font-bold">Module Progress</span>
        <div class="flex-1 max-w-xs">
            <div class="xp-bar">
                <div class="xp-fill" id="module-progress-bar" data-progress="{{ count($moduleLessonIds) > 0 ? round(($moduleCompleted / count($moduleLessonIds)) * 100) : 0 }}" style="width:0%;background:linear-gradient(90deg,#4E9966,#2a6e44)"></div>
            </div>
        </div>
        <span class="text-cream/40 text-xs">{{ $moduleCompleted }}/{{ count($moduleLessonIds) }}</span>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-8">

            {{-- Video --}}
            @if($lesson->type === 'video' && $lesson->video_url)
            <div class="reveal" data-delay="0">
                <div class="video-container">
                    @if(preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $lesson->video_url) || preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $lesson->video_url, $m))
                    <iframe src="https://www.youtube.com/embed/{{ $m[1] ?? '' }}" frameborder="0" allowfullscreen></iframe>
                    @elseif(preg_match('/vimeo\.com\/(\d+)/', $lesson->video_url, $m))
                    <iframe src="https://player.vimeo.com/video/{{ $m[1] }}" frameborder="0" allowfullscreen></iframe>
                    @else
                    <video controls>
                        <source src="{{ $lesson->video_url }}" type="video/mp4">
                    </video>
                    @endif
                </div>
            </div>
            @endif

            {{-- Lesson Content --}}
            <div class="reveal" data-delay="100">
                <div class="glass rounded-3xl p-8">
                    <h1 class="font-display text-2xl md:text-3xl font-black mb-4">{{ $lesson->title }}</h1>
                    <div class="prose prose-invert max-w-none text-cream/80 leading-relaxed">
                        {!! nl2br(e($lesson->content ?? '')) !!}
                    </div>
                </div>
            </div>

            {{-- Assessment Section --}}
            @if($lesson->assessment)
            <div class="reveal" data-delay="150">
                <div class="rounded-3xl p-8" style="background:rgba(212,162,36,0.06);border:1px solid rgba(212,162,36,0.2)">
                    <div class="flex items-center gap-4 mb-4">
                        <div class="text-3xl">📝</div>
                        <div>
                            <h2 class="font-display text-xl font-bold text-gold">{{ $lesson->assessment->title ?? 'Assessment' }}</h2>
                            <p class="text-cream/60 text-sm">{{ $lesson->assessment->description ?? 'Test your knowledge with this quiz.' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-4 text-sm text-cream/50 mb-6">
                        @if($lesson->assessment->passing_score)
                        <span>Passing score: <strong class="text-cream/80">{{ $lesson->assessment->passing_score }}</strong></span>
                        @endif
                        @if($lesson->assessment->time_limit)
                        <span>Time limit: <strong class="text-cream/80">{{ $lesson->assessment->time_limit }} min</strong></span>
                        @endif
                        <span>Questions: <strong class="text-cream/80">{{ $lesson->assessment->questions()->count() }}</strong></span>
                    </div>
                    <a href="{{ route('child.assessment', $lesson->assessment->id) }}"
                       class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white transition-all"
                       style="background:linear-gradient(135deg,#D4A224,#b8891e);box-shadow:0 4px 16px rgba(212,162,36,0.3)">
                        @if($isCompleted)
                        Retake Quiz
                        @else
                        Start Quiz
                        @endif
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="space-y-6">

            {{-- Module Lessons --}}
            <div class="glass rounded-2xl p-5">
                <h3 class="font-display text-sm font-bold text-cream/60 uppercase tracking-widest mb-4">{{ $module->title }}</h3>
                <div class="space-y-1">
                    @foreach($module->lessons as $i => $modLesson)
                    <a href="{{ route('child.lesson', $modLesson->id) }}"
                       class="flex items-center gap-3 p-3 rounded-xl transition-all text-sm
                              {{ $modLesson->id === $lesson->id ? 'bg-white/10 border border-white/10' : 'hover:bg-white/5' }}">
                        <div class="w-7 h-7 rounded-lg flex items-center justify-center flex-shrink-0 text-xs font-bold"
                             style="background:{{ $modLesson->id === $lesson->id ? 'rgba(78,153,102,0.2)' : 'rgba(250,245,232,0.05)' }};
                                    color:{{ $modLesson->id === $lesson->id ? '#4E9966' : 'rgba(250,245,232,0.4)' }}">
                            @php
                                $isModCompleted = $modLesson->assessment && in_array($modLesson->assessment->id, $completedLessonIds ?? []);
                            @endphp
                            @if($isModCompleted)
                            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @else
                            {{ $i + 1 }}
                            @endif
                        </div>
                        <span class="flex-1 truncate {{ $isModCompleted ? 'text-mint' : '' }} {{ $modLesson->id === $lesson->id ? 'font-bold' : 'text-cream/70' }}">
                            {{ $modLesson->title }}
                        </span>
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Mark Complete / Navigation --}}
            <div class="glass rounded-2xl p-5 space-y-4">
                @if($prevLesson)
                <a href="{{ route('child.lesson', $prevLesson->id) }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl font-bold text-sm text-cream/70 transition-all border border-white/10 hover:bg-white/5">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Previous Lesson
                </a>
                @endif

                @if($nextLesson)
                <a href="{{ route('child.lesson', $nextLesson->id) }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl font-bold text-sm text-white transition-all"
                   style="background:linear-gradient(135deg,#4E9966,#2a6e44);box-shadow:0 4px 16px rgba(78,153,102,0.3)">
                    Next Lesson
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endif

                @if($lesson->assessment)
                <a href="{{ route('child.assessment', $lesson->assessment->id) }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl font-bold text-sm text-white transition-all"
                   style="background:linear-gradient(135deg,#D4A224,#b8891e);box-shadow:0 4px 16px rgba(212,162,36,0.3)">
                    {{ $isCompleted ? '🔄 Retake Quiz' : '📝 Take Quiz' }}
                </a>
                @endif

                <a href="{{ $enrollment ? route('child.course', $enrollment->id) : route('child.dashboard') }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl font-bold text-sm text-cream/50 transition-all hover:text-cream/80">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 10h16M4 14h16M4 18h16"/></svg>
                    Back to Course
                </a>
            </div>

        </div>
    </div>

</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('module-progress-bar');
        if (bar) {
            setTimeout(() => { bar.style.width = bar.dataset.progress + '%'; }, 400);
        }

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((en) => {
                if (en.isIntersecting) {
                    const delay = parseInt(en.target.getAttribute('data-delay')) || 0;
                    setTimeout(() => en.target.classList.add('in'), delay);
                    observer.unobserve(en.target);
                }
            });
        }, { threshold: 0.05 });
        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
    });
</script>
@endpush
