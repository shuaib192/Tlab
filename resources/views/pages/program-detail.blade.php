@extends('layouts.app')
@section('title', $program->name . ' — Growth Line | TLab')
@section('description', "Track the {{ $program->name }} growth line at TLab — {{ $program->growthStages->count() }} engineered age-band nodes from ages {{ $program->ages }}.")

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Space+Mono:wght@400;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<style>
    .steam-page {
        background:#05070d; color:#e8eef7;
        font-family:'Space Grotesk',sans-serif;
        overflow-x:hidden; position:relative;
    }
    .steam-page::after {
        content:''; position:fixed; inset:0; pointer-events:none; z-index:5;
        background:repeating-linear-gradient(0deg, rgba(255,255,255,0.022) 0 1px, transparent 1px 3px);
        mix-blend-mode:overlay;
    }
    .scanline { position:absolute; left:0; right:0; height:120px; z-index:4; background:linear-gradient(180deg, transparent, rgba(255,255,255,0.045), transparent); animation:scan 7s linear infinite; pointer-events:none; }
    @keyframes scan { 0%{top:-15%} 100%{top:110%} }
    .g-display { font-family:'Archivo Black',sans-serif; line-height:0.95; letter-spacing:-0.01em; }
    .g-mono { font-family:'Space Mono',monospace; }
    .brite { text-shadow:0 0 24px var(--c); }
    .hardbtn {
        display:inline-flex; align-items:center; gap:10px; border:2px solid #000; border-radius:10px;
        box-shadow:5px 5px 0 #000; font-family:'Space Mono',monospace; font-weight:700; font-size:11px;
        letter-spacing:0.18em; text-transform:uppercase; padding:14px 22px; color:#05070d;
        background:var(--c,#00FF88); transition:transform .12s ease, box-shadow .12s ease;
    }
    .hardbtn:hover { transform:translate(4px,4px); box-shadow:1px 1px 0 #000; }
    .node-card {
        position:relative; background:#0a0e16; border:2px solid var(--c,#00FF88);
        border-radius:18px; box-shadow:7px 7px 0 rgba(0,0,0,0.85);
        overflow:hidden;
    }
    .node-card .corner { position:absolute; width:22px; height:22px; background:var(--c); }
    .node-card .corner.tl { top:0; left:0; border-radius:0 0 18px 0; }
    .node-card .corner.br { bottom:0; right:0; border-radius:18px 0 0 0; }
    .agepill {
        display:inline-flex; align-items:center; gap:6px; padding:4px 14px; border-radius:999px;
        border:1px dashed var(--c,#00FF88); color:var(--c,#00FF88);
        font-family:'Space Mono',monospace; font-size:10px; letter-spacing:0.14em; text-transform:uppercase;
        background:rgba(255,255,255,0.02);
    }
    .chipx {
        display:inline-flex; align-items:center; gap:6px; padding:6px 12px; border-radius:999px;
        border:1px solid rgba(255,255,255,0.14); background:rgba(255,255,255,0.04);
        font-family:'Space Mono',monospace; font-size:10.5px; color:#cbd5e1;
    }
    .chipx::before { content:'<>'; color:var(--c,#00FF88); font-weight:700; }
    .milestone { display:flex; gap:12px; align-items:flex-start; padding:7px 0; border-bottom:1px dashed rgba(255,255,255,0.07); }
    .milestone::before { content:'✓'; font-family:'Space Mono',monospace; color:var(--c,#00FF88); font-weight:700; flex-shrink:0; margin-top:1px; }
    .flagproj {
        border:2px dashed var(--c,#00FF88); border-radius:14px; padding:18px;
        background:linear-gradient(135deg, rgba(255,255,255,0.03), rgba(255,255,255,0.01));
    }
    .flagproj span.label {
        display:inline-flex; align-items:center; gap:8px; margin-bottom:8px;
        font-family:'Space Mono',monospace; font-size:9.5px; letter-spacing:0.28em; text-transform:uppercase; color:var(--c,#00FF88);
    }
    .flagproj .flag-nm { font-family:'Archivo Black',sans-serif; text-transform:uppercase; font-size:1.05rem; color:#fff; line-height:1.2; }
    .conduit-line { width:3px; background:var(--c,#00FF88); box-shadow:0 0 18px var(--c,#00FF88); opacity:.55; }
    .sib-link {
        display:flex; align-items:center; gap:14px; padding:14px 18px; border-radius:14px;
        border:1px solid rgba(255,255,255,0.12); background:rgba(255,255,255,0.03);
        transition:transform .15s ease, border-color .15s ease;
    }
    .sib-link:hover { transform:translateY(-3px); border-color:var(--c,#00FF88); }
    .blinker::after { content:'▌'; animation:blink 1.1s steps(1) infinite; }
    @keyframes blink { 50%{opacity:0} }
    .seclead { font-size:0.72rem; letter-spacing:0.34em; text-transform:uppercase; font-family:'Space Mono',monospace; }
</style>
@endpush

@section('content')

@php $c = $program->color; @endphp

<div class="steam-page min-h-screen relative" style="--c:{{ $c }};">
    <div class="scanline"></div>

    @include('partials.nav')

    {{-- ═══ SPECIMEN HERO ═════════════════════════════════ --}}
    <header class="relative pt-44 pb-24 px-4 sm:px-6 lg:px-8">
        <div class="absolute inset-x-0 top-0 h-full pointer-events-none" style="background:radial-gradient(ellipse at 20% 0%, {{ $c }}1f 0%, transparent 55%);"></div>
        <div class="max-w-7xl mx-auto relative z-10">
            <div class="g-mono text-[11px] tracking-[0.3em] uppercase flex flex-wrap items-center gap-3 mb-8">
                <a href="{{ route('programs') }}" class="text-white/40 hover:text-white transition-colors">&larr; GROWTH LINE MAP</a>
                <span class="text-white/20">/</span>
                <span style="color:{{ $c }}" class="brite">DISCIPLINE {{ sprintf('%02d', $program->sort_order) }} — {{ strtoupper($program->discipline) }}</span>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end">
                <div class="lg:col-span-8">
                    <h1 class="g-display text-[clamp(3.5rem,10vw,8rem)] uppercase brite mb-3" style="color:{{ $c }};">{{ $program->name }}</h1>
                    <p class="g-mono text-sm sm:text-base text-white/60 italic mb-8" style="box-decoration-break:clone;">
                        // {{ $program->tagline }}
                    </p>
                    <p class="text-white/70 text-base sm:text-lg leading-relaxed max-w-3xl">{{ $program->description }}</p>
                </div>
                <div class="lg:col-span-4 lg:text-right flex lg:justify-end gap-3 flex-wrap">
                    <span class="agepill" style="--c:{{ $c }};">Ages {{ $program->ages }}</span>
                    <span class="agepill" style="--c:{{ $c }};">{{ $program->growthStages->count() }} Nodes</span>
                    <span class="agepill" style="--c:{{ $c }};">STATUS: LIVE</span>
                </div>
            </div>
        </div>
    </header>

    {{-- ═══ GROWTH LINE CONDUIT ═══════════════════════════ --}}
    <section class="relative px-4 sm:px-6 lg:px-8 max-w-5xl mx-auto pb-28">
        <div class="flex items-center gap-6 mb-14">
            <span class="seclead brite" style="color:{{ $c }};">// GROWTH LINE — LIVE CONDUIT</span>
            <div class="flex-1 h-px" style="background:linear-gradient(90deg, {{ $c }}aa, transparent);"></div>
        </div>

        <div class="relative">
            {{-- Vertical luminous spine --}}
            <div class="absolute left-5 lg:left-1/2 top-0 bottom-0 w-[3px] -translate-x-1/2" style="background:linear-gradient(180deg,{{ $c }},{{ $c }}44); box-shadow:0 0 24px {{ $c }}88;"></div>

            <div class="space-y-20">
                @forelse($program->growthStages as $stage)
                @php $side = $loop->even ? 'lg:flex-row' : 'lg:flex-row-reverse'; @endphp
                <div class="relative flex flex-col {{ $side }} items-start lg:items-center gap-8 lg:gap-0">
                    {{-- Node hub --}}
                    <div class="relative z-10 lg:absolute lg:left-1/2 lg:-translate-x-1/2 flex flex-col items-center gap-2">
                        <span class="w-10 h-10 rounded-full border-2 grid place-items-center g-mono font-bold text-sm"
                              style="background:#05070d; border-color:{{ $c }}; color:{{ $c }}; box-shadow:0 0 26px {{ $c }}aa;">
                            {{ $loop->iteration }}
                        </span>
                        <span class="lg:hidden g-mono text-[9px] tracking-[0.2em] uppercase" style="color:{{ $c }};">{{ $stage->age_band }}</span>
                    </div>

                    {{-- Stage card (offsets alternate on lg) --}}
                    <div class="lg:w-[calc(50%-60px)] {{ $loop->even ? 'lg:mr-auto lg:pr-6' : 'lg:ml-auto lg:pl-6' }} w-full">
                        <div class="node-card p-7 sm:p-9" style="--c:{{ $c }};">
                            <span class="corner tl"></span>
                            <span class="corner br"></span>

                            <div class="flex flex-wrap items-center gap-3 mb-5">
                                <span class="agepill" style="--c:{{ $c }};">{{ $stage->age_band }}</span>
                                <span class="g-mono text-[10px] tracking-[0.24em] uppercase text-white/35">NODE 0{{ $loop->iteration }} · {{ $stage->min_age }}–{{ $stage->max_age }} yrs</span>
                            </div>

                            <h2 class="g-display text-2xl sm:text-3xl uppercase text-white mb-1">
                                <span style="color:{{ $c }};" class="brite">{{ $stage->stage_name }}</span>
                            </h2>
                            <div class="g-mono text-xs text-white/50 mb-6 tracking-wide">{{ $stage->focus_title }}</div>

                            @if($stage->description)
                            <p class="text-sm text-white/70 leading-relaxed mb-8">{{ $stage->description }}</p>
                            @endif

                            @if(is_array($stage->skills) && count($stage->skills))
                            <div class="mb-8">
                                <div class="g-mono text-[10px] tracking-[0.3em] uppercase text-white/40 mb-3">++ Abilities Gained</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($stage->skills as $skill)
                                    <span class="chipx" style="--c:{{ $c }};">{{ $skill }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if(is_array($stage->milestones) && count($stage->milestones))
                            <div class="mb-8">
                                <div class="g-mono text-[10px] tracking-[0.3em] uppercase text-white/40 mb-3">== Milestone Unlock Log</div>
                                @foreach($stage->milestones as $ms)
                                <div class="milestone text-sm text-white/70">{{ $ms }}</div>
                                @endforeach
                            </div>
                            @endif

                            @if(is_array($stage->tools_used) && count($stage->tools_used))
                            <div class="mb-8">
                                <div class="g-mono text-[10px] tracking-[0.3em] uppercase text-white/40 mb-3">// Instrument Rack</div>
                                <div class="flex flex-wrap gap-2">
                                    @foreach($stage->tools_used as $tool)
                                    <span class="chipx" style="--c:{{ $c }};">{{ $tool }}</span>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            @if($stage->featured_project)
                            <div class="flagproj" style="--c:{{ $c }};">
                                <span class="label">◆ Flagship Build / Showcase</span>
                                <div class="flag-nm">{{ $stage->featured_project }}</div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
                @empty
                <div class="text-center py-24 border-2 border-dashed border-white/15 rounded-2xl">
                    <p class="g-mono text-sm text-white/40 mb-6">// CONDUIT EMPTY — NO GROWTH NODES //</p>
                    <a href="{{ route('programs') }}" class="hardbtn" style="--c:{{ $c }};">Back to Map</a>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══ CAREER TRAJECTORIES ═══════════════════════════ --}}
    @if(is_array($program->career_paths) && count($program->career_paths))
    <section class="relative px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-28">
        <div class="flex items-center gap-6 mb-12">
            <span class="seclead brite" style="color:{{ $c }};">// END-GAME TRAJECTORIES</span>
            <div class="flex-1 h-px" style="background:linear-gradient(90deg, {{ $c }}aa, transparent);"></div>
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
            @foreach($program->career_paths as $idx => $career)
            <div class="relative bg-[#0a0e16] border rounded-2xl p-7" style="border-color:{{ $c }}44; box-shadow:5px 5px 0 rgba(0,0,0,0.6);">
                <span class="g-display text-5xl text-white/5 absolute right-5 top-4 select-none">{{ sprintf('%02d', $idx + 1) }}</span>
                <div class="g-mono text-[10px] tracking-[0.3em] uppercase mb-3" style="color:{{ $c }};">ROLE 0{{ $idx + 1 }}</div>
                <div class="g-display text-xl uppercase text-white">{{ $career }}</div>
                <div class="mt-5 h-1.5 rounded-full bg-white/10">
                    <div class="h-1.5 rounded-full" style="width:{{ 100 - $idx * 15 }}%; background:{{ $c }}; box-shadow:0 0 12px {{ $c }};"></div>
                </div>
            </div>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ WHAT THEY LEARN & OUTCOMES ════════════════════ --}}
    <section class="relative px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-28">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-10">
            @if(is_array($program->what_learn) && count($program->what_learn))
            <div class="relative bg-[#0a0e16] border-2 rounded-2xl p-8" style="border-color:{{ $c }}55; --c:{{ $c }};">
                <div class="g-mono text-[10px] tracking-[0.3em] uppercase mb-8 brite" style="color:{{ $c }};">// SKILLSPHERE :: CORE LOADOUT</div>
                <div class="flex flex-wrap gap-2.5">
                    @foreach($program->what_learn as $item)
                    <span class="chipx" style="--c:{{ $c }}; padding:9px 14px;">{{ $item }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            @if(is_array($program->outcomes) && count($program->outcomes))
            <div class="relative bg-[#0a0e16] border-2 rounded-2xl p-8" style="border-color:{{ $c }}55; --c:{{ $c }};">
                <div class="g-mono text-[10px] tracking-[0.3em] uppercase mb-8 brite" style="color:{{ $c }};">// CERTIFIED EXODUS STATISTICS</div>
                <div>
                    @foreach($program->outcomes as $outcome)
                    <div class="milestone text-sm text-white/70" style="--c:{{ $c }};">{{ $outcome }}</div>
                    @endforeach
                </div>
            </div>
            @endif
        </div>
    </section>

    {{-- ═══ SIBLING DISCIPLINES ═══════════════════════════ --}}
    @if($siblings->count())
    <section class="relative px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-28">
        <div class="flex items-center gap-6 mb-12">
            <span class="seclead text-white/40">// NEIGHBORING CONDUITS</span>
            <div class="flex-1 h-px bg-white/10"></div>
        </div>
        <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
            @foreach($siblings as $sib)
            <a href="{{ route('programs.show', $sib->slug) }}" class="sib-link" style="--c:{{ $sib->color }};">
                <span class="w-9 h-9 rounded-full border-2 grid place-items-center font-mono text-xs font-bold flex-shrink-0"
                      style="border-color:{{ $sib->color }}; color:{{ $sib->color }}; box-shadow:0 0 18px -4px {{ $sib->color }};">
                    {{ $loop->iteration }}
                </span>
                <span class="min-w-0">
                    <span class="block g-display text-[15px] uppercase text-white truncate">{{ $sib->name }}</span>
                    <span class="block g-mono text-[9px] tracking-[0.2em] uppercase text-white/40">Ages {{ $sib->ages }}</span>
                </span>
                <svg class="w-4 h-4 ml-auto text-white/30 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>
            @endforeach
        </div>
    </section>
    @endif

    {{-- ═══ CTA ══════════════════════════════════════════ --}}
    <section class="relative pt-10 pb-36">
        <div class="px-4 sm:px-6 lg:px-8 max-w-4xl mx-auto text-center">
            <div class="g-mono text-[11px] tracking-[0.3em] uppercase text-white/50 mb-5 blinker">deploy_request = "enroll_child"</div>
            <h2 class="g-display text-4xl sm:text-6xl uppercase text-white mb-11">
                Plug your kid into<br><span style="color:{{ $c }};" class="brite">{{ $program->name }}.</span>
            </h2>
            <div class="flex flex-wrap justify-center gap-5">
                <a href="{{ route('register') }}" class="hardbtn" style="--c:{{ $c }}; background:{{ $c }};">Enrol on the Growth Line</a>
                <a href="{{ route('contact') }}" class="hardbtn" style="--c:#00FF88;">Ask a Lab Lead</a>
            </div>
        </div>
    </section>
</div>

@include('partials.footer')

@endsection