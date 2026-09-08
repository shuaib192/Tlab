@extends('layouts.app')
@section('title', 'STEAM Programs & Growth Lines — TLab')
@section('description', 'Five evolutionary STEAM disciplines — Science, Technology, Engineering, Arts, Mathematics — engineered as a living Growth Line from ages 3 to 18 at TLab by Edfrica.')

@push('styles')
<link rel="preconnect" href="https://fonts.googleapis.com">
<link href="https://fonts.googleapis.com/css2?family=Archivo+Black&family=Space+Mono:wght@400;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
<style>
    .steam-page {
        background:#05070d;
        color:#e8eef7;
        font-family:'Space Grotesk',sans-serif;
        overflow-x:hidden;
        position:relative;
    }
    .steam-page::after {
        content:'';
        position:fixed; inset:0; pointer-events:none; z-index:5;
        background:repeating-linear-gradient(0deg, rgba(255,255,255,0.022) 0 1px, transparent 1px 3px);
        mix-blend-mode:overlay;
    }
    .scanline {
        position:absolute; left:0; right:0; height:120px; z-index:4;
        background:linear-gradient(180deg, transparent, rgba(255,255,255,0.045), transparent);
        animation:scan 7s linear infinite;
        pointer-events:none;
    }
    @keyframes scan { 0%{top:-15%} 100%{top:110%} }
    .g-display { font-family:'Archivo Black',sans-serif; line-height:0.95; letter-spacing:-0.01em; }
    .g-mono { font-family:'Space Mono',monospace; }
    .hazard {
        background:repeating-linear-gradient(45deg,#0b0f18 0 10px,#111623 10px 20px);
    }
    .brite { font-style:normal; text-shadow:0 0 24px var(--c); }
    .hardbtn {
        display:inline-flex; align-items:center; gap:10px;
        border:2px solid #000; border-radius:10px;
        box-shadow:5px 5px 0 #000;
        font-family:'Space Mono',monospace; font-weight:700; font-size:11px;
        letter-spacing:0.18em; text-transform:uppercase;
        padding:14px 22px; color:#05070d; background:var(--c,#00FF88);
        transition:transform .12s ease, box-shadow .12s ease;
    }
    .hardbtn:hover { transform:translate(4px,4px); box-shadow:1px 1px 0 #000; }
    .prog-card {
        position:relative;
        background:#0a0e16;
        border:2px solid var(--c,#00FF88);
        border-radius:18px;
        box-shadow:7px 7px 0 rgba(0,0,0,0.85), 0 0 44px -24px var(--c);
        transition:transform .18s ease, box-shadow .18s ease;
        overflow:hidden;
    }
    .prog-card:hover { transform:translate(-3px,-3px) rotate(-0.6deg); box-shadow:10px 10px 0 rgba(0,0,0,0.9), 0 0 60px -18px var(--c); }
    .prog-card .corner {
        position:absolute; width:26px; height:26px; background:var(--c);
    }
    .prog-card .corner.tl { top:0; left:0; border-radius:0 0 18px 0; }
    .prog-card .corner.br { bottom:0; right:0; border-radius:18px 0 0 0; }
    .pips { display:flex; gap:6px; }
    .pips span { flex:1; height:8px; border-radius:99px; background:rgba(255,255,255,0.08); }
    .pips span.on { background:var(--c); box-shadow:0 0 12px var(--c); }
    .ticker {
        overflow:hidden; white-space:nowrap;
        border-top:1px solid rgba(255,255,255,0.08); border-bottom:1px solid rgba(255,255,255,0.08);
    }
    .ticker-track { display:inline-flex; gap:56px; padding:14px 20px; animation:tick 26s linear infinite; }
    @keyframes tick { 0%{transform:translateX(0)} 100%{transform:translateX(-50%)} }
    .stamp {
        display:inline-grid; place-items:center;
        border:2px dashed currentColor; border-radius:999px;
        font-family:'Space Mono',monospace; font-weight:700; font-size:9px;
        letter-spacing:0.22em; text-transform:uppercase;
        transform:rotate(-9deg); padding:8px 14px;
    }
    .blinker::after { content:'▌'; animation:blink 1.1s steps(1) infinite; }
    @keyframes blink { 50%{opacity:0} }
    .seclead { font-size:0.72rem; letter-spacing:0.34em; text-transform:uppercase; font-family:'Space Mono',monospace; }
</style>
@endpush

@section('content')

<div class="steam-page min-h-screen relative">
    <div class="scanline"></div>

    @include('partials.nav')

    {{-- ═══ HERO CORE ═════════════════════════════════════ --}}
    <header class="relative pt-44 pb-20 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
        <div class="grid grid-cols-1 lg:grid-cols-12 gap-10 items-end">
            <div class="lg:col-span-8">
                <div class="g-mono text-[11px] tracking-[0.3em] uppercase flex items-center gap-3 mb-6">
                    <span style="color:var(--c,#00FF88);" class="brite">// STEAM-CORE //</span>
                    <span class="text-white/40">CURRICULUM BUILD 2.0</span>
                    <span class="w-8 h-px bg-white/30"></span>
                    <span class="text-white/40">EST. AGES 03–18</span>
                </div>
                <h1 class="g-display text-[clamp(3rem,9vw,7.5rem)] text-white uppercase">
                    Five
                    <span style="color:#00FF88" class="brite">Corruption</span><br>
                    Protocols.
                    <span class="block mt-2 g-mono text-[clamp(0.9rem,2.5vw,1.4rem)] text-white/70 tracking-normal" style="font-family:'Space Mono',monospace;">
                        Otherwise known as the STEAM disciplines — mutated into a single
                        <span style="color:#00E5FF" class="brite">Growth Line</span> that carries your child from
                        smeared finger-paint logic to quantum-grade reasoning.
                    </span>
                </h1>
            </div>
            <div class="lg:col-span-4 flex justify-start lg:justify-end">
                <div class="stamp" style="color:#FFB800; --c:#FFB800;">v2.0 · Progress Conduit: LIVE</div>
            </div>
        </div>

        <div class="ticker mt-16 w-full">
            <div class="ticker-track g-mono text-xs text-white/60">
                @foreach($programs as $p)
                    <span style="color:{{ $p->color }}" class="brite uppercase tracking-widest">[ {{ $p->name }} ]</span>
                    <span class="text-white/30">AGES {{ $p->ages }}</span>
                    <span class="text-white/30">{{ $p->growthStages->count() }} NODES</span>
                    <span class="text-white/30">&middot;</span>
                @endforeach
                @foreach($programs as $p)
                    <span style="color:{{ $p->color }}" class="brite uppercase tracking-widest">[ {{ $p->name }} ]</span>
                    <span class="text-white/30">AGES {{ $p->ages }}</span>
                    <span class="text-white/30">{{ $p->growthStages->count() }} NODES</span>
                    <span class="text-white/30">&middot;</span>
                @endforeach
            </div>
        </div>
    </header>

    {{-- ═══ EVOLUTION CONDUIT MAP ═════════════════════════ --}}
    <section class="relative px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto pb-24" id="conduit">
        @if($programs->count())
        <div class="flex items-center gap-6 mb-10">
            <span class="seclead brite" style="color:var(--c,#00FF88);">// GROWTH LINE MAP</span>
            <div class="flex-1 h-px bg-gradient-to-r from-white/25 to-transparent"></div>
            <span class="seclead text-white/40">5 DISCIPLINES &middot; 25 NODES</span>
        </div>

        {{-- Conduit rail linking all programs --}}
        <div class="hidden lg:flex items-center justify-between mb-14 relative">
            <div class="absolute inset-x-0 top-1/2 h-[3px] -translate-y-1/2"
                 style="background:linear-gradient(90deg,#00FF88,#00E5FF,#FFB800,#FF007F,#9D00FF); opacity:.5; filter:blur(6px);"></div>
            @foreach($programs as $i => $p)
            <a href="#prog-{{ $p->slug }}" class="relative z-10 group" style="--c:{{ $p->color }}">
                <span class="block w-11 h-11 rounded-full border-2 grid place-items-center g-mono font-bold text-sm transition-transform duration-200 group-hover:scale-125"
                      style="background:#05070d; border-color:{{ $p->color }}; color:{{ $p->color }}; box-shadow:0 0 22px -4px {{ $p->color }};">
                    {{ $i + 1 }}
                </span>
                <span class="sr-only">{{ $p->name }}</span>
            </a>
            @endforeach
        </div>
        @endif
    </section>

    {{-- ═══ PROGRAM SPECIMENS ═════════════════════════════ --}}
    <section class="relative pb-28">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-10">
                @forelse($programs as $p)
                @php $style = '--c:'.$p->color; @endphp
                <div id="prog-{{ $p->slug }}" class="prog-card p-8 flex flex-col" style="{{ $style }}">
                    <span class="corner tl"></span>
                    <span class="corner br"></span>

                    <div class="flex items-start justify-between mb-8">
                        <div class="g-mono text-[10px] tracking-[0.28em] uppercase text-white/40">
                            DISCIPLINE {{ sprintf('%02d', $loop->iteration) }}<br>
                            <span style="color:{{ $p->color }};" class="brite">{{ strtoupper($p->discipline) }}</span>
                        </div>
                        <span class="g-display text-[64px] leading-none text-white/5 select-none">0{{ $loop->iteration }}</span>
                    </div>

                    <div class="g-display text-4xl uppercase text-white mb-1">{{ $p->name }}</div>
                    <div class="g-mono text-xs text-white/50 mb-6 italic" style="color:{{ $p->color }};">“{{ $p->tagline }}”</div>

                    <p class="text-sm text-white/65 leading-relaxed mb-8 flex-1">{{ \Illuminate\Support\Str::limit($p->description, 190) }}</p>

                    <div class="mb-8">
                        <div class="flex items-center justify-between mb-3">
                            <span class="g-mono text-[10px] tracking-widest uppercase text-white/40">Growth Nodes</span>
                            <span class="g-mono text-[10px] text-white/60">{{ $p->growthStages->count() }} &middot; AGES {{ $p->ages }}</span>
                        </div>
                        <div class="pips">
                            @for($i = 1; $i <= max(5, $p->growthStages->count()); $i++)
                                <span class="{{ $i <= $p->growthStages->count() ? 'on' : '' }}"></span>
                            @endfor
                        </div>
                    </div>

                    <a href="{{ route('programs.show', $p->slug) }}" class="hardbtn w-full justify-center" style="{{ $style }}">
                        Enter the Conduit
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                @if($loop->first)
                <div class="prog-card p-8 flex flex-col justify-center" style="--c:#FFB800; background:repeating-linear-gradient(45deg,#231503 0 12px,#1a1002 12px 24px);">
                    <span class="g-mono text-[10px] tracking-[0.3em] uppercase text-amber-500/90 mb-4">&gt;&gt; RUMOR FEED &lt;&lt;</span>
                    <div class="g-display text-3xl uppercase text-white mb-5">
                        New disciplines<br>mutating<br><span style="color:#FFB800;" class="brite">season two.</span>
                    </div>
                    <p class="g-mono text-xs text-white/50 leading-relaxed mb-8">
                        The Growth Line is a living organism. Stage nodes mutate, skills rank up,
                        and certifiable milestones unlock at every age band. Your child never repeats
                        a lesson — the line evolves below their fingers.
                    </p>
                    <div class="g-mono text-[10px] tracking-widest text-amber-500/70 uppercase">[ Fermis Lab · Confidential ]</div>
                </div>
                @endif

                @empty
                <div class="col-span-full py-24 text-center border-2 border-dashed border-white/15 rounded-2xl">
                    <p class="g-mono text-sm text-white/40 mb-6">// CONDUIT INITIALIZING — PROGRAMS NOT YET SEEDED //</p>
                </div>
                @endforelse
            </div>

            <div class="mt-12 hidden md:flex items-center justify-center gap-14 g-mono text-[10px] uppercase tracking-[0.25em] text-white/35">
                <span>SCIENCE #00FF88</span>
                <span>TECHNOLOGY #00E5FF</span>
                <span>ENGINEERING #FFB800</span>
                <span>ARTS #FF007F</span>
                <span>MATHS #9D00FF</span>
            </div>
        </div>
    </section>

    {{-- ═══ CTA TERMINAL ══════════════════════════════════ --}}
    <section class="relative pt-24 pb-36">
        <div class="hazard border-y-2 border-white/10 py-16 -rotate-1">
            <div class="max-w-4xl mx-auto px-4 text-center">
                <div class="g-mono text-[11px] tracking-[0.3em] uppercase text-white/50 mb-5 blinker">running_protocol: admissions_scan.exe</div>
                <h2 class="g-display text-4xl sm:text-6xl uppercase text-white mb-7">
                    Align your young engineer<br>
                    to the correct <span style="color:#00FF88;">bandwidth.</span>
                </h2>
                <div class="flex flex-wrap justify-center gap-5 mt-10">
                    <a href="{{ route('contact') }}" class="hardbtn" style="--c:#00FF88;">Talk to Lab Intake</a>
                    <a href="{{ route('register') }}" class="hardbtn" style="--c:#00E5FF; background:#00E5FF;">Join the Growth Line</a>
                </div>
            </div>
        </div>
    </section>
</div>

@include('partials.footer')

@endsection