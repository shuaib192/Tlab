@extends('layouts.app')
@section('title', $assessment->title . ' — Quiz')

@push('styles')
<style>
    .glass{background:rgba(250,245,232,0.03);border:1px solid rgba(250,245,232,0.07)}
    .question-slide{display:none;animation:slideIn 0.35s cubic-bezier(.16,1,.3,1)}
    .question-slide.active{display:block}
    @keyframes slideIn{0%{opacity:0;transform:translateX(30px) scale(0.97)}100%{opacity:1;transform:translateX(0) scale(1)}}
    @keyframes slideOut{0%{opacity:1;transform:translateX(0) scale(1)}100%{opacity:0;transform:translateX(-30px) scale(0.97)}}
    .option-btn{cursor:pointer;transition:all 0.2s cubic-bezier(.16,1,.3,1);border:2px solid rgba(250,245,232,0.08)}
    .option-btn:hover{border-color:rgba(78,153,102,0.3);transform:translateX(4px)}
    .option-btn.selected{border-color:#4E9966;background:rgba(78,153,102,0.1);transform:translateX(4px)}
    .option-btn.correct{border-color:#4E9966;background:rgba(78,153,102,0.15);color:#4E9966}
    .option-btn.wrong{border-color:#C24B1E;background:rgba(194,75,30,0.1);color:#C24B1E}
    .bounce-in{animation:bounceIn 0.5s cubic-bezier(.34,1.56,.64,1)}
    @keyframes bounceIn{0%{transform:scale(0);opacity:0}50%{transform:scale(1.15)}100%{transform:scale(1);opacity:1}}
    .timer-ring{transform:rotate(-90deg)}
    .timer-ring circle{transition:stroke-dashoffset 1s linear}
    .confetti-piece{position:fixed;width:10px;height:10px;z-index:9999;pointer-events:none;animation:confettiFall 3s ease-out forwards}
    @keyframes confettiFall{0%{transform:translateY(-10vh) rotate(0deg);opacity:1}100%{transform:translateY(110vh) rotate(720deg);opacity:0}}
    .progress-dot{width:10px;height:10px;border-radius:50%;transition:all 0.3s ease;cursor:pointer}
    .progress-dot.active{transform:scale(1.3);box-shadow:0 0 8px rgba(78,153,102,0.5)}
    .progress-dot.correct{background:#4E9966!important}
    .progress-dot.wrong{background:#C24B1E!important}
    .progress-dot.skipped{background:rgba(250,245,232,0.15)!important}
    .score-digit{display:inline-block;animation:scorePop 0.3s cubic-bezier(.34,1.56,.64,1)}
    @keyframes scorePop{0%{transform:scale(0)}100%{transform:scale(1)}}
    .feedback-text{animation:fadeInUp 0.3s ease}
    @keyframes fadeInUp{0%{opacity:0;transform:translateY(10px)}100%{opacity:1;transform:translateY(0)}}
    .xp-fly{animation:xpFloat 1.5s ease-out forwards;pointer-events:none;position:fixed;z-index:9998;font-weight:900;font-size:1.5rem}
    @keyframes xpFloat{0%{transform:translateY(0) scale(1);opacity:1}100%{transform:translateY(-80px) scale(1.5);opacity:0}}
    .chip{display:inline-flex;align-items:center;padding:4px 10px;border-radius:99px;font-weight:700;font-size:0.7rem;letter-spacing:0.02em}
</style>
@endpush

@section('content')

<nav class="sticky top-0 z-50 px-4 sm:px-8 py-4 flex justify-between items-center glass border-b border-white/5">
    <div class="flex items-center gap-3 sm:gap-4 min-w-0">
        <a href="{{ route('child.lesson', $lesson->id) }}" class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center flex-shrink-0 transition-all hover:scale-105"
           style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
            <svg class="w-4 h-4 sm:w-5 sm:h-5 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div class="min-w-0">
            <div class="font-display text-sm sm:text-lg font-bold truncate">{{ $assessment->title ?? 'Quiz' }}</div>
            <div class="text-[10px] sm:text-xs text-cream/60 font-bold truncate">{{ $course->title }}</div>
        </div>
    </div>
    <div class="flex items-center gap-2 sm:gap-4">
        <div class="hidden sm:flex items-center gap-1 text-xs text-cream/50">
            <span class="font-bold text-cream/80" id="current-q-display">1</span>
            <span>/{{ $assessment->questions->count() }}</span>
        </div>
        @if($assessment->time_limit)
        <div class="flex items-center gap-2 text-xs sm:text-sm" id="timer">
            <svg class="w-4 h-4 text-gold hidden sm:block" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-bold timer text-gold" id="timer-display">{{ $assessment->time_limit }}:00</span>
        </div>
        @endif
    </div>
</nav>

<main class="max-w-3xl mx-auto px-4 sm:px-8 py-6 sm:py-10">

    @if($existingAttempt && $existingAttempt->status === 'passed')
    <div class="mb-6 sm:mb-8 rounded-3xl p-4 sm:p-6 bounce-in" style="background:rgba(78,153,102,0.1);border:1px solid rgba(78,153,102,0.3)">
        <div class="flex items-center gap-3 sm:gap-4">
            <div class="text-3xl sm:text-4xl">🎉</div>
            <div>
                <div class="font-display font-bold text-base sm:text-xl text-mint">You Passed Before!</div>
                <div class="text-cream/70 text-xs sm:text-sm mt-0.5">Score: <strong>{{ $existingAttempt->score }}/{{ $existingAttempt->total }}</strong> · Retake to improve!</div>
            </div>
        </div>
    </div>
    @elseif($existingAttempt)
    <div class="mb-6 sm:mb-8 rounded-3xl p-4 sm:p-6 bounce-in" style="background:rgba(194,75,30,0.1);border:1px solid rgba(194,75,30,0.25)">
        <div class="flex items-center gap-3 sm:gap-4">
            <div class="text-3xl sm:text-4xl">💪</div>
            <div>
                <div class="font-display font-bold text-base sm:text-xl" style="color:#C24B1E">Previous Attempt</div>
                <div class="text-cream/70 text-xs sm:text-sm mt-0.5">Score: <strong>{{ $existingAttempt->score }}/{{ $existingAttempt->total }}</strong> · Try again!</div>
            </div>
        </div>
    </div>
    @endif

    {{-- Progress Dots --}}
    <div class="flex items-center justify-center gap-1.5 sm:gap-2 mb-6 sm:mb-8" id="progress-dots">
        @foreach($assessment->questions as $index => $q)
        <div class="progress-dot {{ $index === 0 ? 'active' : '' }}" data-question="{{ $index }}" style="background:rgba(250,245,232,0.12)"></div>
        @endforeach
    </div>

    {{-- Questions Form --}}
    <form method="POST" action="{{ route('child.assessment.submit', $assessment->id) }}" id="assessment-form">
        @csrf
        <input type="hidden" name="answers_json" id="answers-json">
        <input type="hidden" name="time_spent" id="time-spent">

        <div id="questions-container">
            @foreach($assessment->questions as $index => $question)
            <div class="question-slide {{ $index === 0 ? 'active' : '' }}" data-question="{{ $index }}">
                <div class="glass rounded-3xl p-5 sm:p-8 mb-4 sm:mb-6">
                    <div class="flex items-start gap-3 sm:gap-4 mb-5 sm:mb-6">
                        <div class="w-9 h-9 sm:w-10 sm:h-10 rounded-xl flex items-center justify-center font-black text-sm sm:text-base flex-shrink-0"
                             style="background:rgba(212,162,36,0.12);color:#D4A224">
                            {{ $index + 1 }}
                        </div>
                        <div class="flex-1">
                            <p class="font-bold text-base sm:text-lg text-cream">{{ $question->question }}</p>
                            @if($question->type === 'multiple_choice' && is_array($question->options))
                            <div class="space-y-2 sm:space-y-3 mt-4 sm:mt-5" id="options-{{ $index }}">
                                @foreach($question->options as $optIdx => $option)
                                <div class="option-btn rounded-xl p-3.5 sm:p-4 flex items-center gap-3" 
                                     onclick="selectOption({{ $index }}, '{{ addslashes($option) }}', this)"
                                     data-question="{{ $index }}" data-option="{{ $option }}">
                                    <div class="w-8 h-8 sm:w-9 sm:h-9 rounded-lg flex items-center justify-center text-xs sm:text-sm font-bold flex-shrink-0"
                                         style="background:rgba(250,245,232,0.05);color:rgba(250,245,232,0.5)">
                                        {{ chr(65 + $optIdx) }}
                                    </div>
                                    <span class="text-sm sm:text-base text-cream/80">{{ $option }}</span>
                                </div>
                                @endforeach
                            </div>
                            @endif
                        </div>
                    </div>
                </div>

                <div class="flex items-center justify-between p-4 glass rounded-2xl">
                    <button type="button" onclick="prevQuestion()" class="px-4 sm:px-6 py-2.5 sm:py-3 rounded-xl font-bold text-xs sm:text-sm text-cream/70 hover:text-cream border border-white/10 hover:bg-white/5 transition-all {{ $index === 0 ? 'invisible' : '' }}">
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                        Back
                    </button>
                    <span class="text-cream/40 text-[10px] sm:text-xs font-bold">Question {{ $index + 1 }} of {{ $assessment->questions->count() }}</span>
                    @if($index < $assessment->questions->count() - 1)
                    <button type="button" onclick="nextQuestion()" class="px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl font-bold text-xs sm:text-sm text-white transition-all hover:scale-105 active:scale-95"
                            style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
                        Next
                        <svg class="w-3.5 h-3.5 sm:w-4 sm:h-4 inline ml-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                    </button>
                    @else
                    <button type="button" onclick="submitQuiz()" class="px-5 sm:px-6 py-2.5 sm:py-3 rounded-xl font-bold text-xs sm:text-sm text-white transition-all hover:scale-105 active:scale-95 pulse-glow"
                            style="background:linear-gradient(135deg,#D4A224,#b8891e);box-shadow:0 4px 16px rgba(212,162,36,0.3)">
                        🎯 Submit All
                    </button>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
    </form>

    {{-- Result Modal --}}
    <div id="result-modal" class="fixed inset-0 z-[999] flex items-center justify-center p-4 hidden" style="background:rgba(0,0,0,0.7);backdrop-filter:blur(8px)">
        <div class="w-full max-w-md rounded-3xl p-6 sm:p-8 text-center bounce-in" id="result-card" style="background:#141A16;border:2px solid rgba(78,153,102,0.3)">
            <div id="result-icon" class="text-5xl sm:text-6xl mb-4">🏆</div>
            <h2 id="result-title" class="font-display text-xl sm:text-2xl font-black text-cream mb-2">Great Job!</h2>
            <div class="my-4 sm:my-6">
                <div class="text-cream/50 text-xs sm:text-sm font-bold uppercase tracking-wider mb-1">Your Score</div>
                <div id="result-score" class="font-black text-4xl sm:text-5xl text-mint">0/0</div>
            </div>
            <div class="flex items-center justify-center gap-3 sm:gap-4 text-xs sm:text-sm text-cream/50 mb-4 sm:mb-6">
                <span>📊 <strong id="result-percent" class="text-cream/80">0%</strong></span>
                <span>⏱ <strong id="result-time" class="text-cream/80">0s</strong></span>
            </div>
            <div id="result-xp" class="text-gold font-bold text-sm sm:text-base mb-4 bounce-in hidden">+0 XP!</div>
            <div class="flex gap-3">
                <button onclick="closeResult()" class="flex-1 px-5 py-3 rounded-xl font-bold text-xs sm:text-sm border border-white/10 text-cream/70 hover:bg-white/5 transition-all">Review</button>
                <a href="{{ route('child.course', $enrollment->id ?? 0) }}" class="flex-1 px-5 py-3 rounded-xl font-bold text-xs sm:text-sm text-white transition-all hover:scale-105"
                   style="background:linear-gradient(135deg,#4E9966,#2a6e44)">📋 Back to Course</a>
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
                if (type === 'correct') {
                    [523,659,784].forEach((f,i)=>{const o=ctx.createOscillator(),g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.07;o.frequency.value=f;o.type='sine';g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+i*0.12+0.25);o.start(ctx.currentTime+i*0.12);o.stop(ctx.currentTime+i*0.12+0.25);});
                }
                if (type === 'wrong') {
                    [400,300].forEach((f,i)=>{const o=ctx.createOscillator(),g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.07;o.frequency.value=f;o.type='sawtooth';g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+i*0.15+0.2);o.start(ctx.currentTime+i*0.15);o.stop(ctx.currentTime+i*0.15+0.2);});
                }
                if (type === 'select') {
                    const o=ctx.createOscillator(),g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.05;o.frequency.value=600;o.type='sine';g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+0.1);o.start();o.stop(ctx.currentTime+0.1);
                }
                if (type === 'win') {
                    [523,587,659,784,880,1047].forEach((f,i)=>{const o=ctx.createOscillator(),g=ctx.createGain();o.connect(g);g.connect(ctx.destination);g.gain.value=0.06;o.frequency.value=f;o.type='sine';g.gain.exponentialRampToValueAtTime(0.001,ctx.currentTime+i*0.1+0.3);o.start(ctx.currentTime+i*0.1);o.stop(ctx.currentTime+i*0.1+0.3);});
                }
            } catch(e) {}
        }
    };

    // ── Confetti ──
    function spawnConfetti(count = 50) {
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

    // ── State ──
    const totalQuestions = {{ $assessment->questions->count() }};
    const correctAnswers = {
        @foreach($assessment->questions as $q)
        {{ $q->id }}: @if($q->type === 'multiple_choice' && is_array($q->options))"{{ addslashes($q->correct_answer) }}"@else"{{ addslashes($q->correct_answer) }}"@endif,
        @endforeach
    };
    let currentQuestion = 0;
    let answers = {};
    let timeLeft = {{ $assessment->time_limit ?? 0 }} * 60;
    let totalTime = {{ $assessment->time_limit ?? 0 }} * 60;
    let timerInterval = null;

    // ── Timer ──
    @if($assessment->time_limit)
    function startTimer() {
        const display = document.getElementById('timer-display');
        timerInterval = setInterval(() => {
            timeLeft--;
            const min = Math.floor(timeLeft / 60);
            const sec = timeLeft % 60;
            display.textContent = String(min).padStart(2, '0') + ':' + String(sec).padStart(2, '0');
            if (timeLeft <= 120) display.classList.add('text-terra');
            if (timeLeft <= 0) { clearInterval(timerInterval); submitQuiz(); }
        }, 1000);
    }
    startTimer();
    @endif

    // ── Navigation ──
    function showQuestion(index) {
        document.querySelectorAll('.question-slide').forEach(el => {
            el.classList.remove('active');
        });
        document.querySelector(`.question-slide[data-question="${index}"]`).classList.add('active');
        document.querySelectorAll('.progress-dot').forEach(d => d.classList.remove('active'));
        document.querySelector(`.progress-dot[data-question="${index}"]`)?.classList.add('active');
        document.getElementById('current-q-display').textContent = index + 1;
        currentQuestion = index;
        Sound.play('select');
    }

    function nextQuestion() {
        if (currentQuestion < totalQuestions - 1) showQuestion(currentQuestion + 1);
    }

    function prevQuestion() {
        if (currentQuestion > 0) showQuestion(currentQuestion - 1);
    }

    // ── Option Selection ──
    function selectOption(index, value, el) {
        const container = document.getElementById('options-' + index);
        const inputs = container.querySelectorAll('.option-btn');
        inputs.forEach(i => i.classList.remove('selected'));
        el.classList.add('selected');
        answers[index] = value;
        Sound.play('select');
        document.querySelector(`.progress-dot[data-question="${index}"]`).style.background = '#4E9966';

        // Auto advance
        setTimeout(() => { if (currentQuestion < totalQuestions - 1) nextQuestion(); }, 400);
    }

    // ── Submit ──
    function submitQuiz() {
        if (!confirm('Ready to submit your answers?')) return;
        
        let score = 0;
        let total = totalQuestions;
        let answered = Object.keys(answers).length;

        // Calculate score (client side for display - server re-evaluates)
        document.querySelectorAll('.question-slide').forEach((slide, idx) => {
            const dot = document.querySelector(`.progress-dot[data-question="${idx}"]`);
            const selected = answers[idx];
            const correct = correctAnswers[Object.keys(correctAnswers)[idx]];
            if (selected && selected.toLowerCase() === correct?.toLowerCase()) {
                score++;
                dot.classList.add('correct');
            } else if (selected) {
                dot.classList.add('wrong');
            } else {
                dot.classList.add('skipped');
            }
        });

        const percent = Math.round((score / total) * 100);
        const passed = percent >= {{ $assessment->passing_score ?? 50 }};
        const timeSpent = totalTime - timeLeft;

        // Show result modal
        const modal = document.getElementById('result-modal');
        const icon = document.getElementById('result-icon');
        const title = document.getElementById('result-title');
        const scoreEl = document.getElementById('result-score');
        const percentEl = document.getElementById('result-percent');
        const timeEl = document.getElementById('result-time');
        const xpEl = document.getElementById('result-xp');

        modal.classList.remove('hidden');
        
        if (passed) {
            icon.textContent = '🎉';
            title.textContent = 'Amazing Work! 🎉';
            scoreEl.style.color = '#4E9966';
            Sound.play('win');
            spawnConfetti(70);
        } else {
            icon.textContent = '💪';
            title.textContent = 'Keep Going! 💪';
            scoreEl.style.color = '#D4A224';
            Sound.play('wrong');
        }

        scoreEl.textContent = score + '/' + total;
        percentEl.textContent = percent + '%';
        timeEl.textContent = Math.floor(timeSpent / 60) + 'm ' + (timeSpent % 60) + 's';

        if (passed) {
            const xpAmount = score * 10;
            xpEl.textContent = '+' + xpAmount + ' XP Earned!';
            xpEl.classList.remove('hidden');
            setTimeout(() => xpEl.classList.add('bounce-in'), 500);
        }

        // Submit form data
        document.getElementById('answers-json').value = JSON.stringify(answers);
        document.getElementById('time-spent').value = timeSpent;

        setTimeout(() => {
            document.getElementById('assessment-form').submit();
        }, 3000);
    }

    function closeResult() {
        document.getElementById('result-modal').classList.add('hidden');
    }

    // ── Keyboard nav ──
    document.addEventListener('keydown', (e) => {
        if (e.key === 'ArrowRight' || e.key === ' ') nextQuestion();
        if (e.key === 'ArrowLeft') prevQuestion();
    });
</script>
@endpush
