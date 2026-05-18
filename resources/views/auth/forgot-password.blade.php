@extends('layouts.app')
@section('title', 'Reset Your Password')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4" style="background:linear-gradient(135deg,#F0FDF4 0%,#EFF6FF 50%,#F5F3FF 100%)">

    {{-- Back link --}}
    <a href="{{ route('login') }}" class="fixed top-6 left-6 flex items-center gap-2 text-sm font-bold text-muted hover:text-ink transition-colors">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Login
    </a>

    <div class="w-full max-w-md">

        {{-- Card --}}
        <div class="bg-white rounded-3xl shadow-xl border border-gray-100 p-10 sm:p-12">

            {{-- Logo --}}
            <div class="flex justify-center mb-8">
                <img src="/Tlab/public/images/tlab-logo-color.png" alt="TLab" class="h-10 w-auto">
            </div>

            {{-- Icon --}}
            <div class="w-16 h-16 bg-primary/10 rounded-2xl flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>

            <h1 class="font-black text-2xl sm:text-3xl text-ink text-center mb-2">Forgot your password?</h1>
            <p class="text-muted font-semibold text-sm text-center mb-8 leading-relaxed">
                No worries. Enter your email and we'll send you a 6-digit code to reset it.
            </p>

            @if(session('status'))
                <div class="flash flash-success mb-6">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="flash flash-error mb-6">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            @endif

            <form method="POST" action="{{ route('password.email') }}" class="space-y-5">
                @csrf
                <div>
                    <label class="form-label">Email Address</label>
                    <input type="email" name="email" value="{{ old('email') }}" required
                           class="form-input" placeholder="parent@email.com" autofocus>
                </div>

                <button type="submit" class="btn-submit">
                    Send Reset Code
                    <svg class="w-4 h-4 ml-2" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 7l5 5m0 0l-5 5m5-5H6"/></svg>
                </button>
            </form>

            <p class="text-center text-muted font-semibold text-sm mt-6">
                Remembered it?
                <a href="{{ route('login') }}" class="text-primary font-black hover:underline">Back to login</a>
            </p>
        </div>
    </div>
</div>
@endsection
