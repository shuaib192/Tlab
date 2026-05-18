@extends('layouts.app')
@section('title', 'Our Story — TLab')

@section('content')

@include('partials.nav')

{{-- Hero Section with premium background image of kids collaborating on robotics --}}
<section class="relative min-h-[70vh] flex items-end pt-32 pb-24 overflow-hidden bg-ink">
    <div class="absolute inset-0 z-0 bg-gradient-to-br from-slate-900 to-ink">
        <img src="/images/about-hero.png"
             alt="African children learning in classroom" class="w-full h-full object-cover opacity-90 transition-opacity duration-300"
             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
        <div class="absolute inset-0" style="background:linear-gradient(to top,#0F172A 25%,rgba(15,23,42,0.7) 65%,rgba(15,23,42,0.2) 100%)"></div>
    </div>
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12 relative z-10 w-full">
        <span class="inline-block bg-primary/20 border border-primary/30 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-6 reveal">About TLab</span>
        <h1 class="font-black text-5xl sm:text-6xl lg:text-7xl text-white mb-6 leading-none reveal">
            Empowering the Next<br>Generation of <span class="text-primary">Innovators</span>
        </h1>
        <p class="text-white/70 font-semibold text-lg max-w-2xl reveal leading-relaxed">
            We build Africa's premier gamified STEM ecosystem, teaching kids to program, engineer, and lead through the power of play.
        </p>
    </div>
</section>

{{-- Premium Split-Panel Asymmetrical Mission & Vision section (NO GENERIC CARDS) --}}
<section class="py-28 bg-white overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="grid grid-cols-1 lg:grid-cols-2 gap-12 lg:gap-16">
            
            {{-- Mission Panel - Asymmetrical top-left radius, rich slate background, high contrast --}}
            <div class="relative group p-12 bg-slate-900 text-white shadow-[0_30px_70px_rgba(0,0,0,0.15)] transition-all duration-500 hover:-translate-y-2" 
                 style="border-top-left-radius: 4rem; border-bottom-right-radius: 1rem; border-top-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                <div class="absolute top-0 right-0 w-32 h-32 bg-primary/10 rounded-full blur-3xl opacity-50 group-hover:bg-primary/20 transition-all"></div>
                
                <div class="w-14 h-14 rounded-2xl bg-primary/10 border border-primary/20 flex items-center justify-center mb-8 text-primary shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/>
                    </svg>
                </div>
                
                <h2 class="font-black text-4xl text-white mb-5 tracking-tight">Our Mission</h2>
                <p class="text-white/75 font-semibold text-sm leading-relaxed mb-6">
                    To make high-quality, 21st-century technology education accessible, engaging, and safe for every African child. We foster curiosity, creativity, and confidence through immersive hands-on experiences.
                </p>
                <div class="flex items-center gap-2 text-primary font-black text-xs uppercase tracking-wider">
                    <span>Delivering Excellence</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

            {{-- Vision Panel - Asymmetrical bottom-right radius, rich indigo background, violet glow --}}
            <div class="relative group p-12 bg-indigo-950 text-white shadow-[0_30px_70px_rgba(0,0,0,0.15)] transition-all duration-500 hover:-translate-y-2" 
                 style="border-bottom-right-radius: 4rem; border-top-left-radius: 1rem; border-top-right-radius: 1rem; border-bottom-left-radius: 1rem;">
                <div class="absolute bottom-0 left-0 w-32 h-32 bg-violet/15 rounded-full blur-3xl opacity-50 group-hover:bg-violet/25 transition-all"></div>
                
                <div class="w-14 h-14 rounded-2xl bg-violet/10 border border-violet/20 flex items-center justify-center mb-8 text-violet shadow-inner">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/>
                    </svg>
                </div>
                
                <h2 class="font-black text-4xl text-white mb-5 tracking-tight">Our Vision</h2>
                <p class="text-white/75 font-semibold text-sm leading-relaxed mb-6">
                    To raise one million tech-fluent children across Africa by 2030, equipping them with the engineering mindsets and leadership traits required to thrive and lead in the global economy.
                </p>
                <div class="flex items-center gap-2 text-violet font-black text-xs uppercase tracking-wider">
                    <span>Shaping the Future</span>
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 5l7 7-7 7"/></svg>
                </div>
            </div>

        </div>
    </div>
