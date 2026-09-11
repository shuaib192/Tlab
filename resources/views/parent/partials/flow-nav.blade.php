@php $userName = explode(' ', auth()->user()->name)[0]; @endphp
<nav class="sticky top-0 z-50 bg-[#F6F2E9]/95 backdrop-blur border-b-2 border-[#1B1B1E]" x-data="{ open: false }">
    <div class="max-w-6xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <a href="{{ route('home') }}" class="flex items-center gap-2 flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-8 w-auto">
            </a>
            <div class="hidden md:flex items-center gap-3">
                <span class="paper-tag">{{ $label }}</span>
                <span class="text-xs font-bold" style="color:#1B1B1Eaa">Hello, <b style="color:#1B1B1E">{{ $userName }}</b></span>
                <a href="{{ route('parent.dashboard') }}" class="btn-flat" style="padding:.55rem 1rem;font-size:.74rem">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="btn-flat soft" style="padding:.55rem 1rem;font-size:.74rem">Logout</button>
                </form>
            </div>
            <div class="md:hidden flex items-center gap-2">
                <a href="{{ route('parent.dashboard') }}" class="btn-flat" style="padding:.5rem .85rem;font-size:.7rem">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <button @click="open = !open" class="btn-flat soft" style="padding:.5rem .85rem">
                    <svg x-show="!open" class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/></svg>
                    <svg x-show="open" x-cloak class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M6 18L18 6M6 6l12 12"/></svg>
                </button>
            </div>
        </div>
        <div x-show="open" x-cloak class="md:hidden pb-4 space-y-2 border-t-2 border-[#1B1B1E]/10 pt-3">
            <span class="paper-tag">{{ $label }}</span>
            <span class="block text-xs font-bold" style="color:#1B1B1Eaa">Hello, <b style="color:#1B1B1E">{{ $userName }}</b></span>
            <form method="POST" action="{{ route('logout') }}">
                @csrf
                <button class="btn-flat soft w-full">Logout</button>
            </form>
        </div>
    </div>
</nav>