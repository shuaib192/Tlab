@extends('layouts.parent')
@section('title', 'Payment — ' . $enrollment->course->title)

@section('parent-content')
@include('parent.partials.flow-nav', ['label' => 'Payment'])

<main class="flow-body min-h-screen px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="max-w-3xl mx-auto">

        @include('parent.partials.stepper', ['step' => 4, 'club' => $enrollment->course->club])

        @if(session('error'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-xl border-2 border-[#1B1B1E] bg-[#FDECEC] font-bold text-sm mb-8" style="box-shadow:5px 5px 0 rgba(27,27,30,.12)">
                <svg class="w-5 h-5 text-[#DC2626] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @php
            $clubThemes = [
                'green'  => '#16A34A',
                'blue'   => '#2563EB',
                'orange' => '#EA580C',
                'violet' => '#7C3AED',
            ];
            $accent = $clubThemes[$enrollment->course->club->color_theme ?? 'green'] ?? $clubThemes['green'];
        @endphp

        <div class="paper-card p-6 sm:p-8 mb-8">
            <div class="flex items-center gap-3 mb-6 border-b-2 border-[#1B1B1E]/10 pb-5">
                <div class="w-10 h-10 rounded-lg border-2 border-[#1B1B1E] grid place-items-center bg-white" style="box-shadow:3px 3px 0 {{ $accent }}">
                    <svg class="w-5 h-5" style="color:{{ $accent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 9V7a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2m2 4h10a2 2 0 002-2v-6a2 2 0 00-2-2H9a2 2 0 00-2 2v6a2 2 0 002 2zm7-5a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                </div>
                <h1 class="font-black text-xl sm:text-2xl tracking-tight" style="color:#1B1B1E">Complete Your Enrolment</h1>
            </div>

            <div class="divide-y-2 divide-[#1B1B1E]/10">
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-black uppercase tracking-wide" style="color:#1B1B1E88">Course</span>
                    <span class="font-black text-[#1B1B1E]">{{ $enrollment->course->title }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-black uppercase tracking-wide" style="color:#1B1B1E88">Club</span>
                    <span class="font-black text-[#1B1B1E]">{{ $enrollment->course->club->name }}</span>
                </div>
                <div class="flex justify-between items-center py-3">
                    <span class="text-sm font-black uppercase tracking-wide" style="color:#1B1B1E88">Enrolling</span>
                    <span class="font-black text-[#1B1B1E]">{{ $enrollment->child->name }}</span>
                </div>
                @if($payment && $payment->reference)
                    <div class="flex justify-between items-center py-3">
                        <span class="text-sm font-black uppercase tracking-wide" style="color:#1B1B1E88">Reference</span>
                        <span class="font-mono text-xs font-bold text-[#1B1B1E99]">{{ $payment->reference }}</span>
                    </div>
                @endif
            </div>

            <div class="mt-6 rounded-xl border-2 border-[#1B1B1E] bg-[#1B1B1E] text-center p-6" style="box-shadow:6px 6px 0 {{ $accent }}">
                <p class="text-xs font-black uppercase tracking-widest mb-2" style="color:#ffffff88">Enrolment Fee</p>
                <p class="text-4xl sm:text-5xl font-black text-white mb-2">
                    @if($enrollment->course->fee)
                        ₦{{ number_format($enrollment->course->fee) }}
                    @else
                        Free
                    @endif
                </p>
                @if($enrollment->course->fee)
                    <p class="text-[11px] font-bold uppercase tracking-wide" style="color:#16A34A">Secure payment via Paystack</p>
                @endif
            </div>
        </div>

        <form method="POST" action="{{ route('parent.courses.pay', $enrollment) }}">
            @csrf
            @if($enrollment->course->fee)
                <button type="submit" class="btn-flat w-full py-4 text-base" style="background:{{ $accent }};border-color:{{ $accent }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    Pay ₦{{ number_format($enrollment->course->fee) }} Now
                </button>
            @else
                <button type="submit" class="btn-flat w-full py-4 text-base" style="background:{{ $accent }};border-color:{{ $accent }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                    Confirm Free Enrolment
                </button>
            @endif
        </form>
    </div>
</main>

@include('parent.partials.flow-styles')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection