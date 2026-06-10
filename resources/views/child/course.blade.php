@extends('layouts.app')
@section('title', $course->title . ' — Course')

@push('styles')
<style>
    .glass{background:rgba(250,245,232,0.03);border:1px solid rgba(250,245,232,0.07)}
    .module-body{overflow:hidden;transition:max-height 0.4s cubic-bezier(.4,0,.2,1),opacity 0.3s ease}
    .module-body.collapsed{max-height:0!important;opacity:0}
    .accordion-arrow{transition:transform 0.3s ease}
    .accordion-arrow.open{transform:rotate(180deg)}
    .progress-ring{transform:rotate(-90deg)}
    .progress-ring circle{transition:stroke-dashoffset 1.5s cubic-bezier(.34,1.56,.64,1)}
    .bounce-in{animation:bounceIn 0.5s cubic-bezier(.34,1.56,.64,1)}
    @keyframes bounceIn{0%{transform:scale(0);opacity:0}50%{transform:scale(1.15)}100%{transform:scale(1);opacity:1}}
    .slide-up{animation:slideUp 0.4s ease-out}
    @keyframes slideUp{0%{transform:translateY(20px);opacity:0}100%{transform:translateY(0);opacity:1}}
    .pulse-glow{animation:pulseGlow 2s ease-in-out infinite}
    @keyframes pulseGlow{0%,100%{box-shadow:0 0 20px rgba(78,153,102,0.2)}50%{box-shadow:0 0 40px rgba(78,153,102,0.4)}}
    .confetti-piece{position:fixed;width:10px;height:10px;z-index:9999;pointer-events:none;animation:confettiFall 3s ease-out forwards}
    @keyframes confettiFall{0%{transform:translateY(-10vh) rotate(0deg);opacity:1}100%{transform:translateY(110vh) rotate(720deg);opacity:0}}
    .module-complete-glow{animation:moduleGlow 2s ease-out}
    @keyframes moduleGlow{0%{box-shadow:0 0 0 rgba(78,153,102,0.5)}50%{box-shadow:0 0 30px rgba(78,153,102,0.3)}100%{box-shadow:0 0 0 rgba(78,153,102,0)}}
    .celebrate-text{animation:celebrate 1s cubic-bezier(.34,1.56,.64,1)}
    @keyframes celebrate{0%{transform:scale(0) rotate(-10deg);opacity:0}60%{transform:scale(1.2) rotate(3deg)}100%{transform:scale(1) rotate(0);opacity:1}}
    .xp-float{animation:xpFloat 1.5s ease-out forwards;pointer-events:none}
    @keyframes xpFloat{0%{transform:translateY(0) scale(1);opacity:1}100%{transform:translateY(-60px) scale(1.5);opacity:0}}
</style>
@endpush

@section('content')
<nav class="sticky top-0 z-50 px-4 sm:px-8 py-4 flex justify-between items-center glass border-b border-white/5">
    <div class="flex items-center gap-3 sm:gap-4">
        <a href="{{ route('child.dashboard') }}" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center transition-all hover:scale-105" style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
        </a>
        <div class="min-w-0">
            <div class="font-display text-sm sm:text-lg font-bold truncate">{{ $course->title }}</div>
            <div class="text-[10px] sm:text-xs text-cream/60 font-bold truncate">{{ $course->club->name ?? 'Course' }}</div>
        </div>
    </div>
    <div class="hidden sm:flex items-center gap-2 text-sm text-cream/40">
        <span class="flex items-center gap-1">📚 <span class="font-bold text-cream/70">{{ $totalLessons }}</span> lessons</span>
        <span class="w-1 h-1 rounded-full bg-cream/20"></span>
        <span class="flex items-center gap-1">✅ <span class="font-bold text-mint">{{ $completedLessons }}</span> done</span>
    </div>
</nav>

