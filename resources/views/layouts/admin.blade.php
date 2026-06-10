<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — TLab Control Panel</title>

    <!-- Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;500;600;700;800&family=Syne:wght@700;800&display=swap" rel="stylesheet">

    <!-- Tailwind CDN -->
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
        .input { width:100%; padding:12px 16px; border-radius:10px; background:rgba(250,245,232,0.04); border:1px solid rgba(250,245,232,0.1); color:#FAF5E8; font-size:0.875rem; transition:all 0.15s; outline:none; }
        .input:focus { border-color:#4E9966; background:rgba(78,153,102,0.05); }
        .input::placeholder { color:rgba(250,245,232,0.25); }
        .label { display:block; font-size:0.8rem; font-weight:700; color:rgba(250,245,232,0.6); margin-bottom:6px; }
        .badge { display:inline-flex; padding:3px 10px; border-radius:999px; font-size:0.7rem; font-weight:700; text-transform:uppercase; letter-spacing:0.04em; }
        .badge-green  { background:rgba(78,153,102,0.15); color:#4E9966; border:1px solid rgba(78,153,102,0.3); }
        .badge-gold   { background:rgba(212,162,36,0.15); color:#D4A224; border:1px solid rgba(212,162,36,0.3); }
        .badge-red    { background:rgba(194,75,30,0.15);  color:#C24B1E; border:1px solid rgba(194,75,30,0.3); }
        .badge-gray   { background:rgba(250,245,232,0.07); color:rgba(250,245,232,0.5); border:1px solid rgba(250,245,232,0.1); }
        .flash-success { padding:12px 18px; border-radius:10px; background:rgba(78,153,102,0.12); border:1px solid rgba(78,153,102,0.35); color:#4E9966; font-weight:600; margin-bottom:20px; }
        .flash-error   { padding:12px 18px; border-radius:10px; background:rgba(194,75,30,0.12); border:1px solid rgba(194,75,30,0.35); color:#C24B1E; font-weight:600; margin-bottom:20px; }
        .table-row { border-bottom:1px solid rgba(250,245,232,0.05); transition:background 0.12s; }
        .table-row:hover { background:rgba(250,245,232,0.03); }
        /* Mobile sidebar toggle */
        #sidebar { transform:translateX(-100%); transition:transform 0.25s ease; }
        #sidebar.open { transform:translateX(0); }
        @media(min-width:1024px) { #sidebar { transform:none !important; position:relative; } }
    </style>

    @stack('styles')
</head>
<body class="antialiased">

<div class="flex min-h-screen relative">

    <!-- Mobile Overlay -->
    <div id="sidebar-overlay" class="fixed inset-0 bg-black/60 z-30 hidden lg:hidden" onclick="closeSidebar()"></div>

    <!-- Sidebar -->
    <aside id="sidebar" class="fixed lg:relative z-40 sidebar flex flex-col">
        <!-- Logo -->
        <div class="px-5 py-6 border-b border-white/5">
            <div class="flex items-center gap-3">
                <img src="/images/tlab-logo-white.png" alt="TLab" class="h-7 w-auto">
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 px-3 py-4 space-y-0.5 overflow-y-auto">
            <div class="sidebar-section">Overview</div>
            <a href="{{ route('admin.dashboard') }}"
               class="sidebar-link {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>

            <div class="sidebar-section">Curriculum</div>
            <a href="{{ route('admin.clubs.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.clubs*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10"/></svg>
                Clubs
            </a>
            <a href="{{ route('admin.courses.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.courses*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Courses
            </a>
            <a href="{{ route('admin.enrollments.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.enrollments*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2"/></svg>
                Enrollments
            </a>

            <div class="sidebar-section">People</div>
            <a href="{{ route('admin.users.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.users*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Users (Parents)
            </a>
            <a href="{{ route('admin.children.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.children*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Children
            </a>

            <div class="sidebar-section">System</div>
            <a href="{{ route('admin.settings.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.settings*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                Site Settings
            </a>

            <div class="sidebar-section">Content</div>
            <a href="{{ route('admin.carousel.index') }}"
               class="sidebar-link {{ request()->routeIs('admin.carousel*') ? 'active' : '' }}">
                <svg class="w-4 h-4 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Carousel Slides
            </a>

            <div class="pt-4 mt-4 border-t border-white/5">
                <a href="{{ route('parent.dashboard') }}"
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

        <!-- Admin Info -->
        <div class="px-4 py-4 border-t border-white/5">
            <div class="flex items-center gap-3">
                <div class="w-8 h-8 rounded-lg bg-mint/10 border border-mint/20 flex items-center justify-center text-xs font-bold text-mint">
                    {{ strtoupper(substr(auth()->user()->name ?? 'A', 0, 1)) }}
                </div>
                <div class="min-w-0">
                    <div class="text-xs font-bold truncate">{{ auth()->user()->name ?? 'Admin' }}</div>
                    <div class="text-xs text-cream/40">Super Admin</div>
                </div>
            </div>
        </div>
    </aside>

    <!-- Main Content -->
    <div class="flex-1 flex flex-col min-w-0">
        <!-- Top Bar (mobile) -->
        <div class="lg:hidden flex items-center justify-between px-4 py-4 border-b border-white/5 bg-panel">
            <button onclick="openSidebar()" class="p-2 rounded-lg glass">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <div class="font-display font-bold text-sm">TLab Admin</div>
            <div class="w-9"></div>
        </div>

        <!-- Page Content -->
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
