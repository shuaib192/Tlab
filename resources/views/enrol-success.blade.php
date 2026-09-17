@extends('layouts.app')

@section('title', 'Registration Received')
@section('description', 'Your registration for the TLab Foundational Skills Programme has been received.')

@section('content')
    <div class="min-h-screen bg-white text-ink font-sans flex flex-col">

        <nav class="sticky top-0 z-50 border-b border-gray-100 bg-white">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 py-4 flex items-center justify-between">
                <a href="{{ route('home') }}" class="flex items-center gap-2">
                    <img src="/images/tlab-logo-black.png" alt="TLab" class="h-8 w-auto">
                </a>
                <a href="{{ route('home') }}" class="text-sm font-bold text-muted hover:text-ink">Back to Home</a>
            </div>
        </nav>

        <section class="flex-1 flex items-center justify-center py-16 px-4 sm:px-6">
            <div class="max-w-xl w-full text-center">
                <div
                    class="mx-auto w-16 h-16 rounded-full bg-green-50 border-2 border-green-600 flex items-center justify-center mb-6">
                    <svg class="w-8 h-8 text-green-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7" />
                    </svg>
                </div>
                <h1 class="font-black text-3xl sm:text-4xl">Registration received.</h1>
                <p class="mt-4 text-lg text-muted">
                    Your payment was successful. The final class time and programme commencement details will be sent to
                    your email and WhatsApp number.
                </p>

                @if($registration)
                    <div class="mt-8 bg-white border border-gray-200 rounded-3xl p-6 text-left shadow-sm">
                        <div class="grid grid-cols-2 gap-5 text-sm">
                            <div>
                                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Child</div>
                                <div class="font-bold text-ink">{{ $registration->child_name }}</div>
                                <div class="text-xs text-muted">Age {{ $registration->child_age }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Programme</div>
                                <div class="font-bold text-ink">{{ $registration->programme }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Amount paid</div>
                                <div class="font-black text-lg text-ink">₦{{ number_format($registration->amount) }}</div>
                            </div>
                            <div>
                                <div class="text-xs font-bold text-muted uppercase tracking-wider mb-1">Reference</div>
                                <div class="font-mono text-xs font-bold text-ink">{{ $registration->reference }}</div>
                            </div>
                        </div>
                    </div>
                @endif

                <a href="{{ route('home') }}"
                    class="inline-block bg-ink text-white rounded-xl px-8 py-3.5 mt-8 text-base font-bold hover:bg-black">Return
                    to Home</a>
            </div>
        </section>

        <footer class="border-t border-gray-100 py-10">
            <div class="max-w-6xl mx-auto px-4 sm:px-6 text-center">
                <p class="text-xs text-muted">TLab by Edfrica · <a href="mailto:tlabadmin@edfrica.org"
                        class="hover:text-ink">tlabadmin@edfrica.org</a></p>
            </div>
        </footer>

    </div>
@endsection