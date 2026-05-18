@extends('layouts.app')
@section('title', $club['name'] . ' — TLab')

@section('content')

@include('partials.nav')

{{-- Per-club hero images map --}}
@php
$heroImages = [
    'stem-club'  => '/images/club-stem.png',
    'brain-club' => '/images/club-brain.png',
    'art-craft'  => '/images/club-art.png',
    'leadership' => '/images/club-leadership.png',
];
$heroImg = $heroImages[$club['slug']] ?? $heroImages['stem-club'];
@endphp

{{-- Hero --}}
<section class="relative min-h-[65vh] flex items-end pt-20 overflow-hidden bg-ink">
    <div class="absolute inset-0 z-0 bg-slate-900">
        <img src="{{ $heroImg }}" alt="{{ $club['name'] }} African students" class="w-full h-full object-cover opacity-90 transition-opacity duration-300"
             onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
        <div class="absolute inset-0" style="background:linear-gradient(to top,#0F172A 35%,rgba(15,23,42,0.7) 65%,rgba(15,23,42,0.2) 100%)"></div>
        <div class="absolute inset-0 mix-blend-multiply opacity-30" style="background:{{ $club['gradient'] }}"></div>
    </div>

    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 relative z-10 w-full pb-20">
        <div class="flex flex-wrap gap-3 mb-6">
            <span class="bg-white/20 border border-white/30 text-white text-xs font-black px-4 py-1.5 rounded-full uppercase tracking-wider">Ages {{ $club['ages'] }}</span>
            <span class="bg-white/10 text-white/90 text-xs font-bold px-3 py-1.5 rounded-full border border-white/20">{{ $club['tagline'] }}</span>
        </div>
        <h1 class="font-black text-5xl sm:text-6xl lg:text-7xl text-white mb-5 leading-tight reveal">{{ $club['name'] }}</h1>
        <p class="text-white/75 font-semibold text-lg max-w-2xl reveal leading-relaxed">{{ $club['description'] }}</p>
        <div class="mt-8 reveal">
            <a href="{{ route('register') }}" class="btn-hero !px-10 inline-flex">
                Enrol in {{ $club['name'] }}
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
            </a>
        </div>
    </div>
</section>

