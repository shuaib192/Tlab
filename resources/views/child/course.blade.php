@extends('layouts.app')

@section('title', $course->title . ' — Course')

@push('styles')
<style>
    .glass { background:rgba(250,245,232,0.03); border:1px solid rgba(250,245,232,0.07); }
    .xp-bar { height:8px; border-radius:99px; background:rgba(250,245,232,0.08); overflow:hidden; }
    .xp-fill { height:100%; border-radius:99px; transition:width 1.2s cubic-bezier(.34,1.56,.64,1); }
    .lesson-link { transition:all 0.15s; }
    .lesson-link:hover { background:rgba(250,245,232,0.06); }
    .module-header { cursor:pointer; user-select:none; }
    .module-body { overflow:hidden; transition:max-height 0.35s ease, opacity 0.25s ease; }
    .module-body.collapsed { max-height:0 !important; opacity:0; }
    .chip { display:inline-flex; align-items:center; padding:4px 10px; border-radius:99px; font-weight:700; font-size:0.7rem; letter-spacing:0.02em; }
    .accordion-arrow { transition:transform 0.3s ease; }
    .accordion-arrow.open { transform:rotate(180deg); }
</style>
@endpush

@section('content')

<nav class="sticky top-0 z-50 px-8 py-5 flex justify-between items-center glass border-b border-white/5">
    <div class="flex items-center gap-4">
        <a href="{{ route('child.dashboard') }}" class="flex-shrink-0">
            <img src="/images/tlab-logo-white.png" alt="TLab" class="h-8 w-auto">
        </a>
        <div>
            <div class="font-display text-lg font-bold">{{ $course->title }}</div>
            <div class="text-xs text-cream/60 font-bold">{{ $course->club->name ?? 'Course' }}</div>
        </div>
    </div>
    <a href="{{ route('child.dashboard') }}"
       class="flex items-center gap-2 px-4 py-2.5 rounded-xl glass text-cream/60 text-sm font-bold hover:text-cream transition-all">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Dashboard
    </a>
</nav>

