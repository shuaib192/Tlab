<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Dashboard') — Teacher Portal</title>

    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        ink:    '#080D0A',
                        cream:  '#FAF5E8',
                        mint:   '#4E9966',
                        gold:   '#D4A224',
                        terra:  '#C24B1E',
                        violet: '#6B3FA0',
                        sky:    '#2E8BC0',
                        panel:  '#0F1612',
                        surface:'#141A16',
                    },
                    fontFamily: {
                        sans:    ['Outfit', 'sans-serif'],
                        display: ['Syne', 'sans-serif'],
                    }
                }
            }
        }
    </script>

    <style>
        body { background:#080D0A; color:#FAF5E8; font-family:'Outfit',sans-serif; }
        .sidebar { width:256px; min-height:100vh; background:#0F1612; border-right:1px solid rgba(250,245,232,0.06); flex-shrink:0; }
        .sidebar-link { display:flex; align-items:center; gap:12px; padding:10px 16px; border-radius:10px; font-weight:600; font-size:0.875rem; color:rgba(250,245,232,0.55); transition:all 0.15s; }
        .sidebar-link:hover { color:#FAF5E8; background:rgba(250,245,232,0.06); }
        .sidebar-link.active { color:#FAF5E8; background:rgba(78,153,102,0.15); border-left:3px solid #4E9966; }
        .sidebar-section { font-size:0.65rem; font-weight:700; text-transform:uppercase; letter-spacing:0.1em; color:rgba(250,245,232,0.25); padding:16px 16px 6px; }
        .glass { background:rgba(250,245,232,0.03); border:1px solid rgba(250,245,232,0.07); }
        .card { background:#141A16; border:1px solid rgba(250,245,232,0.07); border-radius:16px; }
        .btn-primary { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:10px; font-weight:700; font-size:0.875rem; color:#fff; background:linear-gradient(135deg,#4E9966,#2a6e44); transition:all 0.15s; }
        .btn-primary:hover { opacity:0.9; transform:scale(1.02); }
        .btn-secondary { display:inline-flex; align-items:center; gap:8px; padding:10px 20px; border-radius:10px; font-weight:700; font-size:0.875rem; color:rgba(250,245,232,0.7); background:rgba(250,245,232,0.06); border:1px solid rgba(250,245,232,0.1); transition:all 0.15s; }
        .btn-secondary:hover { color:#FAF5E8; background:rgba(250,245,232,0.1); }
        .btn-danger { display:inline-flex; align-items:center; gap:8px; padding:8px 16px; border-radius:8px; font-weight:600; font-size:0.8rem; color:#C24B1E; background:rgba(194,75,30,0.1); border:1px solid rgba(194,75,30,0.25); transition:all 0.15s; }
        .btn-danger:hover { background:rgba(194,75,30,0.2); }
        .btn-sm { padding:6px 14px; font-size:0.8rem; }
        .input { width:100%; padding:12px 16px; border-radius:10px; background:rgba(250,245,232,0.04); border:1px solid rgba(250,245,232,0.1); color:#FAF5E8; font-size:0.875rem; transition:all 0.15s; outline:none; }
        .input:focus { border-color:#4E9966; background:rgba(78,153,102,0.05); }
        .input::placeholder { color:rgba(250,245,232,0.25); }
        .label { display:block; font-size:0.8rem; font-weight:700; color:rgba(250,245,232,0.6); margin-bottom:6px; }
        .badge { display:inline-flex; padding:3px 10px; border-radius:999px; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; }
        .badge-green  { background:rgba(78,153,102,0.15); color:#4E9966; border:1px solid rgba(78,153,102,0.3); }
        .badge-gold   { background:rgba(212,162,36,0.15); color:#D4A224; border:1px solid rgba(212,162,36,0.3); }
        .badge-red    { background:rgba(194,75,30,0.15);  color:#C24B1E; border:1px solid rgba(194,75,30,0.3); }
        .badge-gray   { background:rgba(250,245,232,0.07); color:rgba(250,245,232,0.5); border:1px solid rgba(250,245,232,0.1); }
        .badge-sky    { background:rgba(46,139,192,0.15); color:#2E8BC0; border:1px solid rgba(46,139,192,0.3); }
        .flash-success { padding:12px 18px; border-radius:10px; background:rgba(78,153,102,0.12); border:1px solid rgba(78,153,102,0.35); color:#4E9966; font-weight:600; margin-bottom:20px; }
        .flash-error   { padding:12px 18px; border-radius:10px; background:rgba(194,75,30,0.12); border:1px solid rgba(194,75,30,0.35); color:#C24B1E; font-weight:600; margin-bottom:20px; }
        .table-row { border-bottom:1px solid rgba(250,245,232,0.05); transition:background 0.12s; }
        .table-row:hover { background:rgba(250,245,232,0.03); }
        .stat-card { padding:20px; border-radius:16px; background:#141A16; border:1px solid rgba(250,245,232,0.07); }
        .stat-value { font-size:1.75rem; font-weight:800; line-height:1; }
        .stat-label { font-size:0.8rem; font-weight:600; color:rgba(250,245,232,0.5); margin-top:4px; }
        select.input { appearance:none; background-image:url("data:image/svg+xml,%3csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 20 20'%3e%3cpath stroke='%23FAF5E8' stroke-linecap='round' stroke-linejoin='round' stroke-width='1.5' d='M6 8l4 4 4-4'/%3e%3c/svg%3e"); background-position:right 12px center; background-repeat:no-repeat; background-size:20px; padding-right:40px; }
        #sidebar { transform:translateX(-100%); transition:transform 0.25s ease; }
        #sidebar.open { transform:translateX(0); }
        @media(min-width:1024px) { #sidebar { transform:none !important; position:relative; } }
    </style>

    @stack('styles')
</head>
<body class="antialiased">

<div class="flex min-h-screen relative">

    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

    <aside id="sidebar" class="fixed lg:relative z-40 sidebar flex flex-col">
        <div class="px-5 py-6 border-b border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center font-display text-lg font-black italic text-white"
                     style="background:linear-gradient(135deg,#4E9966,#2a6e44)">T</div>
                <div>
                    <div class="font-display font-bold text-sm leading-tight">Teacher Portal</div>
                    <div class="text-xs font-bold" style="color:#4E9966">TLab</div>
                </div>
            </div>
        </div>

        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <div class="sidebar-section">Main</div>
            <a href="{{ route('teacher.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('teacher.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <a href="{{ route('teacher.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('teacher.course*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                My Courses
            </a>

            <div class="sidebar-section">Schedule</div>
            <a href="{{ route('teacher.dashboard') }}#sessions"
               class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Schedule
            </a>

            <div class="sidebar-section">Assessments</div>
            <a href="{{ route('teacher.dashboard') }}#assignments"
               class="sidebar-link">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-6 9l2 2 4-4"/></svg>
                Assignments
            </a>

            <div class="pt-4 mt-4 border-t border-white/5">
                <a href="{{ url('/') }}"
                   class="sidebar-link">
                    <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
                    View Site
                </a>
                <form method="POST" action="{{ route('logout') }}">
                    @csrf
                    <button class="sidebar-link w-full text-left">
                        <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                        Logout
                    </button>
                </form>
            </div>
        </nav>

        <div class="px-4 py-4 border-t border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-mint/10 border border-mint/20 flex items-center justify-center text-xs font-bold text-mint">
                    {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-xs font-bold truncate">{{ auth()->user()->name ?? 'Teacher' }}</div>
                    <div class="text-xs text-cream/40">Teacher</div>
                </div>
            </div>
        </div>
    </aside>

    <div class="flex-1 flex flex-col min-w-0">
        <div class="lg:hidden flex items-center justify-between px-4 py-4 border-b border-white/5 bg-panel">
            <button onclick="openSidebar()" class="p-2 rounded-lg glass">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="font-display font-bold text-sm">Teacher Portal</div>
            <div class="w-9"></div>
        </div>

        <main class="flex-1 p-4 sm:p-6 lg:p-8 overflow-auto">
            @if(session('success'))
                <div class="flash-success">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="flash-error">{{ session('error') }}</div>
            @endif

            @yield('content')
        </main>
    </div>
</div>

<script>
    function openSidebar() {
        document.getElementById('sidebar').classList.add('open');
        document.getElementById('sidebar-overlay').classList.remove('hidden');
    }
    function closeSidebar() {
        document.getElementById('sidebar').classList.remove('open');
        document.getElementById('sidebar-overlay').classList.add('hidden');
    }
</script>

@stack('scripts')
</body>
</html>
