<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'TLab') — Africa's Gamified STEM Platform for Kids</title>
    <meta name="description" content="@yield('description', 'TLab by Edfrica — a safe, gamified STEM learning ecosystem for African children aged 3–15.')">
    <link rel="icon" href="/images/tlab-favicon.png">

    <!-- Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Montserrat:ital,wght@0,400;0,500;0,600;0,700;0,800;0,900;1,700&display=swap" rel="stylesheet">

    <!-- Tailwind -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#16A34A',
                        accent:  '#2563EB',
                        violet:  '#7C3AED',
                        amber:   '#D97706',
                        coral:   '#EA580C',
                        ink:     '#0F172A',
                        muted:   '#64748B',
                        surface: '#F8FAFC',
                    },
                    fontFamily: {
                        sans:    ['"Montserrat"', 'sans-serif'],
                        display: ['"Montserrat"', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <!-- GSAP -->
    <script src="https://cdnjs.cloudflare.com/ajax/libs/gsap/3.12.5/gsap.min.js" defer></script>

    <style>
        *  { box-sizing: border-box; }
        body { background:#fff; color:#0F172A; font-family:'Montserrat',sans-serif; overflow-x:hidden; }

        /* ─── Page Transition Overlay ───────────────────── */
        #page-loader {
            position:fixed; inset:0; z-index:9999;
            display:flex; flex-direction:column; align-items:center; justify-content:center; gap:24px;
            background:linear-gradient(135deg,#0F172A 0%,#1a2744 50%,#0F172A 100%);
            transition:opacity .2s ease, visibility .2s ease;
        }
        #page-loader.out { opacity:0; visibility:hidden; }
        .loader-ring {
            width:56px; height:56px; border-radius:50%;
            border:3px solid rgba(255,255,255,0.15);
            border-top-color:#16A34A;
            animation:spin 0.6s linear infinite;
        }
        @keyframes spin { to { transform:rotate(360deg); } }
        .loader-logo-wrap { animation:pulseLogo 1.4s ease-in-out infinite; }
        @keyframes pulseLogo { 0%,100%{transform:scale(1);opacity:1} 50%{transform:scale(1.06);opacity:0.85} }

        /* ─── Navigation ─────────────────────────────────── */
        .nav-item {
            font-weight:700; font-size:0.875rem; color:#374151;
            padding:8px 4px; position:relative; transition:color .2s;
            white-space:nowrap;
        }
        .nav-item:hover { color:#16A34A; }
        .nav-item::after {
            content:''; position:absolute; bottom:0; left:0; width:0; height:2px;
            background:#16A34A; border-radius:99px; transition:width .25s;
        }
        .nav-item:hover::after { width:100%; }
        .nav-item.has-dropdown:after { display:none; }

        /* Dropdown */
        .dropdown-menu {
            position:absolute; top:calc(100% + 12px); left:50%; transform:translateX(-50%);
            background:#fff; border:1px solid #E2E8F0; border-radius:16px;
            box-shadow:0 20px 60px rgba(0,0,0,0.12); min-width:220px;
            padding:8px; opacity:0; visibility:hidden;
            transition:opacity .2s, transform .2s, visibility .2s;
            transform:translateX(-50%) translateY(-8px);
            z-index:200;
        }
        .dropdown-wrap:hover .dropdown-menu {
            opacity:1; visibility:visible; transform:translateX(-50%) translateY(0);
        }
        .dropdown-link {
            display:block; padding:10px 14px; border-radius:10px;
            font-weight:700; font-size:0.8rem; color:#374151;
            transition:background .15s, color .15s;
        }
        .dropdown-link:hover { background:#F0FDF4; color:#16A34A; }

        /* ─── Buttons ─────────────────────────────────────── */
        .btn-cta {
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:12px 26px; border-radius:12px; font-weight:800; font-size:0.875rem;
            background:#16A34A; color:#fff;
            box-shadow:0 4px 20px rgba(22,163,74,0.3);
            transition:all .2s;
        }
        .btn-cta:hover { background:#15803D; transform:translateY(-2px); box-shadow:0 8px 28px rgba(22,163,74,0.4); }
        .btn-outline {
            display:inline-flex; align-items:center; justify-content:center; gap:8px;
            padding:12px 26px; border-radius:12px; font-weight:800; font-size:0.875rem;
            background:transparent; color:#0F172A; border:2px solid #E2E8F0;
            transition:all .2s;
        }
        .btn-outline:hover { border-color:#16A34A; color:#16A34A; transform:translateY(-2px); }
        .btn-hero {
            display:inline-flex; align-items:center; justify-content:center; gap:10px;
            padding:16px 36px; border-radius:14px; font-weight:800; font-size:1rem;
            background:#16A34A; color:#fff;
            box-shadow:0 8px 32px rgba(22,163,74,0.35);
            transition:all .25s;
        }
        .btn-hero:hover { background:#15803D; transform:translateY(-3px); box-shadow:0 14px 40px rgba(22,163,74,0.45); }

        /* ─── Auth Buttons ───────────────────────────────── */
        .btn-edfrica {
            display:flex; align-items:center; justify-content:center; gap:12px;
            width:100%; padding:15px 24px; border-radius:14px;
            font-weight:800; font-size:0.9rem;
            background:#0F172A; color:#fff; border:2px solid #1E293B;
            box-shadow:0 4px 16px rgba(15,23,42,0.2);
            transition:all .2s;
        }
        .btn-edfrica:hover { background:#1E293B; transform:translateY(-2px); box-shadow:0 8px 24px rgba(15,23,42,0.3); }
        .btn-submit {
            display:flex; align-items:center; justify-content:center;
            width:100%; padding:15px 24px; border-radius:14px;
            font-weight:800; font-size:0.95rem;
            background:#16A34A; color:#fff;
            box-shadow:0 6px 24px rgba(22,163,74,0.35);
            transition:all .2s;
        }
        .btn-submit:hover { background:#15803D; transform:translateY(-2px); box-shadow:0 10px 32px rgba(22,163,74,0.45); }

        /* ─── Form Inputs ────────────────────────────────── */
        .form-input {
            width:100%; padding:14px 18px; border-radius:12px;
            border:2px solid #E5E7EB; background:#F9FAFB;
            font-size:0.9rem; font-family:'Plus Jakarta Sans',sans-serif;
            font-weight:600; color:#0F172A; outline:none;
            transition:border-color .2s, box-shadow .2s, background .2s;
        }
        .form-input:focus { border-color:#16A34A; background:#fff; box-shadow:0 0 0 4px rgba(22,163,74,0.1); }
        .form-input::placeholder { color:#9CA3AF; font-weight:500; }
        .form-label { display:block; font-weight:700; font-size:0.82rem; color:#374151; margin-bottom:7px; letter-spacing:0.02em; }

        /* ─── Cards ──────────────────────────────────────── */
        .tcard {
            background:#fff; border-radius:20px;
            border:1.5px solid #F1F5F9;
            box-shadow:0 4px 24px rgba(0,0,0,0.06);
        }
        .tcard-hover { transition:transform .25s, box-shadow .25s; }
        .tcard-hover:hover { transform:translateY(-6px); box-shadow:0 16px 48px rgba(0,0,0,0.12); }

        /* ─── Badges ─────────────────────────────────────── */
        .chip { display:inline-flex; align-items:center; padding:5px 14px; border-radius:99px; font-weight:700; font-size:0.78rem; letter-spacing:0.02em; }

        /* ─── XP Bar ─────────────────────────────────────── */
        .xp-track { height:8px; border-radius:99px; background:#E5E7EB; overflow:hidden; }
        .xp-fill  { height:100%; border-radius:99px; background:linear-gradient(90deg,#16A34A,#2563EB); transition:width 1.2s cubic-bezier(.34,1.56,.64,1); }

        /* ─── Flash Messages ─────────────────────────────── */
        .flash { padding:14px 20px; border-radius:12px; font-weight:700; margin-bottom:20px; font-size:0.875rem; }
        .flash-success { background:#F0FDF4; border:2px solid #86EFAC; color:#15803D; }
        .flash-error   { background:#FEF2F2; border:2px solid #FCA5A5; color:#DC2626; }
        .flash-info    { background:#EFF6FF; border:2px solid #93C5FD; color:#1D4ED8; }

        /* ─── Admin Sidebar (separate sheet) ─────────────── */
        .rank-badge { display:inline-flex; align-items:center; padding:4px 12px; border-radius:99px; font-weight:700; font-size:0.72rem; }

        /* ─── Mobile Nav ─────────────────────────────────── */
        #mobile-nav {
            max-height:0; overflow:hidden;
            transition:max-height .4s cubic-bezier(0.4,0,0.2,1);
        }
        #mobile-nav.open { max-height:600px; }

        /* ─── Scroll Reveal ──────────────────────────────── */
        .reveal { opacity: 0; transform: translateY(12px); will-change: transform, opacity; }
        .reveal.in { 
            opacity: 1; 
            transform: translateY(0); 
            transition: opacity 0.5s cubic-bezier(0.16, 1, 0.3, 1), transform 0.5s cubic-bezier(0.16, 1, 0.3, 1); 
        }

        /* ─── Section Utilities ──────────────────────────── */
        .section-tag { font-size:0.78rem; font-weight:800; text-transform:uppercase; letter-spacing:0.1em; }
    </style>

    @stack('styles')
</head>
<body class="antialiased">

{{-- ═══ PAGE TRANSITION LOADER ════════════════════════════ --}}
<div id="page-loader" aria-hidden="true">
    <div class="loader-logo-wrap">
        <img src="/images/tlab-logo-white.png" alt="TLab" class="h-14 w-auto">
    </div>
    <div class="loader-ring"></div>
</div>

@yield('content')

@stack('scripts')

<script>
// ─── Hide loader on page ready ───────────────────────────
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        const loader = document.getElementById('page-loader');
        if (loader) loader.classList.add('out');
    }, 100);
});

// ─── Show loader on every internal navigation ─────────────
document.addEventListener('click', (e) => {
    const a = e.target.closest('a[href]');
    if (!a) return;
    const href = a.getAttribute('href');
    if (!href || href.startsWith('#') || href.startsWith('javascript') || a.target === '_blank' || a.dataset.noTransition !== undefined) return;
    if (e.ctrlKey || e.metaKey || e.shiftKey) return; // allow open-in-new-tab
    const loader = document.getElementById('page-loader');
    if (loader) loader.classList.remove('out');
});

// ─── Mobile nav toggle ────────────────────────────────────
const hamburger = document.getElementById('hamburger');
const mobileNav = document.getElementById('mobile-nav');
if (hamburger && mobileNav) {
    hamburger.addEventListener('click', () => mobileNav.classList.toggle('open'));
}

// ─── Scroll Reveal ────────────────────────────────────────
const observer = new IntersectionObserver((entries) => {
    entries.forEach((en) => {
        if (en.isIntersecting) {
            const delay = parseInt(en.target.getAttribute('data-delay')) || 0;
            setTimeout(() => en.target.classList.add('in'), delay);
            observer.unobserve(en.target);
        }
    });
}, { threshold: 0.05 });
document.querySelectorAll('.reveal').forEach((el) => {
    observer.observe(el);
});
</script>

</body>
</html>
