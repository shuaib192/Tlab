<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'School Portal - TLab')</title>
    <link rel="preload" href="/css/tlab.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
    <noscript><link rel="stylesheet" href="/css/tlab.css"></noscript>
    <style>
        html {
            --c-primary: 22 163 74;
            --c-mint: 22 163 74;
            --c-accent: 124 58 237;
            --c-ink: 15 23 42;
            --c-muted: 100 116 139;
            --c-coral: 239 68 68;
            --c-amber: 217 119 6;
            --c-violet: 124 58 237;
            --c-gold: 217 119 6;
            --c-cream: 248 250 252;
            --font-sans: 'Inter', sans-serif;
            --font-display: 'Inter', sans-serif;
        }
    </style>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700;900&display=swap" rel="stylesheet">
    <style>body{font-family:'Inter',sans-serif;background:#f8fafc}.sidebar-link{display:flex;align-items:center;gap:10px;padding:10px 14px;border-radius:10px;font-size:13px;font-weight:600;color:#94a3b8;transition:all .2s}.sidebar-link:hover{background:#1e293b;color:#fff}.sidebar-link.active{background:#16A34A20;color:#16A34A}.sidebar-section{font-size:10px;font-weight:900;text-transform:uppercase;letter-spacing:1.5px;color:#475569;padding:16px 14px 8px}</style>
</head>
<body>
<div class="flex h-screen bg-[#0F172A]">
    <aside class="w-64 flex-shrink-0 bg-[#0F172A] border-r border-white/5 flex flex-col">
        <div class="p-6 border-b border-white/5">
            <a href="{{ route('school.dashboard') }}" class="font-black text-xl text-white"><span class="text-primary">T</span>Lab <span class="text-xs text-muted font-semibold">School</span></a>
        </div>
        <nav class="flex-1 overflow-y-auto p-4 space-y-1">
            <div class="sidebar-section">Overview</div>
            <a href="{{ route('school.dashboard') }}" class="sidebar-link {{ request()->routeIs('school.dashboard') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Dashboard
            </a>
            <div class="sidebar-section">Students</div>
            <a href="{{ route('school.students') }}" class="sidebar-link {{ request()->routeIs('school.students') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                Students
            </a>
            <a href="{{ route('school.students.import') }}" class="sidebar-link {{ request()->routeIs('school.students.import') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16v2a2 2 0 002 2h12a2 2 0 002-2v-2M7 10l5 5 5-5M12 15V3"/></svg>
                Bulk Import
            </a>
            <a href="{{ route('school.students.provisioning') }}" class="sidebar-link {{ request()->routeIs('school.students.provisioning') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                Teacher Provisioning
            </a>
            <div class="sidebar-section">Analytics</div>
            <a href="{{ route('school.analytics') }}" class="sidebar-link {{ request()->routeIs('school.analytics') ? 'active' : '' }}">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                Analytics
            </a>
            <div class="sidebar-section">Account</div>
            <a href="{{ route('home') }}" class="sidebar-link"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg> Back to Site</a>
        </nav>
    </aside>
    <main class="flex-1 overflow-y-auto">
        <div class="max-w-7xl mx-auto px-6 py-8">
            @if(session('success'))
                <div class="mb-6 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm">{{ session('success') }}</div>
            @endif
            @if(session('error'))
                <div class="mb-6 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 font-bold text-sm">{{ session('error') }}</div>
            @endif
            @yield('content')
        </div>
    </main>
</div>
</body>
</html>
