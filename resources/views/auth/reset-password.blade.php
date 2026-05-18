@extends('layouts.app')

@section('title', 'Reset Password')

@section('content')
<div class="min-h-screen flex items-center justify-center p-8">
    <div class="w-full max-w-md">
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center mb-6" style="background:rgba(78,153,102,0.1); border:1px solid rgba(78,153,102,0.3)">
            <svg class="w-8 h-8 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.743 5.743L11 17H9v2H7v2H4a1 1 0 01-1-1v-2.586a1 1 0 01.293-.707l5.964-5.964A6 6 0 1121 9z"></path></svg>
        </div>

        <h2 class="font-display text-3xl font-bold mb-2">Reset your password</h2>
        <p class="text-cream/50 mb-8">Enter the 6-digit code sent to your email and choose a new password.</p>

        @if(session('success')) <div class="flash flash-success">{{ session('success') }}</div> @endif
        @if($errors->any()) <div class="flash flash-error">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div> @endif

        <form method="POST" action="{{ route('password.update') }}" class="space-y-5">
            @csrf
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">Email Address</label>
                <input type="email" name="email" value="{{ session('reset_email', old('email')) }}" required
                       class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream placeholder-cream/30
                              focus:outline-none focus:border-mint transition-all"
                       placeholder="parent@email.com">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">6-Digit Reset Code</label>
                <input type="text" name="code" maxlength="6" required
                       class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream placeholder-cream/30
                              focus:outline-none focus:border-mint focus:bg-mint/5 transition-all text-center text-2xl font-display tracking-[0.5em]"
                       placeholder="——————">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">New Password</label>
                <input type="password" name="password" required
                       class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream placeholder-cream/30
                              focus:outline-none focus:border-mint focus:bg-mint/5 transition-all"
                       placeholder="Minimum 8 characters">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">Confirm New Password</label>
                <input type="password" name="password_confirmation" required
                       class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream placeholder-cream/30
                              focus:outline-none focus:border-mint focus:bg-mint/5 transition-all"
                       placeholder="Re-enter password">
            </div>
            <button type="submit"
                    class="w-full py-4 rounded-xl font-bold text-white text-lg transition-all hover:scale-[1.02] active:scale-95"
                    style="background:linear-gradient(135deg,#4E9966,#2a6e44); box-shadow:0 8px 32px rgba(78,153,102,0.3)">
                Set New Password
            </button>
        </form>
    </div>
</div>
@endsection
