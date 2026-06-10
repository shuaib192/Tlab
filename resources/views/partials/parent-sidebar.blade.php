@php
    $navItems = [
        'parent.dashboard' => ['Dashboard', 'M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6'],
        'parent.children.index' => ['My Children', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        'parent.children.create' => ['Add Child', 'M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z'],
        'parent.courses.index' => ['Browse Courses', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
    ];
@endphp

{{-- Sidebar Backdrop (mobile) --}}
<div x-show="sidebarOpen" x-cloak @@click="sidebarOpen = false" class="fixed inset-0 z-40 bg-ink/60 backdrop-blur-sm lg:hidden"></div>

{{-- Sidebar --}}
<aside class="fixed top-0 left-0 z-50 h-full w-64 lg:w-64 flex-shrink-0 transform transition-transform duration-300 ease-in-out lg:translate-x-0"
       :class="sidebarOpen ? 'translate-x-0' : '-translate-x-full'"
       style="background:#0F172A; border-right:1px solid rgba(255,255,255,0.06)">
    
    {{-- Logo --}}
    <div class="flex items-center justify-between h-16 px-6 border-b" style="border-color:rgba(255,255,255,0.06)">
        <a href="{{ route('parent.dashboard') }}" class="flex items-center gap-3" data-no-transition>
            <img src="/images/tlab-logo-white.png" alt="TLab" class="h-8 w-auto">
            <div>
                <div class="font-black text-sm text-white">TLab</div>
                <div class="text-[10px] font-bold uppercase tracking-widest" style="color:#16A34A">Parent Portal</div>
            </div>
        </a>
        <button @@click="sidebarOpen = false" class="lg:hidden p-1.5 rounded-lg hover:bg-white/5 text-white/50 hover:text-white">
            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/></svg>
        </button>
    </div>

    {{-- Nav --}}
    <nav class="p-4 space-y-1 overflow-y-auto" style="height:calc(100% - 140px)">
        @foreach($navItems as $route => [$label, $icon])
        @php $active = request()->routeIs($route) || request()->routeIs($route . '.*'); @endphp
        <a href="{{ route($route) }}"
           class="flex items-center gap-3 px-4 py-3 rounded-2xl text-sm font-bold transition-all"
           style="background:{{ $active ? 'rgba(22,163,74,0.12)' : 'transparent' }}; color:{{ $active ? '#16A34A' : 'rgba(255,255,255,0.5)' }}"
           onmouseover="this.style.background='{{ $active ? 'rgba(22,163,74,0.12)' : 'rgba(255,255,255,0.05)' }}'; this.style.color='{{ $active ? '#16A34A' : 'rgba(255,255,255,0.8)' }}'"
           onmouseout="this.style.background='{{ $active ? 'rgba(22,163,74,0.12)' : 'transparent' }}'; this.style.color='{{ $active ? '#16A34A' : 'rgba(255,255,255,0.5)' }}'">
            <svg class="w-5 h-5 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/></svg>
            {{ $label }}
        </a>
        @endforeach
    </nav>

    {{-- User section --}}
    <div class="absolute bottom-0 left-0 right-0 p-4 border-t" style="border-color:rgba(255,255,255,0.06); background:#0F172A">
        <div class="flex items-center gap-3 px-3 py-3 rounded-2xl" style="background:rgba(255,255,255,0.03)">
            <div class="w-9 h-9 rounded-xl flex items-center justify-center font-bold text-sm flex-shrink-0" style="background:rgba(22,163,74,0.15); color:#16A34A">
                {{ strtoupper(substr(auth()->user()->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="text-sm font-bold text-white truncate">{{ auth()->user()->name }}</div>
                <div class="text-[10px] font-semibold uppercase tracking-wider" style="color:rgba(255,255,255,0.3)">Parent</div>
            </div>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="p-2 rounded-lg hover:bg-white/5 text-white/30 hover:text-white/70 transition-all" title="Logout">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                </button>
            </form>
        </div>
    </div>
</aside>
