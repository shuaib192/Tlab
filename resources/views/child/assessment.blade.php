@extends('layouts.app')

@section('title', $assessment->title . ' — Assessment')

@push('styles')
<style>
    .glass { background:rgba(250,245,232,0.03); border:1px solid rgba(250,245,232,0.07); }
    .question-card { transition:all 0.2s; }
    .question-card:hover { border-color:rgba(78,153,102,0.2); }
    .option-label { cursor:pointer; transition:all 0.15s; }
    .option-label:hover { border-color:rgba(78,153,102,0.3); background:rgba(78,153,102,0.05); }
    .option-label.selected { border-color:#4E9966; background:rgba(78,153,102,0.1); }
    .option-input:checked + .option-label { border-color:#4E9966; background:rgba(78,153,102,0.1); }
    .timer { font-variant-numeric:tabular-nums; }
    .chip { display:inline-flex; align-items:center; padding:4px 10px; border-radius:99px; font-weight:700; font-size:0.7rem; letter-spacing:0.02em; }
</style>
@endpush

@section('content')

<nav class="sticky top-0 z-50 px-8 py-5 flex justify-between items-center glass border-b border-white/5">
    <div class="flex items-center gap-4">
        <a href="{{ route('child.lesson', $lesson->id) }}" class="w-10 h-10 rounded-xl flex items-center justify-center font-display text-xl font-black italic text-white"
           style="background:linear-gradient(135deg,#4E9966,#2a6e44)">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        </a>
        <div>
            <div class="font-display text-lg font-bold">{{ $assessment->title ?? 'Assessment' }}</div>
            <div class="text-xs text-cream/60 font-bold">{{ $course->title }}</div>
        </div>
    </div>
    <div class="flex items-center gap-4">
        <div class="text-sm text-cream/50">
            <span class="text-cream/40">Questions:</span>
            <span class="font-bold text-cream/80">{{ $assessment->questions->count() }}</span>
        </div>
        @if($assessment->time_limit)
        <div class="flex items-center gap-2 text-sm" id="timer">
            <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            <span class="font-bold timer text-gold" id="timer-display">{{ $assessment->time_limit }}:00</span>
        </div>
        @endif
    </div>
</nav>

<main class="max-w-3xl mx-auto px-8 py-10">

    @if($existingAttempt && $existingAttempt->status === 'passed')
    <div class="mb-8 rounded-3xl p-6 bg-mint/10 border border-mint/30">
        <div class="flex items-center gap-4">
            <div class="text-4xl">🎉</div>
            <div>
                <div class="font-display text-xl font-bold text-mint">You Passed!</div>
                <div class="text-cream/70 text-sm mt-1">
                    Score: <span class="font-bold">{{ $existingAttempt->score }}/{{ $existingAttempt->total }}</span>
                    &middot; You can retake to improve your score.
                </div>
            </div>
        </div>
    </div>
    @elseif($existingAttempt)
    <div class="mb-8 rounded-3xl p-6 bg-terra/10 border border-terra/30">
        <div class="flex items-center gap-4">
            <div class="text-4xl">💪</div>
            <div>
                <div class="font-display text-xl font-bold text-terra">Previous Attempt</div>
                <div class="text-cream/70 text-sm mt-1">
                    Score: <span class="font-bold">{{ $existingAttempt->score }}/{{ $existingAttempt->total }}</span>
                    &middot; Try again to pass!
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Assessment Header --}}
    <div class="rounded-3xl p-8 mb-8 relative overflow-hidden bg-gradient-to-br from-gold/20 to-transparent"
         style="border:1px solid rgba(212,162,36,0.3)">
        <div class="absolute -right-10 -top-10 w-64 h-64 rounded-full blur-3xl opacity-20" style="background:#D4A224"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 text-xs font-bold uppercase tracking-widest text-gold mb-2">📝 Assessment</div>
            <h1 class="font-display text-2xl md:text-3xl font-black mb-3">{{ $assessment->title ?? 'Knowledge Check' }}</h1>
            <p class="text-cream/60 max-w-2xl">{{ $assessment->description ?? 'Answer the questions below to test your understanding.' }}</p>
            <div class="flex items-center gap-6 mt-4 text-sm text-cream/50">
                <span>{{ $assessment->questions->count() }} Questions</span>
                @if($assessment->passing_score)
                <span>Pass: <strong class="text-gold">{{ $assessment->passing_score }}</strong></span>
                @endif
                @if($assessment->time_limit)
                <span>Time: <strong class="text-gold">{{ $assessment->time_limit }} min</strong></span>
                @endif
            </div>
        </div>
    </div>

    {{-- Questions Form --}}
    <form method="POST" action="{{ route('child.assessment.submit', $assessment->id) }}" id="assessment-form">
        @csrf
        <div class="space-y-6">
            @foreach($assessment->questions as $index => $question)
            <div class="question-card glass rounded-2xl p-6">
                <div class="flex items-start gap-4">
                    <div class="w-8 h-8 rounded-xl flex items-center justify-center font-display font-bold text-sm flex-shrink-0"
                         style="background:rgba(212,162,36,0.12);color:#D4A224">
                        {{ $index + 1 }}
                    </div>
                    <div class="flex-1">
                        <p class="font-bold text-cream mb-4">{{ $question->question }}</p>

                        @if($question->type === 'multiple_choice' && is_array($question->options))
                        <div class="space-y-3">
                            @foreach($question->options as $option)
                            <label class="flex items-center gap-3 p-4 rounded-xl border border-white/10 option-label">
                                <input type="radio" name="answers[{{ $question->id }}]" value="{{ $option }}"
                                       class="option-input w-4 h-4 accent-mint" required>
                                <span class="text-sm text-cream/80">{{ $option }}</span>
                            </label>
                            @endforeach
                        </div>
                        @elseif($question->type === 'text')
                        <textarea name="answers[{{ $question->id }}]" rows="3"
                                  class="w-full p-4 rounded-xl text-sm bg-white/5 border border-white/10 text-cream placeholder:text-cream/30 focus:outline-none focus:border-mint/50 transition-all"
                                  placeholder="Type your answer here..." required></textarea>
                        @else
                        <input type="text" name="answers[{{ $question->id }}]"
                               class="w-full p-4 rounded-xl text-sm bg-white/5 border border-white/10 text-cream placeholder:text-cream/30 focus:outline-none focus:border-mint/50 transition-all"
                               placeholder="Your answer" required>
                        @endif

                        @error("answers.{$question->id}")
                        <p class="text-terra text-xs mt-2">{{ $message }}</p>
                        @enderror
                    </div>
                </div>
            </div>
            @endforeach
        </div>

        <div class="mt-8 flex items-center justify-between p-6 glass rounded-2xl sticky bottom-6">
            <div class="text-sm text-cream/50">
                <span class="font-bold text-cream/80">{{ $assessment->questions->count() }}</span> questions to answer
            </div>
            <button type="submit"
                    class="inline-flex items-center gap-2 px-8 py-4 rounded-xl font-bold text-sm text-white transition-all"
                    style="background:linear-gradient(135deg,#D4A224,#b8891e);box-shadow:0 4px 16px rgba(212,162,36,0.3)">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Submit Answers
            </button>
        </div>
    </form>

</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        @if($assessment->time_limit)
        const totalMinutes = {{ $assessment->time_limit }};
        let timeLeft = totalMinutes * 60;
        const display = document.getElementById('timer-display');

        const timerInterval = setInterval(() => {
            timeLeft--;
            const min = Math.floor(timeLeft / 60);
            const sec = timeLeft % 60;
            display.textContent = String(min).padStart(2, '0') + ':' + String(sec).padStart(2, '0');

            if (timeLeft <= 120) {
                display.classList.add('text-terra');
            }

            if (timeLeft <= 0) {
                clearInterval(timerInterval);
                document.getElementById('assessment-form').submit();
            }
        }, 1000);
        @endif

        // Visual selection for radio options
        document.querySelectorAll('.option-input').forEach(input => {
            input.addEventListener('change', () => {
                const name = input.getAttribute('name');
                document.querySelectorAll(`input[name="${name}"]`).forEach(radio => {
                    radio.closest('.option-label').classList.remove('selected');
                });
                if (input.checked) {
                    input.closest('.option-label').classList.add('selected');
                }
            });
        });
    });
</script>
@endpush
