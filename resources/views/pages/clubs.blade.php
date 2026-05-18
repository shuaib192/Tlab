@extends('layouts.app')
@section('title', 'Our STEM Clubs & Programmes — TLab')

@section('content')

@include('partials.nav')

{{-- Hero --}}
<section class="relative min-h-[55vh] flex items-end pt-20 overflow-hidden bg-ink">
    <div class="absolute inset-0 z-0 bg-gradient-to-br from-indigo-900 to-slate-900">
        <img src="/images/clubs-hero.png"
             alt="African children in STEM class" class="w-full h-full object-cover opacity-90 transition-opacity duration-300"
             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
        <div class="absolute inset-0" style="background:linear-gradient(to top,#0F172A 35%,rgba(15,23,42,0.6) 68%,rgba(15,23,42,0.2) 100%)"></div>
    </div>
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full pb-20">
        <span class="inline-block bg-primary/20 text-primary text-xs font-black uppercase tracking-widest px-5 py-2 rounded-full mb-5 reveal">Our Programmes</span>
        <h1 class="font-black text-5xl sm:text-6xl lg:text-7xl text-white mb-4 leading-tight reveal">
            Discover Our <span class="text-primary">STEM Clubs</span>
        </h1>
        <p class="text-white/70 font-semibold text-lg max-w-2xl reveal leading-relaxed">
            Four world-class learning tracks — tailored by age, interest and skill level — for children aged 3 to 15.
        </p>
    </div>
</section>

{{-- Club Cards with Images --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        @php
        $clubImages = [
            'stem-club'  => '/images/club-stem.png',
            'brain-club' => '/images/club-brain.png',
            'art-craft'  => '/images/club-art.png',
            'leadership' => '/images/club-leadership.png',
        ];
        @endphp

        <div class="space-y-8">
            @foreach($clubs as $slug => $c)
            @php $isEven = $loop->iteration % 2 === 0; @endphp
            <div class="tcard overflow-hidden reveal group">
                <div class="flex flex-col {{ $isEven ? 'lg:flex-row-reverse' : 'lg:flex-row' }}">

                    {{-- Image Half --}}
                    <div class="relative w-full lg:w-2/5 h-64 lg:h-auto overflow-hidden flex-shrink-0 bg-slate-900">
                        <img src="{{ $clubImages[$slug] }}" alt="{{ $c['name'] }}"
                             class="w-full h-full object-cover transition-transform duration-700 group-hover:scale-105 opacity-90 transition-opacity duration-300"
                             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
                        <div class="absolute inset-0" style="background:{{ $c['gradient'] }};opacity:0.55"></div>
                        <div class="absolute inset-0 flex flex-col justify-end p-8">
                            <span class="text-white/70 text-xs font-bold uppercase tracking-widest border border-white/30 px-3 py-1 rounded-full w-fit mb-3">Ages {{ $c['ages'] }}</span>
                            <div class="font-black text-4xl text-white leading-tight">{{ $c['name'] }}</div>
                            <div class="text-white/70 font-semibold text-sm mt-1">{{ $c['tagline'] }}</div>
                        </div>
                    </div>

                    {{-- Content Half --}}
                    <div class="flex-1 p-8 sm:p-10 lg:p-12 flex flex-col justify-between">
                        <div>
                            <p class="text-muted font-semibold text-sm leading-relaxed mb-8 max-w-lg">{{ $c['description'] }}</p>

                            <div class="grid grid-cols-2 gap-3 mb-8">
                                @foreach(array_slice($c['what_learn'], 0, 4) as $skill)
                                <div class="flex items-center gap-2">
                                    <div class="w-1.5 h-1.5 rounded-full flex-shrink-0" style="background:{{ $c['color'] }}"></div>
                                    <span class="text-ink font-bold text-xs">{{ $skill }}</span>
                                </div>
                                @endforeach
                            </div>
                        </div>

                        <div class="flex flex-wrap items-center gap-4 pt-6 border-t border-gray-100">
                            <a href="{{ route('club.detail', $slug) }}"
                               class="inline-flex items-center gap-2 px-7 py-3.5 rounded-xl font-black text-white text-sm transition-all hover:opacity-90 hover:-translate-y-0.5"
                               style="background:{{ $c['color'] }}">
                                View Full Curriculum
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                            </a>
                            <a href="{{ route('register') }}" class="text-sm font-black text-muted hover:text-primary transition-colors">
                                Enrol Now &rarr;
                            </a>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>

{{-- Bottom CTA --}}
<section class="py-20 bg-surface text-center border-t border-gray-100">
    <div class="max-w-2xl mx-auto px-4">
        <h2 class="font-black text-3xl sm:text-4xl text-ink mb-4 reveal">Not sure which club to pick?</h2>
        <p class="text-muted font-semibold text-sm mb-8 reveal">Our admissions team will assess your child's interests and skill level to recommend the perfect programme.</p>
        <a href="{{ route('contact') }}" class="btn-outline !border-gray-300 !text-ink hover:!border-primary hover:!text-primary inline-flex !px-10 reveal">
            Talk to Admissions
        </a>
    </div>
</section>

@include('partials.footer')

@endsection