<main class="max-w-5xl mx-auto px-8 py-10">

    @if(session('assessment_result'))
    @php $ar = session('assessment_result'); @endphp
    <div class="mb-8 rounded-3xl p-6 {{ $ar['status'] === 'passed' ? 'bg-mint/10 border border-mint/30' : 'bg-terra/10 border border-terra/30' }}">
        <div class="flex items-center gap-4">
            <div class="text-4xl">{{ $ar['status'] === 'passed' ? '🎉' : '💪' }}</div>
            <div class="flex-1">
                <div class="font-display text-xl font-bold {{ $ar['status'] === 'passed' ? 'text-mint' : 'text-terra' }}">
                    {{ $ar['status'] === 'passed' ? 'Assessment Passed!' : 'Keep Trying!' }}
                </div>
                <div class="text-cream/70 text-sm mt-1">
                    Score: <span class="font-bold">{{ $ar['score'] }}/{{ $ar['total'] }}</span>
                    &middot; Passing: {{ $ar['passing_score'] }}
                </div>
            </div>
        </div>
    </div>
    @endif

    {{-- Hero --}}
    <div class="rounded-3xl p-8 mb-8 relative overflow-hidden bg-gradient-to-br from-mint/20 to-transparent"
         style="border:1px solid rgba(78,153,102,0.3)">
        <div class="absolute -right-10 -top-10 w-64 h-64 rounded-full blur-3xl opacity-20" style="background:#4E9966"></div>
        <div class="relative z-10">
            <div class="flex items-center gap-2 text-cream/50 text-sm font-bold uppercase tracking-widest mb-2">
                <span>{{ $course->club->name ?? 'Course' }}</span>
                <span class="text-cream/30">/</span>
                <span class="text-mint">{{ $course->level ?? 'All Levels' }}</span>
            </div>
            <h1 class="font-display text-3xl md:text-4xl font-black mb-3">{{ $course->title }}</h1>
            <p class="text-cream/60 max-w-2xl mb-6">{{ $course->description }}</p>

            <div class="flex flex-wrap items-center gap-6">
                <div class="flex-1 min-w-[200px]">
                    <div class="flex justify-between text-sm mb-2">
                        <span class="text-cream/70 font-bold">{{ $completedLessons }}/{{ $totalLessons }} lessons</span>
                        <span class="text-mint font-bold">{{ $progress }}%</span>
                    </div>
                    <div class="xp-bar">
                        <div class="xp-fill" id="progress-bar" data-progress="{{ $progress }}" style="width:0%;background:linear-gradient(90deg,#4E9966,#2a6e44)"></div>
                    </div>
                </div>
                <div class="flex items-center gap-4 text-sm">
                    <div class="text-center px-4">
                        <div class="font-display text-2xl font-black text-mint">{{ $totalLessons }}</div>
                        <div class="text-cream/40 text-xs font-bold">Lessons</div>
                    </div>
                    <div class="text-center px-4">
                        <div class="font-display text-2xl font-black text-gold">{{ $completedLessons }}</div>
                        <div class="text-cream/40 text-xs font-bold">Completed</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Modules Accordion --}}
    <div class="space-y-4">
        @forelse($moduleData as $index => $module)
        <div class="glass rounded-2xl overflow-hidden">
            <div class="module-header flex items-center justify-between p-5" onclick="toggleModule({{ $index }})">
                <div class="flex items-center gap-4">
                    <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg font-bold"
                         style="background:rgba(78,153,102,0.15);color:#4E9966">
                        {{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}
                    </div>
                    <div>
                        <h3 class="font-display text-lg font-bold">{{ $module->title }}</h3>
                        @if($module->description)
                        <p class="text-cream/50 text-sm">{{ $module->description }}</p>
                        @endif
                    </div>
                </div>
                <div class="flex items-center gap-3">
                    <span class="text-cream/40 text-xs font-bold">{{ collect($module->lessons)->where('completed', true)->count() }}/{{ count($module->lessons) }}</span>
                    <svg class="accordion-arrow w-5 h-5 text-cream/40 {{ $index === 0 ? 'open' : '' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                    </svg>
                </div>
            </div>
            <div class="module-body {{ $index !== 0 ? 'collapsed' : '' }}" id="module-body-{{ $index }}">
                <div class="px-5 pb-5 space-y-2">
                    @forelse($module->lessons as $lesson)
                    <a href="{{ route('child.lesson', $lesson->id) }}" class="lesson-link flex items-center gap-4 p-4 rounded-xl bg-white/5">
                        <div class="w-9 h-9 rounded-lg flex items-center justify-center flex-shrink-0"
                             style="background:{{ $lesson->completed ? 'rgba(78,153,102,0.15)' : 'rgba(250,245,232,0.05)' }};color:{{ $lesson->completed ? '#4E9966' : 'rgba(250,245,232,0.4)' }}">
                            @if($lesson->completed)
                            <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @else
                            <span class="text-xs font-bold">{{ $lesson->sort_order }}</span>
                            @endif
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm {{ $lesson->completed ? 'text-mint' : 'text-cream' }}">{{ $lesson->title }}</div>
                            <div class="flex items-center gap-3 text-xs text-cream/40 mt-1">
                                @if($lesson->type === 'video')
                                <span>🎬 Video</span>
                                @elseif($lesson->type === 'text')
                                <span>📖 Text</span>
                                @elseif($lesson->type === 'quiz' || $lesson->has_assessment)
                                <span>📝 Quiz</span>
                                @else
                                <span>📖 {{ ucfirst($lesson->type) }}</span>
                                @endif
                                @if($lesson->duration)
                                <span>⏱ {{ $lesson->duration }} min</span>
                                @endif
                            </div>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($lesson->completed)
                            <span class="chip" style="background:rgba(78,153,102,0.15);color:#4E9966">Done</span>
                            @else
                            <span class="px-4 py-2 rounded-xl font-bold text-xs text-cream/70"
                                  style="background:rgba(78,153,102,0.15);color:#4E9966">Start</span>
                            @endif
                        </div>
                    </a>
                    @empty
                    <p class="text-cream/30 text-sm text-center py-6">No lessons in this module yet.</p>
                    @endforelse
                </div>
            </div>
        </div>
        @empty
        <div class="glass rounded-2xl p-12 text-center">
            <div class="text-5xl mb-4">📚</div>
            <p class="text-cream/50">No modules have been added to this course yet.</p>
        </div>
        @endforelse
    </div>

</main>

@endsection

@push('scripts')
<script>
    document.addEventListener('DOMContentLoaded', () => {
        const bar = document.getElementById('progress-bar');
        if (bar) {
            const p = bar.dataset.progress;
            setTimeout(() => { bar.style.width = p + '%'; }, 400);
        }
    });

    function toggleModule(index) {
        const body = document.getElementById('module-body-' + index);
        const arrow = body.previousElementSibling.querySelector('.accordion-arrow');
        if (body.classList.contains('collapsed')) {
            body.classList.remove('collapsed');
            arrow.classList.add('open');
        } else {
            body.classList.add('collapsed');
            arrow.classList.remove('open');
        }
    }

    // Open first module by default
    document.addEventListener('DOMContentLoaded', () => {
        const first = document.getElementById('module-body-0');
        if (first) first.classList.remove('collapsed');
    });
</script>
@endpush