<main class="max-w-5xl mx-auto px-4 sm:px-8 py-8 sm:py-10">

    @if(session('assessment_result'))
    @php $ar = session('assessment_result'); @endphp
    <div class="mb-8 rounded-3xl p-5 sm:p-6 celebrate-text {{ $ar['status'] === 'passed' ? 'bg-mint/10 border border-mint/30' : 'bg-terra/10 border border-terra/30' }}">
        <div class="flex items-center gap-3 sm:gap-4">
            <div class="text-3xl sm:text-4xl bounce-in">{{ $ar['status'] === 'passed' ? '🎉' : '💪' }}</div>
            <div class="flex-1 min-w-0">
                <div class="font-display text-lg sm:text-xl font-bold {{ $ar['status'] === 'passed' ? 'text-mint' : 'text-terra' }}">{{ $ar['status'] === 'passed' ? 'Assessment Passed! 🎉' : 'Keep Trying! 💪' }}</div>
                <div class="text-cream/70 text-xs sm:text-sm mt-0.5">Score: <span class="font-bold">{{ $ar['score'] }}/{{ $ar['total'] }}</span> · Passing: {{ $ar['passing_score'] }}%</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Hero with Progress --}}
    <div class="rounded-3xl p-6 sm:p-8 mb-8 relative overflow-hidden" style="background:linear-gradient(135deg,rgba(78,153,102,0.12),rgba(78,153,102,0.03));border:1px solid rgba(78,153,102,0.25)">
        <div class="absolute -right-20 -top-20 w-80 h-80 rounded-full blur-3xl opacity-15" style="background:#4E9966"></div>
        <div class="absolute -left-10 -bottom-10 w-48 h-48 rounded-full blur-3xl opacity-10" style="background:#2a6e44"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 text-cream/50 text-[10px] sm:text-xs font-bold uppercase tracking-widest mb-2">
                <span>{{ $course->club->name ?? 'Course' }}</span>
                <span class="text-cream/30">/</span>
                <span class="text-mint">{{ $course->level ?? 'All Levels' }}</span>
            </div>
            <h1 class="font-display text-2xl sm:text-3xl md:text-4xl font-black mb-2">{{ $course->title }}</h1>
            <p class="text-cream/60 text-sm sm:text-base max-w-2xl mb-6">{{ $course->description }}</p>

            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                <div class="relative flex-shrink-0">
                    <svg class="progress-ring" width="80" height="80" viewBox="0 0 120 120">
                        <circle cx="60" cy="60" r="52" fill="none" stroke="rgba(250,245,232,0.08)" stroke-width="10"/>
                        <circle cx="60" cy="60" r="52" fill="none" stroke="#4E9966" stroke-width="10" stroke-linecap="round"
                                stroke-dasharray="326.7" stroke-dashoffset="326.7"
                                id="progress-circle" data-progress="{{ $progress }}">
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <span class="font-display font-black text-xl text-mint">{{ $progress }}<span class="text-sm">%</span></span>
                    </div>
                </div>
                <div class="flex-1 w-full">
                    <div class="flex justify-between text-xs sm:text-sm mb-2">
                        <span class="text-cream/70 font-bold">{{ $completedLessons }}/{{ $totalLessons }} lessons completed</span>
                        @if($progress == 100)
                        <span class="text-mint font-bold bounce-in" id="complete-badge">🎉 Complete!</span>
                        @endif
                    </div>
                    <div class="h-2.5 rounded-full overflow-hidden" style="background:rgba(250,245,232,0.08)">
                        <div class="h-full rounded-full transition-all duration-1000 ease-out" id="progress-bar" data-progress="{{ $progress }}"
                             style="width:0%;background:linear-gradient(90deg,#4E9966,#2a6e44)"></div>
                    </div>
                    <div class="flex gap-4 mt-3 text-xs sm:text-sm">
                        <div class="text-center px-3 py-2 rounded-xl" style="background:rgba(78,153,102,0.1)">
                            <div class="font-display font-black text-mint">{{ $totalLessons }}</div>
                            <div class="text-cream/40 text-[10px] font-bold">Lessons</div>
                        </div>
                        <div class="text-center px-3 py-2 rounded-xl" style="background:rgba(212,162,36,0.1)">
                            <div class="font-display font-black text-gold">{{ $completedLessons }}</div>
                            <div class="text-cream/40 text-[10px] font-bold">Done</div>
                        </div>
                        <div class="text-center px-3 py-2 rounded-xl" style="background:rgba(78,153,102,0.05)">
                            <div class="font-display font-black text-cream/60">{{ $totalLessons - $completedLessons }}</div>
                            <div class="text-cream/40 text-[10px] font-bold">Remaining</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modules Accordion --}}
    <div class="space-y-3 sm:space-y-4" id="modules-container">
        @forelse($moduleData as $index => $module)
        @php
            $modDone = collect($module->lessons)->where('completed', true)->count();
            $modTotal = count($module->lessons);
            $modComplete = $modDone > 0 && $modDone === $modTotal;
        @endphp
        <div class="glass rounded-2xl overflow-hidden transition-all duration-300 module-wrapper" data-module="{{ $index }}" data-complete="{{ $modComplete ? 'true' : 'false' }}">
            <div class="module-header flex items-center justify-between p-4 sm:p-5 cursor-pointer select-none hover:bg-white/[0.02] transition-all"
                 onclick="toggleModule({{ $index }})">
                <div class="flex items-center gap-3 sm:gap-4 min-w-0">
                    <div class="w-10 h-10 sm:w-12 sm:h-12 rounded-xl flex items-center justify-center font-black text-base sm:text-lg flex-shrink-0 transition-all duration-300"
                         style="background:{{ $modComplete ? 'rgba(78,153,102,0.2)' : 'rgba(78,153,102,0.1)' }};color:{{ $modComplete ? '#4E9966' : 'rgba(250,245,232,0.5)' }}">
                        @if($modComplete)
                        <svg class="w-5 h-5 sm:w-6 sm:h-6 bounce-in" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                        @else
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                        @endif
                    </div>
                    <div class="min-w-0">
                        <h3 class="font-display text-sm sm:text-lg font-bold truncate {{ $modComplete ? 'text-mint' : '' }}">{{ $module->title }}</h3>
                        @if($module->description)
                        <p class="text-cream/50 text-xs sm:text-sm truncate">{{ $module->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-2 sm:gap-3 flex-shrink-0">
                    @if($modComplete)
                    <span class="text-[10px] sm:text-xs font-bold px-2 sm:px-3 py-1 rounded-full" style="background:rgba(78,153,102,0.15);color:#4E9966">✅ Complete</span>
                    @endif
                    <span class="text-cream/40 text-[10px] sm:text-xs font-bold hidden sm:inline">{{ $modDone }}/{{ $modTotal }}</span>
                    <svg class="accordion-arrow w-4 h-4 sm:w-5 sm:h-5 text-cream/40 {{ $index === 0 ? 'open' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
            <div class="module-body {{ $index !== 0 ? 'collapsed' : '' }}" id="module-body-{{ $index }}">
                <div class="px-4 sm:px-5 pb-4 sm:pb-5 space-y-2">
                    @forelse($module->lessons as $lesson)
                    <a href="{{ route('child.lesson', $lesson->id) }}" 
                       class="lesson-link flex items-center gap-3 sm:gap-4 p-3 sm:p-4 rounded-xl transition-all duration-200 hover:scale-[1.01]"
                       style="background:{{ $lesson->completed ? 'rgba(78,153,102,0.06)' : 'rgba(250,245,232,0.02)' }};border:1px solid {{ $lesson->completed ? 'rgba(78,153,102,0.15)' : 'transparent' }}">
                        <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center flex-shrink-0 transition-all"
                             style="background:{{ $lesson->completed ? 'rgba(78,153,102,0.15)' : 'rgba(250,245,232,0.05)' }};color:{{ $lesson->completed ? '#4E9966' : 'rgba(250,245,232,0.4)' }}">
                            @if($lesson->completed)
                            <svg class="w-4 h-4 sm:w-5 sm:h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @else
                            <span class="text-xs sm:text-sm font-bold">{{ $lesson->sort_order }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-xs sm:text-sm {{ $lesson->completed ? 'text-mint' : 'text-cream' }} truncate">{{ $lesson->title }}</div>
                            <div class="flex items-center gap-2 sm:gap-3 text-[10px] sm:text-xs text-cream/40 mt-0.5 flex-wrap">
                                <span>{{ $lesson->type === 'video' ? '🎬' : ($lesson->type === 'text' ? '📖' : ($lesson->has_assessment ? '📝' : '📖')) }} {{ ucfirst($lesson->type) }}</span>
                                @if($lesson->duration)<span>⏱ {{ $lesson->duration }} min</span>@endif
                                @if($lesson->has_assessment)<span class="px-1.5 py-0.5 rounded text-[9px] font-bold" style="background:rgba(212,162,36,0.12);color:#D4A224">Quiz</span>@endif
                            </div>
                        </div>
                        <div class="flex-shrink-0">
                            @if($lesson->completed)
                            <span class="chip text-[10px] sm:text-xs" style="background:rgba(78,153,102,0.12);color:#4E9966">✅ Done</span>
                            @else
                            <span class="inline-flex items-center gap-1 px-3 sm:px-4 py-1.5 sm:py-2 rounded-xl font-bold text-[10px] sm:text-xs transition-all hover:scale-105" 
                                  style="background:rgba(78,153,102,0.15);color:#4E9966">
                                Start
                                <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                            </span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <p class="text-cream/30 text-xs sm:text-sm text-center py-4 sm:py-6">No lessons in this module yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @empty
        <div class="glass rounded-2xl p-8 sm:p-12 text-center">
            <div class="text-5xl sm:text-6xl mb-4">📚</div>
            <p class="text-cream/50 text-sm sm:text-base">No modules have been added to this course yet.</p>
        </div>
        @endforelse
    </div>

    {{-- Course Complete Celebration --}}
    @if($progress == 100)
    <div class="mt-8 rounded-3xl p-6 sm:p-8 text-center celebrate-text" style="background:linear-gradient(135deg,rgba(78,153,102,0.12),rgba(78,153,102,0.03));border:1px solid rgba(78,153,102,0.3)">
        <div class="text-5xl sm:text-6xl mb-4 bounce-in">🏆</div>
        <h2 class="font-display text-xl sm:text-2xl font-black text-mint mb-2">Course Complete!</h2>
        <p class="text-cream/60 text-sm sm:text-base mb-4">Amazing work! You've completed all lessons in this course.</p>
        <a href="{{ route('child.dashboard') }}" class="inline-flex items-center gap-2 px-6 py-3 rounded-xl font-bold text-sm text-white transition-all hover:scale-105 pulse-glow" 
           style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
            🎯 Back to Dashboard
        </a>
    </div>
    @endif

</main>

@endsection

@push('scripts')
<script>
    // ── Sound Engine ──
    const Sound = {
        ctx: null,
        getCtx() {
            if (!this.ctx) this.ctx = new (window.AudioContext || window.webkitAudioContext)();
            return this.ctx;
        },
        play(type) {
            try {
                const ctx = this.getCtx();
                const osc = ctx.createOscillator();
                const gain = ctx.createGain();
                osc.connect(gain);
                gain.connect(ctx.destination);
                gain.gain.value = 0.08;
                if (type === 'click') { osc.frequency.value = 800; osc.type = 'sine'; gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime + 0.1); osc.start(); osc.stop(ctx.currentTime + 0.1); }
                if (type === 'complete') { osc.frequency.value = 523; osc.type = 'sine'; osc.start(); osc.frequency.setValueAtTime(659, ctx.currentTime+0.15); osc.frequency.setValueAtTime(784, ctx.currentTime+0.3); gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime+0.5); osc.stop(ctx.currentTime+0.5); }
                if (type === 'open') { osc.frequency.value = 400; osc.type = 'triangle'; gain.gain.exponentialRampToValueAtTime(0.001, ctx.currentTime+0.15); osc.start(); osc.stop(ctx.currentTime+0.15); }
                if (type === 'tada') { osc.type = 'square'; [523,659,784,1047].forEach((f,i)=>{const o=ctx.createOscillator();const g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.05;o.frequency.value=f;o.type='square';o.start(ctx.currentTime+i*0.12);g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+i*0.12+0.2);o.stop(ctx.currentTime+i*0.12+0.2);}); }
            } catch(e) {}
        }
    };

    // ── Confetti ──
    function spawnConfetti(count = 40) {
        const colors = ['#4E9966','#D4A224','#2E8BC0','#C24B1E','#6B3FA0','#FAF5E8'];
        for (let i = 0; i < count; i++) {
            const el = document.createElement('div');
            el.className = 'confetti-piece';
            el.style.left = Math.random() * 100 + 'vw';
            el.style.background = colors[Math.floor(Math.random() * colors.length)];
            el.style.width = (Math.random() * 8 + 4) + 'px';
            el.style.height = (Math.random() * 8 + 4) + 'px';
            el.style.borderRadius = Math.random() > 0.5 ? '50%' : '2px';
            el.style.animationDuration = (Math.random() * 2 + 2) + 's';
            el.style.animationDelay = (Math.random() * 0.5) + 's';
            document.body.appendChild(el);
            setTimeout(() => el.remove(), 4000);
        }
    }

    // ── Animate progress on load ──
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('progress-bar');
        const circle = document.getElementById('progress-circle');
        if (bar) { const p = bar.dataset.progress; setTimeout(() => { bar.style.width = p + '%'; }, 300); }
        if (circle) {
            const p = parseInt(circle.dataset.progress);
            const circumference = 326.7;
            const offset = circumference - (p / 100) * circumference;
            setTimeout(() => { circle.style.strokeDashoffset = offset; }, 400);
        }

        // Celebrate if 100%
        @if($progress == 100)
        setTimeout(() => { Sound.play('tada'); spawnConfetti(60); }, 600);
        @endif

        // Check for module completion celebration
        document.querySelectorAll('.module-wrapper').forEach(w => {
            if (w.dataset.complete === 'true') {
                Sound.play('complete');
            }
        });
    });

    // ── Module toggle with sound ──
    function toggleModule(index) {
        const body = document.getElementById('module-body-' + index);
        const header = body.previousElementSibling;
        const arrow = header.querySelector('.accordion-arrow');
        const isCollapsed = body.classList.contains('collapsed');
        
        if (isCollapsed) {
            body.classList.remove('collapsed');
            arrow.classList.add('open');
            Sound.play('open');
        } else {
            body.classList.add('collapsed');
            arrow.classList.remove('open');
        }
    }

    // Click sound on lesson links
    document.querySelectorAll('.lesson-link').forEach(el => {
        el.addEventListener('click', () => Sound.play('click'));
    });

    // Open first module by default
    document.addEventListener('DOMContentLoaded', () => {
        const first = document.getElementById('module-body-0');
        if (first) first.classList.remove('collapsed');
    });
</script>
@endpush
