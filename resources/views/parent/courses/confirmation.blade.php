@extends('layouts.parent')
@section('title', 'Enrolment Confirmed')

@section('parent-content')
@include('parent.partials.flow-nav', ['label' => 'Confirmation'])

<main class="flow-body min-h-screen px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="max-w-3xl mx-auto">

        @include('parent.partials.stepper', ['step' => 5, 'club' => $enrollment->course->club])

        <div class="paper-card p-8 sm:p-10 text-center">
            <div class="w-20 h-20 mx-auto mb-6 rounded-full border-2 border-[#1B1B1E] bg-[#16A34A] grid place-items-center shadow-md">
                <svg class="w-10 h-10 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
            </div>

            <span class="paper-tag bg-[#16A34A] mb-4">Enrolment Confirmed</span>
            <h1 class="font-black text-3xl sm:text-4xl tracking-tight mt-2 mb-3" style="color:#1B1B1E">You're All Set!</h1>
            <p class="font-semibold text-sm sm:text-base max-w-md mx-auto mb-8" style="color:#1B1B1E99">
                <b style="color:#1B1B1E">{{ $enrollment->child->name }}</b> is enrolled in
                <b style="color:#1B1B1E">{{ $enrollment->course->title }}</b>. Learning can start right away.
            </p>

            <div class="max-w-md mx-auto mb-8 rounded-xl border-2 border-[#1B1B1E] bg-[#FAF7F0] p-6 text-left">
                <div class="divide-y-2 divide-[#1B1B1E]/10">
                    <div class="flex justify-between items-center py-2.5">
                        <span class="text-xs font-black uppercase tracking-wide" style="color:#1B1B1E88">Course</span>
                        <span class="font-black text-sm text-[#1B1B1E]">{{ $enrollment->course->title }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5">
                        <span class="text-xs font-black uppercase tracking-wide" style="color:#1B1B1E88">Student</span>
                        <span class="font-black text-sm text-[#1B1B1E]">{{ $enrollment->child->name }}</span>
                    </div>
                    <div class="flex justify-between items-center py-2.5">
                        <span class="text-xs font-black uppercase tracking-wide" style="color:#1B1B1E88">Fee Paid</span>
                        <span class="font-black text-sm text-[#1B1B1E]">
                            @if($payment && $payment->status === 'paid')
                                ₦{{ number_format($payment->amount) }}
                            @else
                                Free
                            @endif
                        </span>
                    </div>
                    @if($payment && $payment->transaction_id)
                        <div class="flex justify-between items-center py-2.5">
                            <span class="text-xs font-black uppercase tracking-wide" style="color:#1B1B1E88">Reference</span>
                            <span class="font-mono text-xs font-bold text-[#1B1B1E99]">{{ $payment->reference }}</span>
                        </div>
                    @endif
                    <div class="flex justify-between items-center py-2.5">
                        <span class="text-xs font-black uppercase tracking-wide" style="color:#1B1B1E88">Status</span>
                        <span class="paper-chip bg-[#16A34A] text-white">
                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                            Paid &amp; Active
                        </span>
                    </div>
                </div>
            </div>

            <div class="flex flex-col sm:flex-row gap-3 justify-center">
                <a href="{{ route('parent.dashboard') }}" class="btn-flat">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/></svg>
                    Go to Dashboard
                </a>
                <a href="{{ route('parent.courses.index') }}" class="btn-flat soft">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M17 8l4 4m0 0l-4 4m4-4H3"/></svg>
                    Explore More Courses
                </a>
            </div>
        </div>
    </div>
</main>

@include('parent.partials.flow-styles')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection