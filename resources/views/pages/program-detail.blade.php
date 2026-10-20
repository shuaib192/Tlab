@extends('layouts.app')
@section('title', $program->name . ' — Growth Line | TLab')
@section('description', "Track the {{ $program->name }} growth line at TLab — {{ $program->growthStages->count() }} engineered age-band nodes from ages {{ $program->ages }}.")

@push('styles')
@include('partials.brand-styles')
@endpush

@section('content')

<div class="brand-page min-h-screen">

    @include('partials.nav')

    {{-- ═══ HERO ═══════════════════════════════════════════ --}}
    <header class="pt-40 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-5xl mx-auto">
            <a href="{{ route('programs') }}" class="inline-flex items-center gap-2 text-xs font-black uppercase tracking-widest mb-8" style="color:#0A7A6E">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M7 16l-4-4m0 0l4-4m-4 4h18"/></svg>
                All programmes
            </a>

            <span class="brand-chip mb-5">{{ $program->discipline }}</span>

            <h1 class="brand-title text-[clamp(2.5rem,7vw,5rem)]">{{ $program->name }}</h1>
            <p class="text-lg font-bold mt-4" style="color:#0DAA9C">{{ $program->tagline }}</p>
            <p class="mt-6 text-base sm:text-lg leading-relaxed max-w-3xl" style="color:#5B6B69">{{ $program->description }}</p>

            <div class="flex flex-wrap gap-3 mt-8">
                <span class="brand-pill">Ages {{ $program->ages }}</span>
                <span class="brand-pill">{{ $program->growthStages->count() }} growth nodes</span>
            </div>
        </div>
    </header>

    {{-- ═══ GROWTH LINE ════════════════════════════════════ --}}
    <section class="px-4 sm:px-6 lg:px-8 pb-24">
        <div class="max-w-5xl mx-auto">
            <div class="brand-kicker mb-10">The growth line</div>

            <div class="relative">
                <div class="absolute left-[19px] top-2 bottom-2 w-px" style="background:#DDE4E3"></div>

                <div class="space-y-8">
                    @forelse($program->growthStages as $stage)
                    <div class="relative flex gap-6">
                        <div class="relative z-10 flex-shrink-0">
                            <span class="brand-node on">{{ $loop->iteration }}</span>
                        </div>

                        <div class="brand-card p-7 sm:p-8 flex-1">
                            <div class="flex flex-wrap items-center gap-3 mb-4">
                                <span class="brand-chip">{{ $stage->age_band }}</span>
                                <span class="text-xs font-bold uppercase tracking-wider" style="color:#9AA8A6">{{ $stage->min_age }}–{{ $stage->max_age }} yrs</span>
                            </div>

                            <h2 class="brand-title text-xl sm:text-2xl mb-1">{{ $stage->stage_name }}</h2>
                            <div class="text-sm font-bold mb-5" style="color:#0A7A6E">{{ $stage->focus_title }}</div>

                            @if($stage->description)
                            <p class="text-sm leading-relaxed mb-6" style="color:#5B6B69">{{ $stage->description }}</p>
                            @endif

                            @if(is_array($stage->skills) && count($stage->skills))
                            <div class="mb-6">
                                <div class="text-[.68rem] font-black uppercase tracking-widest mb-3" style="color:#9AA8A6">Skills gained</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($stage->skills as $skill)
                                    <span class="brand-chip">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(is_array($stage->milestones) && count($stage->milestones))
                            <div class="mb-6">
                                <div class="text-[.68rem] font-black uppercase tracking-widest mb-3" style="color:#9AA8A6">Milestones</div>
                                <ul class="space-y-2">
                                    @foreach($stage->milestones as $ms)
                                    <li class="flex items-start gap-3 text-sm" style="color:#5B6B69">
                                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="#0DAA9C" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                                        {{ $ms }}
                                    </li>
                                    @endforeach
                                </ul>
                            </div>
                            @endif

                            @if(is_array($stage->tools_used) && count($stage->tools_used))
                            <div class="mb-6">
                                <div class="text-[.68rem] font-black uppercase tracking-widest mb-3" style="color:#9AA8A6">Tools used</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($stage->tools_used as $tool)
                                    <span class="brand-pill">{{ $tool }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($stage->featured_project)
                            <div class="rounded-xl p-5 mt-2" style="background:rgba(13,170,156,.07); border:1px dashed rgba(13,170,156,.4)">
                                <div class="text-[.68rem] font-black uppercase tracking-widest mb-2" style="color:#0A7A6E">Flagship project</div>
                                <div class="font-black" style="color:#0F201E">{{ $stage->featured_project }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                    @empty
                    <div class="brand-card p-16 text-center">
                        <p class="font-bold mb-6" style="color:#5B6B69">This programme's stages are being finalised.</p>
                        <a href="{{ route('programs') }}" class="brand-btn">Back to programmes</a>
                    </div>
                    @endforelse
                </div>
            </div>
        </div>
    </section>

    {{-- ═══ CAREER PATHS ═══════════════════════════════════ --}}
    @if(is_array($program->career_paths) && count($program->career_paths))
    <section class="px-4 sm:px-6 lg:px-8 pb-24">
        <div class="max-w-7xl mx-auto">
            <div class="brand-kicker mb-10">Where this leads</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
                @foreach($program->career_paths as $idx => $career)
                <div class="brand-card p-7">
                    <div class="text-xs font-black uppercase tracking-widest mb-3" style="color:#9AA8A6">Path {{ sprintf('%02d', $idx + 1) }}</div>
                    <div class="brand-title text-lg">{{ $career }}</div>
                </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ LEARN & OUTCOMES ═══════════════════════════════ --}}
    @if((is_array($program->what_learn) && count($program->what_learn)) || (is_array($program->outcomes) && count($program->outcomes)))
    <section class="px-4 sm:px-6 lg:px-8 pb-24">
        <div class="max-w-7xl mx-auto grid grid-cols-1 lg:grid-cols-2 gap-8">
            @if(is_array($program->what_learn) && count($program->what_learn))
            <div class="brand-card p-8">
                <div class="brand-kicker mb-7">What they learn</div>
                <div class="flex flex-wrap gap-2.5">
                    @foreach($program->what_learn as $item)
                    <span class="brand-chip">{{ $item }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if(is_array($program->outcomes) && count($program->outcomes))
            <div class="brand-card p-8">
                <div class="brand-kicker mb-7">Outcomes</div>
                <ul class="space-y-3">
                    @foreach($program->outcomes as $outcome)
                    <li class="flex items-start gap-3 text-sm" style="color:#5B6B69">
                        <svg class="w-4 h-4 flex-shrink-0 mt-0.5" fill="none" stroke="#0DAA9C" stroke-width="3" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" d="M5 13l4 4L19 7"/></svg>
                        {{ $outcome }}
                    </li>
                    @endforeach
                </ul>
            </div>
            @endif
        </div>
    </section>
    @endif

    {{-- ═══ SIBLINGS ═══════════════════════════════════════ --}}
    @if($siblings->count())
    <section class="px-4 sm:px-6 lg:px-8 pb-24">
        <div class="max-w-7xl mx-auto">
            <div class="brand-kicker mb-10">Explore other programmes</div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
                @foreach($siblings as $sib)
                <a href="{{ route('programs.show', $sib->slug) }}" class="brand-card p-6 flex items-center gap-4">
                    <span class="brand-node">{{ $loop->iteration }}</span>
                    <span class="min-w-0">
                        <span class="block font-black truncate" style="color:#0F201E">{{ $sib->name }}</span>
                        <span class="block text-xs font-bold uppercase tracking-wider" style="color:#9AA8A6">Ages {{ $sib->ages }}</span>
                    </span>
                    <svg class="w-4 h-4 ml-auto flex-shrink-0" fill="none" stroke="#0DAA9C" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </a>
                @endforeach
            </div>
        </div>
    </section>
    @endif

    {{-- ═══ CTA ════════════════════════════════════════════ --}}
    <section class="px-4 sm:px-6 lg:px-8 pb-32">
        <div class="max-w-4xl mx-auto brand-card p-12 text-center" style="background:#0F201E; border-color:#0F201E;">
            <div class="text-[.7rem] font-black tracking-[.24em] uppercase mb-4" style="color:#5BEBDB">Get started</div>
            <h2 class="text-3xl sm:text-4xl font-black text-white mb-8 leading-tight">
                Enrol your child on the {{ $program->name }} line.
            </h2>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('register') }}" class="brand-btn" style="background:#0DAA9C; border-color:#0DAA9C;">Create an account</a>
                <a href="{{ route('contact') }}" class="brand-btn soft">Ask a question</a>
            </div>
        </div>
    </section>
</div>

@include('partials.footer')

@endsection
