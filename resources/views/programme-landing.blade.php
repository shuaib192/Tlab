@extends('layouts.app')

@section('title', 'Foundational Skills Programme')
@section('description', 'Practical skills in coding, Python, digital design, reading, and writing through live online classes for ages 5–17.')

@push('styles')
<style>
    .landing-nav { background: rgba(255,255,255,.92); backdrop-filter: blur(10px); }
    .landing-hero { background: linear-gradient(180deg,#F8FAF5 0%,#FFFFFF 100%); }
    .landing-card { transition: transform .2s ease, box-shadow .2s ease; }
    .landing-card:hover { transform: translateY(-4px); box-shadow: 0 18px 40px -18px rgba(5,46,22,.25); }
    .landing-chip { border:1px solid #E7E5E4; background:#FAFAF9; color:#57534E; }
    .landing-cta { background:#16A34A; color:#fff; }
    .landing-cta:hover { background:#15803D; }
    .landing-outline { border:1.5px solid #16A34A; color:#15803D; }
    .landing-outline:hover { background:#F0FDF4; }
</style>
@endpush

@section('content')
<div class="min-h-screen bg-white text-ink font-sans">

    <nav class="landing-nav sticky top-0 z-50 border-b border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
            <a href="{{ route('home') }}" class="flex items-center gap-2">
                <img src="/images/tlab-logo-black.png" alt="TLab" class="h-8 w-auto">
            </a>
            <div class="flex items-center gap-6">
                <a href="#programmes" class="hidden sm:block text-sm font-bold text-muted hover:text-ink">Programmes</a>
                <a href="#details" class="hidden sm:block text-sm font-bold text-muted hover:text-ink">Details</a>
                <a href="{{ route('programme.enrol') }}" class="landing-cta rounded-xl px-5 py-2.5 text-sm font-bold">Register Your Child</a>
            </div>
        </div>
    </nav>

    <section class="landing-hero">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 py-20 sm:py-28 text-center">
            <span class="inline-block text-xs font-bold uppercase tracking-widest text-green-700 bg-green-50 border border-green-200 rounded-full px-4 py-1.5 mb-6">
                Live Online Programme for Ages 5–17
            </span>
            <h1 class="font-black text-4xl sm:text-5xl lg:text-6xl leading-tight max-w-3xl mx-auto">
                Practical Skills for <span class="text-green-600">Future-Ready</span> Children
            </h1>
            <p class="max-w-2xl mx-auto mt-6 text-lg text-muted">
                Give your child practical skills in coding, Python, digital design, reading, and writing through live online classes.
            </p>
            <div class="flex flex-wrap justify-center gap-3 mt-8">
                <span class="landing-chip rounded-xl px-4 py-2 text-sm font-bold">12 Weeks</span>
                <span class="landing-chip rounded-xl px-4 py-2 text-sm font-bold">Saturdays</span>
                <span class="landing-chip rounded-xl px-4 py-2 text-sm font-bold">1 Hour Weekly</span>
                <span class="landing-chip rounded-xl px-4 py-2 text-sm font-bold">Ages 5–17</span>
            </div>
            <p class="mt-6 text-sm font-bold text-amber-700">Registration closes 26 September 2026.</p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('programme.enrol') }}" class="landing-cta rounded-xl px-8 py-3.5 text-base font-bold">Register Your Child</a>
                <a href="#programmes" class="landing-outline rounded-xl px-8 py-3.5 text-base font-bold">See Programmes</a>
            </div>
        </div>
    </section>

    <section id="programmes" class="py-20 border-t border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6">
            <div class="text-center mb-12">
                <h2 class="font-black text-3xl sm:text-4xl">Choose a Programme</h2>
                <p class="mt-3 text-muted max-w-2xl mx-auto">Three age bands, one goal — learning that sticks because children learn by doing.</p>
            </div>

            <div class="grid md:grid-cols-3 gap-6">
                <div class="landing-card bg-white rounded-3xl border border-gray-200 p-8">
                    <span class="inline-block font-black text-sm text-green-700 bg-green-50 rounded-lg px-3 py-1.5 mb-4">Ages 5–7</span>
                    <h3 class="font-black text-xl mb-4">Early Explorers</h3>
                    <ul class="space-y-3 text-sm text-muted">
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Coding Foundations with ScratchJr</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Digital Creativity</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Reading Foundations</li>
                    </ul>
                </div>
                <div class="landing-card bg-white rounded-3xl border border-gray-200 p-8">
                    <span class="inline-block font-black text-sm text-green-700 bg-green-50 rounded-lg px-3 py-1.5 mb-4">Ages 8–11</span>
                    <h3 class="font-black text-xl mb-4">Young Builders</h3>
                    <ul class="space-y-3 text-sm text-muted">
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Scratch Programming</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Python Foundations</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Digital Design with Canva</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Creative Writing</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Reading Development</li>
                    </ul>
                </div>
                <div class="landing-card bg-white rounded-3xl border border-gray-200 p-8">
                    <span class="inline-block font-black text-sm text-green-700 bg-green-50 rounded-lg px-3 py-1.5 mb-4">Ages 12–17</span>
                    <h3 class="font-black text-xl mb-4">Teen Innovators</h3>
                    <ul class="space-y-3 text-sm text-muted">
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Python Programming</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Digital Design</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Writing and Authoring</li>
                        <li class="flex gap-2.5"><span class="text-green-600 font-black flex-shrink-0">✓</span>Reading Development</li>
                    </ul>
                </div>
            </div>

            <p class="mt-8 text-center text-sm text-muted italic">
                Each learner will complete practical activities and finish with a project or portfolio.
            </p>
            <div class="text-center mt-6">
                <a href="{{ route('programme.enrol') }}" class="landing-cta inline-block rounded-xl px-8 py-3.5 text-base font-bold">Secure a Place</a>
            </div>
        </div>
    </section>

    <section id="details" class="py-20 bg-green-50/50 border-t border-gray-100">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 grid lg:grid-cols-2 gap-12 items-center">
            <div>
                <h2 class="font-black text-3xl sm:text-4xl">Everything You Need to Know</h2>
                <ul class="mt-8 space-y-4 text-muted">
                    <li class="flex gap-3"><span class="text-green-600 font-black flex-shrink-0">✓</span>A 12-week structured online programme</li>
                    <li class="flex gap-3"><span class="text-green-600 font-black flex-shrink-0">✓</span>Live classes every Saturday</li>
                    <li class="flex gap-3"><span class="text-green-600 font-black flex-shrink-0">✓</span>One hour of class time weekly</li>
                    <li class="flex gap-3"><span class="text-green-600 font-black flex-shrink-0">✓</span>Class recordings when your child misses a session</li>
                    <li class="flex gap-3"><span class="text-green-600 font-black flex-shrink-0">✓</span>Progress report and certificate included</li>
                </ul>
                <p class="mt-6 text-sm font-bold text-amber-700">Programme begins soon — places are limited.</p>
            </div>
            <div class="bg-white rounded-3xl border border-gray-200 p-8 shadow-sm">
                <div class="text-xs font-bold uppercase tracking-widest text-muted mb-2">Fees</div>
                <div class="font-black text-3xl text-ink">₦10,000 <span class="text-base font-bold text-muted">monthly</span></div>
                <p class="text-sm text-muted mt-1">for three months — ₦30,000 total per programme</p>
                <div class="mt-6 border-t border-gray-100 pt-6 space-y-3 text-sm text-muted">
                    <div class="flex justify-between"><span>Duration</span><span class="font-bold text-ink">12 weeks</span></div>
                    <div class="flex justify-between"><span>Classes</span><span class="font-bold text-ink">Live · Saturdays</span></div>
                    <div class="flex justify-between"><span>Class length</span><span class="font-bold text-ink">1 hour weekly</span></div>
                    <div class="flex justify-between"><span>Certificate</span><span class="font-bold text-ink">Included</span></div>
                </div>
                <a href="{{ route('programme.enrol') }}" class="landing-cta block text-center rounded-xl px-8 py-3.5 mt-8 text-base font-bold">Secure a Place</a>
            </div>
        </div>
    </section>

    <section id="register" class="bg-ink text-white py-20">
        <div class="max-w-3xl mx-auto px-4 sm:px-6 text-center">
            <h2 class="font-black text-3xl sm:text-4xl">Ready to Get Started?</h2>
            <p class="mt-4 text-white/70">
                Reserve your child's place in the Foundational Skills Programme today. Registration closes on 26 September 2026.
            </p>
            <div class="mt-8 flex flex-wrap justify-center gap-3">
                <a href="{{ route('programme.enrol') }}" class="landing-cta rounded-xl px-8 py-3.5 text-base font-bold">Register and Pay</a>
            </div>
            <p class="mt-6 text-sm text-white/60">
                Questions? Email us at <a href="mailto:tlabadmin@edfrica.org" class="font-bold underline text-white hover:text-green-300">tlabadmin@edfrica.org</a>
            </p>
        </div>
    </section>

    <footer class="border-t border-gray-100 py-10">
        <div class="max-w-6xl mx-auto px-4 sm:px-6 flex flex-col sm:flex-row items-center justify-between gap-4">
            <div class="flex items-center gap-2 font-black">
                <svg class="w-5 h-5" fill="none" stroke="#16A34A" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                TLab by Edfrica
            </div>
            <p class="text-xs text-muted">Founded 2026 · Foundational Skills Programme · <a href="mailto:tlabadmin@edfrica.org" class="hover:text-ink">tlabadmin@edfrica.org</a></p>
        </div>
    </footer>

</div>
@endsection