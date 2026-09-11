@extends('layouts.parent')
@section('title', 'Payment — ' . $enrollment->course->title)

@section('parent-content')
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">
            <a href="{{ route('home') }}" class="flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-8 sm:h-9 w-auto">
            </a>
            <div class="hidden sm:flex items-center gap-4">
                <span class="text-xs font-bold uppercase tracking-widest text-muted bg-surface px-4 py-2 rounded-full border border-gray-200">
                    Payment
                </span>
                <span class="text-sm font-semibold text-muted">
                    Hello, <strong class="text-ink">{{ auth()->user()->name }}</strong>
                </span>
                <a href="{{ route('parent.dashboard') }}"
                   class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all shadow-sm hover:shadow-md">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Dashboard
                </a>
                <form method="POST" action="{{ route('logout') }}" class="inline">
                    @csrf
                    <button class="text-sm font-bold text-muted hover:text-ink border-2 border-gray-200 hover:border-gray-300 px-4 py-2.5 rounded-xl transition-all">
                        Logout
                    </button>
                </form>
            </div>
            <button @click="mobileOpen = !mobileOpen" class="sm:hidden p-2 rounded-xl hover:bg-gray-100">
                <svg class="w-6 h-6 text-ink" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path x-show="!mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                    <path x-show="mobileOpen" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"/>
                </svg>
            </button>
        </div>
    </div>
</nav>

<main class="max-w-3xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    @include('parent.partials.stepper', ['step' => 4])

    @if(session('error'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-red-50 border border-red-200 text-red-700 font-bold text-sm mb-8 animate-slideDown">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
            {{ session('error') }}
        </div>
    @endif

    {{-- Course Summary --}}
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 mb-8">
        <div class="flex items-center gap-3 mb-5 pb-5 border-b border-gray-100">
            <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h1 class="font-black text-xl sm:text-2xl text-ink">Complete Your Enrolment</h1>
        </div>

        <div class="space-y-4 mb-8">
            <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-muted">Course</span>
                <span class="font-bold text-ink">{{ $enrollment->course->title }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-muted">Club</span>
                <span class="font-bold text-ink">{{ $enrollment->course->club->name }}</span>
            </div>
            <div class="flex justify-between items-center">
                <span class="text-sm font-semibold text-muted">Enrolling</span>
                <span class="font-bold text-ink">{{ $enrollment->child->name }}</span>
            </div>
            @if($payment && $payment->reference)
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-muted">Reference</span>
                    <span class="font-mono text-xs text-muted">{{ $payment->reference }}</span>
                </div>
            @endif
        </div>

        <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-6 border border-primary/20 text-center mb-8">
            <p class="text-sm font-semibold text-muted mb-2">Enrolment Fee</p>
            <p class="text-3xl sm:text-4xl font-black text-primary mb-2">
                @if($enrollment->course->fee)
                    ₦{{ number_format($enrollment->course->fee) }}
                @else
                    Free
                @endif
            </p>
            @if($enrollment->course->fee)
                <p class="text-xs text-muted">Secure payment powered by Paystack</p>
            @endif
        </div>

        <form method="POST" action="{{ route('parent.courses.pay', $enrollment) }}">
            @csrf
            @if($enrollment->course->fee)
                <button type="submit"
                        class="w-full py-4 rounded-2xl font-bold text-white text-base transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg hover:shadow-xl flex items-center justify-center gap-3 bg-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Pay ₦{{ number_format($enrollment->course->fee) }} Now
                </button>
            @else
                <button type="submit"
                        class="w-full py-4 rounded-2xl font-bold text-white text-base transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg hover:shadow-xl flex items-center justify-center gap-3 bg-primary">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Confirm Free Enrolment
                </button>
            @endif
        </form>
    </div>
</main>

<style>
    @keyframes slideDown {
        from { opacity: 0; transform: translateY(-10px); }
        to   { opacity: 1; transform: translateY(0); }
    }
    .animate-slideDown { animation: slideDown 0.3s ease-out; }
    [x-cloak] { display: none !important; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection
