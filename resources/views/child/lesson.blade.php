@extends('layouts.app')
@section('title', $lesson->title . ' — Lesson')

@push('styles')
<style>
    .glass{background:rgba(250,245,232,0.03);border:1px solid rgba(250,245,232,0.07)}
    .xp-bar{height:6px;border-radius:99px;background:rgba(250,245,232,0.08);overflow:hidden}
    .xp-fill{height:100%;border-radius:99px;transition:width 1.2s cubic-bezier(.34,1.56,.64,1)}
    .video-container{position:relative;padding-bottom:56.25%;height:0;overflow:hidden;border-radius:16px;background:#000}
    .video-container iframe,.video-container video{position:absolute;top:0;left:0;width:100%;height:100%;border-radius:16px}
    .reveal{opacity:0;transform:translateY(16px)}
    .reveal.in{opacity:1;transform:translateY(0);transition:opacity 0.6s cubic-bezier(0.16,1,0.3,1),transform 0.6s cubic-bezier(0.16,1,0.3,1)}
    .typewriter-cursor{border-right:2px solid #4E9966;animation:blink 0.8s step-end infinite}
    @keyframes blink{50%{border-color:transparent}}
    .chip{display:inline-flex;align-items:center;padding:4px 10px;border-radius:99px;font-weight:700;font-size:0.7rem;letter-spacing:0.02em}
    .bounce-in{animation:bounceIn 0.5s cubic-bezier(.34,1.56,.64,1)}
    @keyframes bounceIn{0%{transform:scale(0);opacity:0}50%{transform:scale(1.15)}100%{transform:scale(1);opacity:1}}
    .checkpoint-card{transition:all 0.3s ease;cursor:pointer}
    .checkpoint-card:hover{transform:scale(1.02)}
    .checkpoint-card.revealed{background:rgba(78,153,102,0.06);border-color:rgba(78,153,102,0.25)}
    .lesson-enter{animation:slideUp 0.4s ease-out}
    @keyframes slideUp{0%{opacity:0;transform:translateY(15px)}100%{opacity:1;transform:translateY(0)}}
    .pulse-dot{animation:pulse 2s ease-in-out infinite}
    @keyframes pulse{0%,100%{opacity:0.4}50%{opacity:1}}
    .progress-step{transition:all 0.3s ease}
    .progress-step.active{transform:scale(1.2)}
</style>
@endpush

@section('content')

<nav class="sticky top-0 z-50 px-4 sm:px-8 py-4 flex justify-between items-center glass border-b border-white/5">
    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        <a href="{{ $enrollment ? route('child.course', $enrollment->id) : route('child.dashboard') }}" 
           class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-all hover:scale-105"
           style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="min-w-0">
            <div class="font-display text-sm sm:text-lg font-bold truncate">{{ $lesson->title }}</div>
            <div class="text-[10px] sm:text-xs text-cream/60 font-bold truncate">{{ $course->title }} / {{ $module->title }}</div>
        </div>
    </div>
    <div class="flex items-center gap-2 sm:gap-3 text-[10px] sm:text-sm text-cream/40 flex-shrink-0">
        @if($lesson->duration)<span class="hidden sm:flex items-center gap-1">⏱ {{ $lesson->duration }} min</span>@endif
        <span class="chip hidden sm:inline-flex" style="background:{{ $lesson->type === 'video' ? 'rgba(46,139,192,0.12);color:#2E8BC0' : ($lesson->type === 'text' ? 'rgba(78,153,102,0.12);color:#4E9966' : 'rgba(212,162,36,0.12);color:#D4A224') }}">
            {{ $lesson->type === 'video' ? '🎬 Video' : ($lesson->type === 'text' ? '📖 Text' : '📝 Quiz') }}
        </span>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-4 sm:px-8 py-6 sm:py-10">

    {{-- Module Progress Bar --}}
    <div class="flex items-center gap-3 mb-6 sm:mb-8 text-xs sm:text-sm">
        <span class="text-cream/50 font-bold hidden sm:inline">Module Progress</span>
        <div class="flex-1 max-w-[200px] sm:max-w-xs">
            <div class="xp-bar">
                <div class="xp-fill" id="module-progress-bar" 
                     data-progress="{{ count($moduleLessonIds) > 0 ? round(($moduleCompleted / count($moduleLessonIds)) * 100) : 0 }}"
                     style="width:0%;background:linear-gradient(90deg,#4E9966,#2a6e44)"></div>
            </div>
        </div>
        <span class="text-cream/40 text-[10px] sm:text-xs font-bold">{{ $moduleCompleted }}/{{ count($moduleLessonIds) }}</span>
        
        {{-- Lesson navigation steps --}}
        <div class="hidden sm:flex items-center gap-1.5 ml-4">
            @foreach($module->lessons as $i => $modLesson)
            @php $isModCompleted = $modLesson->assessment && in_array($modLesson->assessment->id, $completedLessonIds ?? []); @endphp
            <a href="{{ route('child.lesson', $modLesson->id) }}" 
               class="w-3 h-3 rounded-full transition-all duration-300 progress-step {{ $modLesson->id === $lesson->id ? 'active' : '' }}"
               style="background:{{ $modLesson->id === $lesson->id ? '#4E9966' : ($isModCompleted ? 'rgba(78,153,102,0.4)' : 'rgba(250,245,232,0.12)') }}"
               title="{{ $modLesson->title }}"></a>
            @endforeach
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 sm:gap-8">

        {{-- Main Content --}}
        <div class="lg:col-span-2 space-y-6 sm:space-y-8">

            {{-- Video --}}
            @if($lesson->type === 'video' && $lesson->video_url)
            <div class="reveal" data-delay="0">
                <div class="video-container shadow-lg">
                    @if(preg_match('/youtube\.com\/embed\/([a-zA-Z0-9_-]+)/', $lesson->video_url) || preg_match('/youtube\.com\/watch\?v=([a-zA-Z0-9_-]+)/', $lesson->video_url, $m))
                    <iframe src="https://www.youtube.com/embed/{{ $m[1] ?? '' }}" frameborder="0" allowfullscreen></iframe>
                    @elseif(preg_match('/vimeo\.com\/(\d+)/', $lesson->video_url, $m))
                    <iframe src="https://player.vimeo.com/video/{{ $m[1] }}" frameborder="0" allowfullscreen></iframe>
                    @else
                    <video controls><source src="{{ $lesson->video_url }}" type="video/mp4"></video>
                    @endif
                </div>
            </div>
            @endif

            {{-- Lesson Content with Typewriter --}}
            <div class="reveal" data-delay="100">
                <div class="glass rounded-3xl p-5 sm:p-8">
                    <h1 class="font-display text-xl sm:text-2xl md:text-3xl font-black mb-4 sm:mb-6">{{ $lesson->title }}</h1>
                    <div class="text-cream/80 leading-relaxed text-sm sm:text-base space-y-4" id="lesson-content">
                        {!! nl2br(e($lesson->content ?? '')) !!}
                    </div>
                </div>
            </div>

            {{-- Interactive Checkpoints --}}
            <div class="reveal" data-delay="200">
                <div class="space-y-3 sm:space-y-4">
                    <div class="flex items-center gap-2 text-sm sm:text-base">
                        <span class="text-xl">💡</span>
                        <span class="font-bold text-cream/70">Quick Check</span>
                    </div>
                    <div class="checkpoint-card glass rounded-2xl p-4 sm:p-6 border border-white/5" onclick="revealTip(this)">
                        <div class="flex items-center justify-between">
                            <span class="text-sm sm:text-base text-cream/50">💭 <span class="font-bold text-cream/70">Think about it:</span> What was the most important thing you learned in this lesson?</span>
                            <span class="text-cream/30 text-xs font-bold flex-shrink-0 ml-2">Click to reveal tip →</span>
                        </div>
                        <div class="hidden mt-4 p-4 rounded-xl text-sm" style="background:rgba(78,153,102,0.08);border:1px solid rgba(78,153,102,0.2)">
                            <span class="text-cream/80">🤔 <strong>Pro Tip:</strong> Try explaining the concept to someone else! If you can teach it, you've truly learned it.</span>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Assessment Section --}}
            @if($lesson->assessment)
            <div class="reveal" data-delay="150">
                <div class="rounded-3xl p-5 sm:p-8" style="background:linear-gradient(135deg,rgba(212,162,36,0.06),rgba(212,162,36,0.02));border:1px solid rgba(212,162,36,0.2)">
                    <div class="flex items-center gap-3 sm:gap-4 mb-4">
                        <div class="text-3xl sm:text-4xl">📝</div>
                        <div>
                            <h2 class="font-display text-lg sm:text-xl font-bold text-gold">{{ $lesson->assessment->title ?? 'Knowledge Check' }}</h2>
                            <p class="text-cream/60 text-xs sm:text-sm">{{ $lesson->assessment->description ?? 'Test what you just learned!' }}</p>
                        </div>
                    </div>
                    <div class="flex items-center gap-3 sm:gap-4 text-[10px] sm:text-sm text-cream/50 mb-5 sm:mb-6 flex-wrap">
                        @if($lesson->assessment->passing_score)<span>Pass: <strong class="text-cream/80">{{ $lesson->assessment->passing_score }}%</strong></span>@endif
                        @if($lesson->assessment->time_limit)<span>⏱ <strong class="text-cream/80">{{ $lesson->assessment->time_limit }} min</strong></span>@endif
                        <span>📊 <strong class="text-cream/80">{{ $lesson->assessment->questions()->count() }}</strong> questions</span>
                    </div>
                    <a href="{{ route('child.assessment', $lesson->assessment->id) }}"
                       class="inline-flex items-center gap-2 px-5 sm:px-6 py-3 sm:py-3.5 rounded-xl font-bold text-xs sm:text-sm text-white transition-all hover:scale-105 active:scale-95"
                       style="background:linear-gradient(135deg,#D4A224,#b8891e);box-shadow:0 4px 16px rgba(212,162,36,0.3)">
                        @if($isCompleted)🔄 Retake Quiz @else 🎯 Start Quiz @endif
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                    </a>
                </div>
            </div>
            @endif

        </div>

        {{-- Sidebar --}}
        <div class="space-y-4 sm:space-y-6">

            {{-- Module Lessons --}}
            <div class="glass rounded-2xl p-4 sm:p-5">
                <h3 class="font-display text-[10px] sm:text-xs font-bold text-cream/60 uppercase tracking-widest mb-3 sm:mb-4 truncate">{{ $module->title }}</h3>
                <div class="space-y-1">
                    @foreach($module->lessons as $i => $modLesson)
                    @php $isModCompleted = $modLesson->assessment && in_array($modLesson->assessment->id, $completedLessonIds ?? []); @endphp
                    <a href="{{ route('child.lesson', $modLesson->id) }}"
                       class="flex items-center gap-2 sm:gap-3 p-2.5 sm:p-3 rounded-xl transition-all text-[10px] sm:text-sm {{ $modLesson->id === $lesson->id ? 'bg-white/10 border border-white/10' : 'hover:bg-white/5' }}">
                        <div class="w-6 h-6 sm:w-7 sm:h-7 rounded-lg flex items-center justify-center flex-shrink-0 text-[10px] sm:text-xs font-bold transition-all"
                             style="background:{{ $modLesson->id === $lesson->id ? 'rgba(78,153,102,0.2)' : 'rgba(250,245,232,0.05)' }};color:{{ $modLesson->id === $lesson->id ? '#4E9966' : 'rgba(250,245,232,0.4)' }}">
                            @if($isModCompleted)
                            <svg class="w-3 h-3 sm:w-4 sm:h-4" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @else
                            {{ $i + 1 }}
                            @endif
                        </div>
                        <span class="flex-1 truncate {{ $isModCompleted ? 'text-mint' : '' }} {{ $modLesson->id === $lesson->id ? 'font-bold text-cream' : 'text-cream/60' }}">
                            {{ $modLesson->title }}
                        </span>
                        @if($modLesson->id === $lesson->id)
                        <span class="w-1.5 h-1.5 rounded-full bg-mint pulse-dot flex-shrink-0"></span>
                        @endif
                    </a>
                    @endforeach
                </div>
            </div>

            {{-- Navigation --}}
            <div class="glass rounded-2xl p-4 sm:p-5 space-y-3">
                @if($prevLesson)
                <a href="{{ route('child.lesson', $prevLesson->id) }}"
                   class="flex items-center justify-center gap-2 w-full px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl font-bold text-xs sm:text-sm text-cream/70 transition-all border border-white/10 hover:bg-white/5 hover:scale-[1.02] active:scale-95">
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                    Previous
                </a>
                @endif

                @if($nextLesson)
                <a href="{{ route('child.lesson', $nextLesson->id) }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl font-bold text-xs sm:text-sm text-white transition-all hover:scale-105 active:scale-95"
                   style="background:linear-gradient(135deg,#4E9966,#2a6e44);box-shadow:0 4px 16px rgba(78,153,102,0.3)">
                    Next Lesson
                    <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endif

                @if($lesson->assessment)
                <a href="{{ route('child.assessment', $lesson->assessment->id) }}"
                   class="flex items-center justify-center gap-2 w-full px-5 py-3 rounded-xl font-bold text-xs sm:text-sm text-white transition-all hover:scale-105 active:scale-95"
                   style="background:linear-gradient(135deg,#D4A224,#b8891e);box-shadow:0 4px 16px rgba(212,162,36,0.3)">
                    {{ $isCompleted ? '🔄 Retake Quiz' : '📝 Take Quiz' }}
                </a>
                @endif

                <a href="{{ $enrollment ? route('child.course', $enrollment->id) : route('child.dashboard') }}"
                   class="flex items-center justify-center gap-2 w-full px-4 sm:px-5 py-2.5 sm:py-3 rounded-xl font-bold text-xs sm:text-sm text-cream/50 transition-all hover:text-cream/80 hover:bg-white/5">
                    📋 Back to Course
                </a>
            </div>

        </div>
    </div>

</main>

@endsection

@push('scripts')
<script>
    // ── Sound Engine ──
    const Sound = {
        ctx: null,
        getCtx() { if (!this.ctx) this.ctx = new (window.AudioContext || window.webkitAudioContext)(); return this.ctx; },
        play(type) {
            try {
                const ctx = this.getCtx();
                if (type === 'click') { const o=ctx.createOscillator(),g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.06;o.frequency.value=700;o.type='sine';g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+0.08);o.start();o.stop(ctx.currentTime+0.08); }
                if (type === 'reveal') { const o=ctx.createOscillator(),g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.05;o.frequency.value=523;o.type='triangle';g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+0.2);o.start();o.stop(ctx.currentTime+0.2); }
                if (type === 'nav') { const o=ctx.createOscillator(),g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.06;o.frequency.setValueAtTime(440,ctx.currentTime);o.frequency.setValueAtTime(660,ctx.currentTime+0.08);o.type='sine';g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+0.2);o.start();o.stop(ctx.currentTime+0.2); }
            } catch(e) {}
        }
    };

    // ── Animate progress on load ──
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('module-progress-bar');
        if (bar) { setTimeout(() => { bar.style.width = bar.dataset.progress + '%'; }, 400); }

        // Scroll reveal
        const observer = new IntersectionObserver((entries) => {
            entries.forEach((en) => {
                if (en.isIntersecting) {
                    const delay = parseInt(en.target.getAttribute('data-delay')) || 0;
                    setTimeout(() => { en.target.classList.add('in'); }, delay);
                    observer.unobserve(en.target);
                }
            });
        }, { threshold: 0.05, rootMargin: '0px 0px -50px 0px' });
        document.querySelectorAll('.reveal').forEach((el) => observer.observe(el));
    });

    // ── Interactive Checkpoint ──
    function revealTip(el) {
        const hidden = el.querySelector('.hidden');
        if (hidden) {
            hidden.classList.remove('hidden');
            hidden.classList.add('lesson-enter');
            el.classList.add('revealed');
            Sound.play('reveal');
        }
    }

    // ── Navigation click sounds ──
    document.querySelectorAll('a').forEach(a => {
        a.addEventListener('click', () => {
            if (a.classList.contains('hover\\:scale-105')) Sound.play('nav');
            else Sound.play('click');
        });
    });
</script>
@endpush
