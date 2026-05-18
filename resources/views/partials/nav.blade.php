{{-- FLOATING PREMIUM NAVBAR --}}
<div class="fixed top-5 left-0 right-0 z-50 px-4 sm:px-6 lg:px-8 max-w-7xl mx-auto">
    <nav class="backdrop-blur-xl bg-ink/80 border border-white/10 rounded-2xl shadow-[0_20px_50px_rgba(0,0,0,0.3)] transition-all duration-300">
        <div class="px-6 sm:px-8">
            <div class="flex items-center justify-between h-20">
                
                {{-- Logo with subtle futuristic hover glow --}}
                <a href="{{ route('home') }}" class="group relative flex items-center" data-no-transition>
                    <div class="absolute -inset-1.5 bg-gradient-to-r from-primary to-accent rounded-lg blur opacity-25 group-hover:opacity-75 transition duration-500"></div>
                    <img src="/images/tlab-logo-white.png" alt="TLab" class="relative h-9 w-auto">
                </a>

                {{-- Interactive Nav Links --}}
                <div class="hidden md:flex items-center gap-8">
                    <a href="{{ route('about') }}" class="relative py-2 text-xs font-black uppercase tracking-wider text-white/70 hover:text-white transition-colors duration-300 {{ request()->routeIs('about') ? 'text-white border-b-2 border-primary' : '' }}">
                        Our Story
                    </a>
                    
                    {{-- Dropdown wrapped in highly polished layout --}}
                    <div class="relative group py-2">
                        <button class="flex items-center gap-1.5 text-xs font-black uppercase tracking-wider text-white/70 hover:text-white transition-colors duration-300">
                            STEM Clubs
                            <svg class="w-3 h-3 transition-transform duration-300 group-hover:rotate-180" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M19 9l-7 7-7-7"/>
                            </svg>
                        </button>
                        <div class="absolute top-[100%] left-1/2 -translate-x-1/2 mt-2 w-56 rounded-2xl bg-ink/95 border border-white/10 p-2 shadow-[0_20px_40px_rgba(0,0,0,0.5)] backdrop-blur-2xl opacity-0 pointer-events-none group-hover:opacity-100 group-hover:pointer-events-auto transition-all duration-300 transform translate-y-2 group-hover:translate-y-0 z-50">
                            <a href="{{ route('club.detail', 'stem-club') }}" class="block px-4 py-3 text-xs font-bold text-white/70 hover:text-white hover:bg-white/5 rounded-xl transition-all">STEM Club</a>
                            <a href="{{ route('club.detail', 'brain-club') }}" class="block px-4 py-3 text-xs font-bold text-white/70 hover:text-white hover:bg-white/5 rounded-xl transition-all">Brain Club</a>
                            <a href="{{ route('club.detail', 'art-craft') }}" class="block px-4 py-3 text-xs font-bold text-white/70 hover:text-white hover:bg-white/5 rounded-xl transition-all">Art &amp; Craft</a>
                            <a href="{{ route('club.detail', 'leadership') }}" class="block px-4 py-3 text-xs font-bold text-white/70 hover:text-white hover:bg-white/5 rounded-xl transition-all">Leadership Club</a>
                            <div class="border-t border-white/10 my-1"></div>
                            <a href="{{ route('clubs') }}" class="block px-4 py-2.5 text-[0.7rem] font-black text-primary hover:text-white hover:bg-primary/20 rounded-xl transition-all text-center">All Programmes</a>
                        </div>
                    </div>

                    <a href="{{ route('membership') }}" class="relative py-2 text-xs font-black uppercase tracking-wider text-white/70 hover:text-white transition-colors duration-300 {{ request()->routeIs('membership') ? 'text-white border-b-2 border-primary' : '' }}">
                        Pricing
                    </a>
                    
                    <a href="{{ route('contact') }}" class="relative py-2 text-xs font-black uppercase tracking-wider text-white/70 hover:text-white transition-colors duration-300 {{ request()->routeIs('contact') ? 'text-white border-b-2 border-primary' : '' }}">
                        Contact
                    </a>
                </div>

                {{-- Action Panel --}}
                <div class="hidden md:flex items-center gap-5">
                    @auth
                        <a href="{{ route('parent.dashboard') }}" class="relative inline-flex items-center justify-center p-0.5 mb-2 mr-2 overflow-hidden text-xs font-black uppercase tracking-wider text-white rounded-xl group bg-gradient-to-br from-primary to-accent group-hover:from-primary group-hover:to-accent hover:text-white focus:ring-4 focus:outline-none focus:ring-green-800">
                            <span class="relative px-5 py-2.5 transition-all ease-in duration-75 bg-ink rounded-xl group-hover:bg-opacity-0">
                                Dashboard
                            </span>
                        </a>
                    @else
                        <a href="{{ route('login') }}" class="text-xs font-black uppercase tracking-wider text-white/70 hover:text-white transition-colors duration-300">Login</a>
                        <a href="{{ route('register') }}" class="relative px-6 py-3 overflow-hidden text-xs font-black uppercase tracking-wider text-white bg-primary rounded-xl transition-all duration-300 hover:bg-primary/90 hover:shadow-[0_0_20px_rgba(22,163,74,0.4)]">
                            Enrol Now
                        </a>
                    @endauth
                </div>

                {{-- Hamburger for Mobile --}}
                <button id="hamburger" class="md:hidden text-white/80 hover:text-white p-2 transition-colors">
                    <svg class="w-6 h-6" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M4 6h16M4 12h16M4 18h16"/>
                    </svg>
                </button>
            </div>
        </div>

        {{-- Mobile Menu with elegant slide down --}}
        <div id="mobile-nav" class="md:hidden overflow-hidden transition-all duration-300 ease-in-out rounded-b-2xl bg-ink/95 border-t border-white/5" style="max-height: 0px;">
            <div class="px-6 py-6 space-y-4">
                <a href="{{ route('about') }}" class="block font-black text-xs uppercase tracking-wider text-white/70 hover:text-white py-2">Our Story</a>
                <a href="{{ route('clubs') }}" class="block font-black text-xs uppercase tracking-wider text-white/70 hover:text-white py-2">STEM Clubs</a>
                <a href="{{ route('membership') }}" class="block font-black text-xs uppercase tracking-wider text-white/70 hover:text-white py-2">Pricing</a>
                <a href="{{ route('contact') }}" class="block font-black text-xs uppercase tracking-wider text-white/70 hover:text-white py-2">Contact</a>
                <div class="pt-4 border-t border-white/10 flex flex-col gap-3">
                    @auth
                        <a href="{{ route('parent.dashboard') }}" class="w-full text-center py-3 rounded-xl bg-gradient-to-r from-primary to-accent text-xs font-black uppercase tracking-wider text-white shadow-lg">Dashboard</a>
                    @else
                        <a href="{{ route('login') }}" class="w-full text-center py-3 rounded-xl border border-white/20 text-xs font-black uppercase tracking-wider text-white/80 hover:text-white transition-colors">Login</a>
                        <a href="{{ route('register') }}" class="w-full text-center py-3 rounded-xl bg-primary text-xs font-black uppercase tracking-wider text-white shadow-lg">Enrol Now</a>
                    @endauth
                </div>
            </div>
        </div>
    </nav>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    const hamburger = document.getElementById('hamburger');
    const mobileNav = document.getElementById('mobile-nav');
    if (hamburger && mobileNav) {
        // Remove global app.js/layout click overrides on hamburger to use our master control
        const newHamburger = hamburger.cloneNode(true);
        hamburger.parentNode.replaceChild(newHamburger, hamburger);

        newHamburger.addEventListener('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            if (mobileNav.style.maxHeight === '0px' || !mobileNav.style.maxHeight) {
                mobileNav.style.maxHeight = mobileNav.scrollHeight + 'px';
                mobileNav.classList.add('border-t');
            } else {
                mobileNav.style.maxHeight = '0px';
                setTimeout(() => {
                    if (mobileNav.style.maxHeight === '0px') {
                        mobileNav.classList.remove('border-t');
                    }
                }, 300);
            }
        });
    }
});
</script>
