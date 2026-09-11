@extends('layouts.parent')
@section('title', 'Enrolment Confirmed')

@section('parent-content')
<nav class="sticky top-0 z-50 bg-white border-b border-gray-100 shadow-sm" x-data="{ mobileOpen: false }">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-18 py-3">
            <a href="{{ route('home') }}" class="flex-shrink-0" data-no-transition>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-8 sm:h-9 w-auto">
            </a>
            <div class="hidden sm:flex items-center gap-4">
                <span class="text-xs font-bold uppercase tracking-widest text-muted bg-surface px-4 py-2 rounded-full border border-gray-200">
                    Confirmed
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

    @include('parent.partials.stepper', ['step' => 5])

    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-8 sm:p-10 text-center">

        <div class="w-20 h-20 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-6 shadow-inner">
            <svg class="w-10 h-10 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
        </div>

        <h1 class="font-black text-2xl sm:text-3xl text-ink mb-3">Enrolment Confirmed!</h1>
        <p class="text-muted font-semibold text-sm sm:text-base max-w-md mx-auto mb-8">
            <strong class="text-ink">{{ $enrollment->child->name }}</strong> is now enrolled in
            <strong class="text-ink">{{ $enrollment->course->title }}</strong>.
        </p>

        <div class="bg-gray-50 rounded-2xl border border-gray-200 p-6 text-left mb-8 max-w-md mx-auto">
            <div class="space-y-3">
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-muted">Course</span>
                    <span class="font-bold text-ink">{{ $enrollment->course->title }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-muted">Student</span>
                    <span class="font-bold text-ink">{{ $enrollment->child->name }}</span>
                </div>
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-muted">Fee Paid</span>
                    <span class="font-bold text-ink">
                        @if($payment && $payment->status === 'paid')
                            ₦{{ number_format($payment->amount) }}
                        @else
                            Free
                        @endif
                    </span>
                </div>
                @if($payment && $payment->transaction_id)
                    <div class="flex justify-between items-center">
                        <span class="text-sm font-semibold text-muted">Reference</span>
                        <span class="font-mono text-xs text-muted">{{ $payment->reference }}</span>
                    </div>
                @endif
                <div class="flex justify-between items-center">
                    <span class="text-sm font-semibold text-muted">Status</span>
                    <span class="chip bg-emerald-100 text-emerald-700 font-bold text-xs">Paid &amp; Active</span>
                </div>
            </div>
        </div>

        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <a href="{{ route('parent.dashboard') }}"
               class="inline-flex items-center justify-center gap-3 bg-primary text-white px-8 py-4 rounded-2xl font-bold text-base hover:bg-primary/90 transition-all shadow-lg hover:shadow-xl hover:-translate-y-0.5">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                Go to Dashboard
            </a>
            <a href="{{ route('parent.courses.index') }}"
               class="inline-flex items-center justify-center gap-3 border-2 border-gray-200 hover:border-primary text-ink hover:text-primary px-8 py-4 rounded-2xl font-bold text-base transition-all">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                Explore More Courses
            </a>
        </div>
    </div>
</main>

<style>
    [x-cloak] { display: none !important; }
</style>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection