<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TLab Kids') — TLab Mission Control</title>
    <link rel="icon" href="/images/tlab-favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Baloo+2:wght@400;500;600;700;800&family=Nunito:wght@400;600;700;800;900&family=JetBrains+Mono:wght@400;700&display=swap" rel="stylesheet">

    <!-- Tailwind (compiled — palette via CSS variables) -->
    <link rel="stylesheet" href="/css/tlab.css">
    <style>
        html {
            --c-space: 23 16 51;
            --c-panel: 34 23 71;
            --c-surface: 42 31 82;
            --c-ink: 23 16 51;
            --c-cream: 255 246 233;
            --c-mint: 77 255 162;
            --c-gold: 255 217 61;
            --c-sky: 90 215 255;
            --c-bubble: 255 107 181;
            --c-grape: 155 123 255;
            --c-terra: 255 107 77;
            --c-violet: 155 123 255;
            --font-sans: 'Nunito', sans-serif;
            --font-display: 'Baloo 2', sans-serif;
            --font-mono: 'JetBrains Mono', monospace;
        }
    </style>

    <style>
        * { box-sizing: border-box; }
        body {
            background-color:#171033;
            color:#FFF6E9;
            font-family:'Nunito',sans-serif;
            overflow-x:hidden;
            background-image:
                radial-gradient(1px 1px at 20% 30%, rgba(255,255,255,.30) 50%, transparent 51%),
                radial-gradient(2px 2px at 72% 16%, rgba(255,255,255,.22) 50%, transparent 51%),
                radial-gradient(1px 1px at 42% 68%, rgba(255,217,61,.40) 50%, transparent 51%),
                radial-gradient(2px 2px at 86% 58%, rgba(255,255,255,.18) 50%, transparent 51%),
                radial-gradient(1px 1px at 12% 86%, rgba(155,123,255,.45) 50%, transparent 51%),
                radial-gradient(2px 2px at 55% 45%, rgba(90,215,255,.35) 50%, transparent 51%),
                radial-gradient(1px 1px at 94% 12%, rgba(255,107,181,.35) 50%, transparent 51%);
            background-size:640px 640px, 900px 900px, 760px 760px, 1100px 1100px, 860px 860px, 960px 960px, 520px 520px;
            background-attachment:fixed;
        }

        /* ── Candy neo-brutalist bits ─────────────────── */
        .candy-card {
            background:#221747;
            border:2px solid rgba(255,246,233,0.12);
            border-radius:1.5rem;
            transition:transform .25s cubic-bezier(.34,1.56,.64,1), border-color .25s, box-shadow .25s;
        }
        .candy-card:hover { border-color:rgba(255,246,233,0.28); }
        .hard-shadow { box-shadow:7px 7px 0 rgba(9,6,24,0.85); }
        .hard-shadow-sm { box-shadow:4px 4px 0 rgba(9,6,24,0.85); }
        .btn-candy {
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            border:2.5px solid #171033; border-radius:1rem;
            font-weight:800; color:#171033;
            box-shadow:5px 5px 0 #0a0718;
            transition:transform .12s, box-shadow .12s;
            user-select:none;
        }
        .btn-candy:hover { transform:translate(-1px,-1px); box-shadow:6px 6px 0 #0a0718; }
        .btn-candy:active { transform:translate(4px,4px); box-shadow:1px 1px 0 #0a0718; }
        .sticker {
            display:inline-flex; align-items:center; gap:6px;
            border:2.5px solid #171033; border-radius:1rem;
            box-shadow:3px 3px 0 #0a0718;
        }
        .museum {
            font-family:'JetBrains Mono',monospace;
            font-weight:700; text-transform:uppercase;
            letter-spacing:.22em; font-size:.62rem;
        }
        .wiggle:hover { animation:wiggle .35s ease; }
        @keyframes wiggle { 0%,100%{transform:rotate(0)} 25%{transform:rotate(-1.4deg)} 75%{transform:rotate(1.4deg)} }
        .float { animation:floaty 5s ease-in-out infinite; }
        @keyframes floaty { 0%,100%{transform:translateY(0) rotate(var(--rot,0deg))} 50%{transform:translateY(-14px) rotate(var(--rot,0deg))} }
        .spin-slow { animation:spin 14s linear infinite; }
        @keyframes spin { to { transform:rotate(360deg); } }
        .blink-caret { border-right:3px solid #4DFFA2; animation:caret .8s step-end infinite; }
        @keyframes caret { 50%{ border-color:transparent; } }
        .bounce-in { animation:bounceIn .5s cubic-bezier(.34,1.56,.64,1); }
        @keyframes bounceIn { 0%{transform:scale(0) rotate(-6deg);opacity:0} 55%{transform:scale(1.18) rotate(2deg)} 100%{transform:scale(1) rotate(0);opacity:1} }
        .pop-in { animation:popIn .4s cubic-bezier(.34,1.56,.64,1) both; }
        @keyframes popIn { 0%{transform:scale(.6);opacity:0} 100%{transform:scale(1);opacity:1} }
        .planet-core{ transition:all .3s cubic-bezier(.34,1.56,.64,1); }
        .planet-core:hover{ transform:scale(1.1) rotate(-4deg); }
        .planet-locked{ filter:grayscale(1); opacity:.45; }

        /* ── Star field ticker ────────────────────────── */
        .space-divider{
            background:repeating-linear-gradient(90deg,rgba(255,246,233,.14) 0 2px,transparent 2px 26px);
            height:2px;
        }

        /* ── Cockpit HUD pods ─────────────────────────── */
        .tlab-logo { filter:drop-shadow(0 3px 0 rgba(9,6,24,.9)); }
        .hud-pod {
            position:fixed; z-index:60;
            display:inline-flex; align-items:center; gap:8px;
            background:#221747;
            border:2px solid rgba(255,246,233,.16); border-radius:1.1rem;
            box-shadow:5px 5px 0 rgba(9,6,24,.92);
            backdrop-filter:blur(6px);
        }
        .pod-in { animation:podIn .45s cubic-bezier(.34,1.56,.64,1) both; }
        @keyframes podIn { 0%{transform:translateY(12px) scale(.9); opacity:0} 100%{transform:translateY(0) scale(1); opacity:1} }

        /* ── Loader: logo dock ────────────────────────── */
        #kid-loader {
            position:fixed; inset:0; z-index:9999;
            display:flex; flex-direction:column; align-items:center; justify-content:center; gap:18px;
            background:#171033;
            transition:opacity .25s ease, visibility .25s ease;
        }
        #kid-loader.out { opacity:0; visibility:hidden; }
        .loader-wrap { position:relative; display:grid; place-items:center; width:164px; height:120px; }
        .loader-wrap::before {
            content:''; position:absolute; inset:0; border-radius:50%;
            background:radial-gradient(circle, rgba(77,255,162,.28), rgba(90,215,255,.12) 45%, transparent 70%);
            animation:pulseGlow 1.1s ease-in-out infinite;
        }
        @keyframes pulseGlow { 0%,100%{transform:scale(.92); opacity:.75} 50%{transform:scale(1.08); opacity:1} }
        .loader-logo { height:64px; width:auto; max-width:220px; position:relative; z-index:1; animation:loaderDock 1.1s ease-in-out infinite; filter:drop-shadow(0 4px 0 rgba(0,0,0,.45)); }
        @keyframes loaderDock { 0%,100%{transform:translateY(0)} 50%{transform:translateY(-12px)} }

        /* ── Geometric deco (no emoji zone) ───────────── */
        .geo-ring { display:inline-block; width:34px; height:34px; border-radius:50%; border:3px solid rgba(155,123,255,.55); position:relative; }
        .geo-ring::after { content:''; position:absolute; inset:8px; border-radius:50%; border:2px solid rgba(255,246,233,.3); }
        .geo-ring::before { content:''; position:absolute; top:50%; left:50%; width:4px; height:4px; border-radius:50%; background:#FFD93D; transform:translate(-50%,-50%); }
        .geo-diamond { display:inline-block; width:20px; height:20px; transform:rotate(45deg); background:rgba(255,217,61,.7); border:2px solid rgba(255,246,233,.25); }
        .geo-plus { display:inline-block; width:26px; height:26px; position:relative; }
        .geo-plus::before,.geo-plus::after { content:''; position:absolute; background:rgba(255,107,181,.6); }
        .geo-plus::before { left:50%; top:2px; bottom:2px; width:3px; transform:translateX(-50%); }
        .geo-plus::after { top:50%; left:2px; right:2px; height:3px; transform:translateY(-50%); }
        .geo-outbox { display:inline-block; width:56px; height:56px; border:3px solid rgba(255,246,233,.18); border-radius:12px; position:relative; }
        .geo-outbox::before { content:''; position:absolute; inset:10px; border:2px dashed rgba(255,246,233,.14); border-radius:6px; }

        /* ── Scroll reveal ────────────────────────────── */
        .reveal { opacity:0; transform:translateY(14px); will-change:transform,opacity; }
        .reveal.in { opacity:1; transform:translateY(0); transition:opacity .5s cubic-bezier(.16,1,.3,1), transform .5s cubic-bezier(.16,1,.3,1); }

        /* ── Candy inputs ─────────────────────────────── */
        .input-candy {
            width:100%; padding:14px 18px; border-radius:1.1rem;
            border:2.5px solid rgba(255,246,233,.18);
            background:rgba(255,246,233,.05); color:#FFF6E9;
            font-weight:800; outline:none; transition:all .15s;
        }
        .input-candy:focus { border-color:#4DFFA2; background:rgba(77,255,162,.06); box-shadow:0 0 0 4px rgba(77,255,162,.12); }
        .input-candy::placeholder { color:rgba(255,246,233,.35); font-weight:600; }
    </style>

    @stack('styles')
</head>
<body class="antialiased min-h-screen">

{{-- Rocketship loader --}}
<div id="kid-loader" aria-hidden="true">
    <div class="loader-wrap">
        <img src="/images/tlab-logo-white.png" alt="TLab" class="loader-logo">
    </div>
    <div class="museum text-mint blink-caret">// TLAB MISSION CONTROL //</div>
</div>

{{-- Floating space deco --}}
<div class="pointer-events-none fixed inset-0 z-0 overflow-hidden">
    <div class="absolute -left-16 top-24 w-40 h-40 rounded-full opacity-20 blur-3xl" style="background:#9B7BFF"></div>
    <div class="absolute -right-20 top-1/2 w-56 h-56 rounded-full opacity-15 blur-3xl" style="background:#5AD7FF"></div>
    <div class="absolute left-1/3 -bottom-24 w-64 h-64 rounded-full opacity-15 blur-3xl" style="background:#FF6BB5"></div>
    <div class="float absolute right-[8%] top-28 select-none opacity-60"><span class="geo-ring"></span></div>
    <div class="float absolute left-[6%] top-1/2 select-none opacity-50" style="animation-delay:1.2s"><span class="geo-diamond"></span></div>
    <div class="float absolute right-[12%] bottom-40 select-none opacity-40" style="animation-delay:2s"><span class="geo-plus"></span></div>
</div>

{{-- Cockpit HUD: brand nameplate + XP pod + exit hatch (no nav bar) --}}
<a href="{{ route('child.dashboard') }}" class="hud-pod pod-in top-4 left-4 pl-2.5 pr-4 py-1.5 -rotate-1 hover:rotate-0 hover:border-cream/35 transition-all group">
    <img src="/images/tlab-logo-white.png" alt="TLab" class="h-8 w-auto tlab-logo group-hover:scale-105 transition-transform">
    <span class="h-6 w-px bg-cream/15"></span>
    <span class="leading-none py-0.5">
        <span class="museum text-mint block mb-1">KIDS // MISSION</span>
        <span class="text-[10px] font-black text-cream/70 tracking-widest">SPACE DECK 01</span>
    </span>
</a>

<div class="fixed top-4 right-4 z-60 flex items-center gap-2 pod-in" style="animation-delay:.08s">
    @isset($child)
    <span class="flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-gold border-2 border-space shadow-[5px_5px_0_rgba(9,6,24,.92)]">
        <span class="museum text-space/50">XP</span>
        <span class="font-display font-extrabold text-space text-lg leading-none tabular-nums">{{ number_format($child->xp) }}</span>
    </span>
        @if($isChildAuth ?? false)
        <form method="POST" action="{{ route('child.logout') }}" class="m-0">
            @csrf
            <button type="submit" class="flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-panel border-2 border-cream/20 shadow-[5px_5px_0_rgba(9,6,24,.92)] text-[11px] font-black tracking-widest text-cream/85 hover:text-cream hover:border-cream/45 hover:bg-surface transition-colors">
                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                LEAVE DECK
            </button>
        </form>
        @else
        <a href="{{ route('parent.dashboard') }}" class="flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-panel border-2 border-cream/20 shadow-[5px_5px_0_rgba(9,6,24,.92)] text-[11px] font-black tracking-widest text-cream/85 hover:text-cream hover:border-cream/45 hover:bg-surface transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
            PARENT HQ
        </a>
        @endif
    @else
        <a href="{{ route('login') }}" class="flex items-center gap-1.5 px-3.5 py-2 rounded-2xl bg-panel border-2 border-cream/20 shadow-[5px_5px_0_rgba(9,6,24,.92)] text-[11px] font-black tracking-widest text-cream/85 hover:text-cream hover:border-cream/45 hover:bg-surface transition-colors">
            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
            PARENT? LOG IN
        </a>
    @endisset
</div>

<main class="relative z-10 max-w-6xl mx-auto px-4 sm:px-6 pt-20 sm:pt-24 pb-16 sm:pb-20">
    @if(session('success'))
        <div class="mb-6 candy-card hard-shadow-sm rounded-2xl px-5 py-4 text-sm font-bold" style="border-color:rgba(77,255,162,.5);background:rgba(77,255,162,.12)">
            <span class="inline-block w-4 h-4 mr-1.5 text-mint align-[-3px]" aria-hidden="true">✓</span>{{ session('success') }}
        </div>
    @endif
    @if(session('error'))
        <div class="mb-6 candy-card hard-shadow-sm rounded-2xl px-5 py-4 text-sm font-bold" style="border-color:rgba(255,107,77,.5);background:rgba(255,107,77,.12)">
            <span class="inline-block w-4 h-4 mr-1.5 text-terra align-[-3px]" aria-hidden="true">✕</span>{{ session('error') }}
        </div>
    @endif

    @yield('content')
</main>

{{-- Footer --}}
<footer class="relative z-10 border-t-2 border-cream/10 mt-10">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 py-6 flex flex-col sm:flex-row items-center justify-between gap-3">
        <span class="museum text-cream/40">// TLAB FOR KIDS //</span>
        <span class="text-cream/50 font-bold text-xs">Built for explorers. Every click counts XP.</span>
    </div>
</footer>

<script>
    // Hide loader
    document.addEventListener('DOMContentLoaded', () => {
        setTimeout(() => {
            const l = document.getElementById('kid-loader');
            if (l) l.classList.add('out');
        }, 120);
    });

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
</script>

@stack('scripts')
</body>
</html>