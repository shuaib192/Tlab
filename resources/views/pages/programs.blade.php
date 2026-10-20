@extends('layouts.app')
@section('title', 'STEAM Programs & Growth Lines — TLab')
@section('description', 'Five evolutionary STEAM disciplines — Science, Technology, Engineering, Arts, Mathematics — engineered as a living Growth Line from ages 3 to 18 at TLab by Edfrica.')

@push('styles')
@include('partials.brand-styles')
@endpush

@section('content')

<div class="brand-page min-h-screen">

    @include('partials.nav')

    {{-- ═══ HERO ═══════════════════════════════════════════ --}}
    <header class="pt-40 pb-16 px-4 sm:px-6 lg:px-8">
        <div class="max-w-7xl mx-auto">
            <div class="brand-kicker mb-5">STEAM Programs</div>
            <h1 class="brand-title text-[clamp(2.5rem,6vw,4.5rem)] max-w-4xl">
                Five disciplines.<br>One <span style="color:#0DAA9C">growth line</span>.
            </h1>
            <p class="mt-6 text-lg leading-relaxed max-w-3xl" style="color:#5B6B69">
                Science, Technology, Engineering, Arts and Mathematics — engineered as a single
                progressive pathway that carries your child from first finger-paint logic to
                confident, real-world problem solving. Ages 3 to 18.
            </p>

            <div class="flex flex-wrap gap-3 mt-8">
                <span class="brand-pill">Ages 3–18</span>
                <span class="brand-pill">5 disciplines</span>
                <span class="brand-pill">{{ $programs->sum(fn($p) => $p->growthStages->count()) }} growth nodes</span>
            </div>
        </div>
    </header>

    {{-- ═══ PROGRAM CARDS ══════════════════════════════════ --}}
    <section class="px-4 sm:px-6 lg:px-8 pb-24">
        <div class="max-w-7xl mx-auto">
            <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-8">
                @forelse($programs as $p)
                <div class="brand-card p-8 flex flex-col">
                    <div class="flex items-center justify-between mb-6">
                        <span class="brand-chip">{{ $p->discipline }}</span>
                        <span class="text-sm font-black" style="color:#DDE4E3">{{ sprintf('%02d', $loop->iteration) }}</span>
                    </div>

                    <h2 class="brand-title text-2xl mb-2">{{ $p->name }}</h2>
                    <p class="text-sm font-bold mb-5" style="color:#0DAA9C">{{ $p->tagline }}</p>

                    <p class="text-sm leading-relaxed mb-8 flex-1" style="color:#5B6B69">
                        {{ \Illuminate\Support\Str::limit($p->description, 170) }}
                    </p>

                    <div class="mb-7">
                        <div class="flex items-center justify-between mb-3 text-xs font-bold uppercase tracking-wider" style="color:#9AA8A6">
                            <span>Growth nodes</span>
                            <span>{{ $p->growthStages->count() }} · ages {{ $p->ages }}</span>
                        </div>
                        <div class="flex gap-1.5">
                            @for($i = 1; $i <= max(5, $p->growthStages->count()); $i++)
                                <span class="h-2 flex-1 rounded-full" style="background:{{ $i <= $p->growthStages->count() ? '#0DAA9C' : '#E8EFEE' }}"></span>
                            @endfor
                        </div>
                    </div>

                    <a href="{{ route('programs.show', $p->slug) }}" class="brand-btn w-full">
                        View programme
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    </a>
                </div>

                @if($loop->first)
                <div class="brand-card p-8 flex flex-col justify-center" style="background:#0F201E; border-color:#0F201E;">
                    <div class="text-[.7rem] font-black tracking-[.24em] uppercase mb-4" style="color:#5BEBDB">How it works</div>
                    <h2 class="text-2xl font-black mb-4 text-white leading-tight">A living curriculum that grows with your child.</h2>
                    <p class="text-sm leading-relaxed mb-8" style="color:rgba(255,255,255,.6)">
                        Each discipline is broken into age-band nodes. Skills build, milestones unlock,
                        and nothing repeats — your child moves forward at their own pace, with clear
                        goals at every stage.
                    </p>
                    <a href="{{ route('contact') }}" class="brand-btn" style="background:#0DAA9C; border-color:#0DAA9C;">Talk to our team</a>
                </div>
                @endif

                @empty
                <div class="col-span-full py-24 text-center brand-card">
                    <p class="font-bold" style="color:#5B6B69">Programmes are being finalised. Please check back soon.</p>
                </div>
                @endforelse
            </div>
        </div>
    </section>

    {{-- ═══ CTA ════════════════════════════════════════════ --}}
    <section class="px-4 sm:px-6 lg:px-8 pb-32">
        <div class="max-w-4xl mx-auto brand-card p-12 text-center" style="background:#0F201E; border-color:#0F201E;">
            <div class="text-[.7rem] font-black tracking-[.24em] uppercase mb-4" style="color:#5BEBDB">Ready to start?</div>
            <h2 class="text-3xl sm:text-4xl font-black text-white mb-8 leading-tight">
                Find the right programme for your child.
            </h2>
            <div class="flex flex-wrap justify-center gap-4">
                <a href="{{ route('contact') }}" class="brand-btn soft">Talk to us</a>
                <a href="{{ route('register') }}" class="brand-btn" style="background:#0DAA9C; border-color:#0DAA9C;">Create an account</a>
            </div>
        </div>
    </section>
</div>

@include('partials.footer')

@endsection