{{-- Content --}}
<section class="py-24 bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="grid grid-cols-1 lg:grid-cols-3 gap-12">

            {{-- Main Content --}}
            <div class="lg:col-span-2 space-y-10">

                {{-- What They Learn --}}
                <div class="tcard p-8 sm:p-10 reveal">
                    <div class="flex items-center gap-4 mb-8">
                        <div class="w-11 h-11 rounded-2xl flex items-center justify-center border flex-shrink-0" style="background:{{ $club['bg'] }};border-color:{{ $club['color'] }}30">
                            <svg class="w-5 h-5" style="color:{{ $club['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $club['icon_path'] }}"/></svg>
                        </div>
                        <h2 class="font-black text-2xl sm:text-3xl text-ink">What Your Child Will Learn</h2>
                    </div>
                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
                        @foreach($club['what_learn'] as $item)
                        <div class="flex items-start gap-3 p-4 rounded-xl bg-surface border border-gray-100">
                            <svg class="w-4 h-4 flex-shrink-0 mt-0.5" style="color:{{ $club['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            <span class="text-ink font-bold text-sm leading-relaxed">{{ $item }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Banner image --}}
                <div class="rounded-3xl overflow-hidden h-56 sm:h-72 reveal bg-slate-100">
                    @php
                    $bannerImages = [
                        'stem-club'  => '/images/club-stem-banner.png',
                        'brain-club' => '/images/club-brain-banner.png',
                        'art-craft'  => '/images/club-art-banner.png',
                        'leadership' => '/images/club-leadership-banner.png',
                    ];
                    @endphp
                    <img src="{{ $bannerImages[$club['slug']] ?? $bannerImages['stem-club'] }}"
                         alt="{{ $club['name'] }} with African children in action"
                         class="w-full h-full object-cover transition-opacity duration-300"
                         onload="this.classList.remove('opacity-0')" onerror="this.style.display='none'">
                </div>

                {{-- Key Outcomes --}}
                <div class="tcard p-8 sm:p-10 reveal" data-delay="100">
                    <h2 class="font-black text-2xl sm:text-3xl text-ink mb-8">Key Learning Outcomes</h2>
                    <div class="space-y-4">
                        @foreach($club['outcomes'] as $outcome)
                        <div class="flex items-start gap-4 py-3 border-b border-gray-50 last:border-0">
                            <div class="w-6 h-6 rounded-lg flex items-center justify-center flex-shrink-0 mt-0.5 border" style="background:{{ $club['bg'] }};border-color:{{ $club['color'] }}30">
                                <svg class="w-3.5 h-3.5" style="color:{{ $club['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                            </div>
                            <span class="text-muted font-semibold text-sm leading-relaxed">{{ $outcome }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>

            {{-- Sidebar --}}
            <div class="space-y-6 lg:sticky lg:top-28 self-start">

                {{-- Schedule Card --}}
                <div class="tcard p-7 bg-surface border border-gray-100 reveal" data-delay="150">
                    <h3 class="font-black text-xl text-ink mb-6">Programme Details</h3>
                    <div class="space-y-5">
                        @foreach([
                            ['M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', 'Schedule', $club['schedule']],
                            ['M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z', 'Frequency', $club['sessions']],
                            ['M3 10h18M7 15h1m4 0h1m-7 4h12a3 3 0 003-3V8a3 3 0 00-3-3H6a3 3 0 00-3 3v8a3 3 0 003 3z', 'Pricing', $club['fee']],
                        ] as [$icon,$label,$val])
                        <div class="flex items-start gap-4">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 border" style="background:{{ $club['bg'] }};border-color:{{ $club['color'] }}30">
                                <svg class="w-4.5 h-4.5" style="color:{{ $club['color'] }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="{{ $icon }}"/></svg>
                            </div>
                            <div>
                                <div class="text-muted text-[0.62rem] font-black uppercase tracking-wider">{{ $label }}</div>
                                <div class="font-black text-sm text-ink mt-0.5">{{ $val }}</div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    <a href="{{ route('register') }}" class="btn-submit w-full text-center mt-8 inline-block py-4" style="background:{{ $club['color'] }}">
                        Enrol Now
                    </a>
                    <a href="{{ route('membership') }}" class="text-xs font-bold text-center text-muted hover:text-primary block mt-3 transition-colors">
                        View all pricing plans &rarr;
                    </a>
                </div>

                {{-- Other Clubs --}}
                <div class="tcard p-6 reveal" data-delay="220">
                    <h4 class="font-black text-sm text-ink mb-4 uppercase tracking-wider">Other Programmes</h4>
                    <div class="space-y-2">
                        @foreach(['stem-club'=>['STEM Club','#16A34A'],'brain-club'=>['Brain Club','#2563EB'],'art-craft'=>['Art & Craft','#EA580C'],'leadership'=>['Leadership Club','#7C3AED']] as $s=>[$n,$c])
                        @if($s !== $club['slug'])
                        <a href="{{ route('club.detail', $s) }}" class="flex items-center gap-3 p-3 rounded-xl hover:bg-surface transition-colors group">
                            <div class="w-2 h-2 rounded-full flex-shrink-0" style="background:{{ $c }}"></div>
                            <span class="font-bold text-sm text-muted group-hover:text-ink transition-colors">{{ $n }}</span>
                            <svg class="w-4 h-4 ml-auto text-muted group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
                        </a>
                        @endif
                        @endforeach
                    </div>
                </div>

            </div>
        </div>
    </div>
</section>

@include('partials.footer')

@endsection