</section>

{{-- Premium split image banner showing kids programing robotics --}}
<section class="grid grid-cols-1 md:grid-cols-2 gap-0 overflow-hidden min-h-[45vh]">
    <div class="relative h-64 md:h-auto bg-gradient-to-br from-green-950 to-emerald-800">
        <img src="/images/about-split1.png"
             alt="Children coding in STEM lab" class="w-full h-full object-cover opacity-90 transition-opacity duration-300"
             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
        <div class="absolute inset-0 bg-primary/10 mix-blend-multiply"></div>
    </div>
    <div class="relative h-64 md:h-auto bg-gradient-to-br from-blue-950 to-indigo-900">
        <img src="/images/about-split2.png"
             alt="Child programing on laptop" class="w-full h-full object-cover opacity-90 transition-opacity duration-300"
             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
        <div class="absolute inset-0 bg-accent/10 mix-blend-multiply"></div>
    </div>
</section>

{{-- Core Values (Redesigned with custom rounded layouts, borders, and no emojis) --}}
<section class="py-28 bg-surface border-t border-b border-gray-100">
    <div class="max-w-7xl mx-auto px-6 sm:px-8 lg:px-12">
        <div class="text-center mb-20">
            <span class="inline-block bg-violet/10 text-violet text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5 reveal">Foundations</span>
            <h2 class="font-black text-4xl sm:text-5xl text-ink reveal">Our Core Values</h2>
        </div>
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-8">
            @foreach([
                ['Child-First Safety',   '#16A34A', '#F0FDF4', 'Every challenge and interaction is designed for maximum safety, COPPA compliance, and parent peace of mind.', 'M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z'],
                ['Learn through Play',   '#2563EB', '#EFF6FF', 'We reject boring lectures. Kids learn fast and deeply when concepts are translated into gamified challenges.', 'M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.197-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118l-3.976-2.888c-.784-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z'],
                ['Inclusive Growth',     '#EA580C', '#FFF7ED', 'STEM is for every child. We design modules that match the unique pace, skill level, and native talent of learners.', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0zm6 3a2 2 0 11-4 0 2 2 0 014 0zM7 10a2 2 0 11-4 0 2 2 0 014 0z'],
                ['Future Leadership',    '#7C3AED', '#F5F3FF', 'Code is half the battle. We cultivate presentation, public speaking, and team-building instincts simultaneously.', 'M13 10V3L4 14h7v7l9-11h-7z'],
            ] as $i => [$title, $color, $bg, $desc, $icon])
            <div class="relative p-8 bg-white shadow-[0_20px_50px_rgba(0,0,0,0.02)] transition-all duration-300 hover:-translate-y-2 hover:shadow-[0_30px_70px_rgba(0,0,0,0.06)] border border-gray-100"
                 style="border-top-left-radius: 2rem; border-bottom-right-radius: 2rem; border-top-right-radius: 0.5rem; border-bottom-left-radius: 0.5rem;">
                <div class="w-12 h-12 rounded-xl flex items-center justify-center mb-6" style="background:{{ $bg }};border:1px solid {{ $color }}22">
                    <svg class="w-6 h-6" style="color:{{ $color }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                </div>
                <h3 class="font-black text-xl text-ink mb-3">{{ $title }}</h3>
                <p class="text-muted font-semibold text-xs leading-relaxed">{{ $desc }}</p>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- CTA Section --}}
<section class="py-24 bg-white text-center">
    <div class="max-w-3xl mx-auto px-6">
        <h2 class="font-black text-4xl text-ink mb-5 reveal">Ready to start their journey?</h2>
        <p class="text-muted font-semibold text-base mb-8 max-w-xl mx-auto reveal">Enrol your child now and watch them scale from Explorer to Master Inventor with TLab.</p>
        <a href="{{ route('register') }}" class="btn-hero inline-flex !px-10 reveal">Get Started Free</a>
    </div>
</section>

@include('partials.footer')

@endsection
