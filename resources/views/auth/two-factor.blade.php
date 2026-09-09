@extends('layouts.app')
@section('title', 'Two-Factor Verification')

@section('content')

{{-- Back to Home --}}
<a href="{{ route('home') }}"
   class="fixed top-5 left-5 z-50 flex items-center gap-2 text-xs font-black tracking-wider uppercase px-4 py-2 rounded-full transition-all"
   style="background:rgba(255,255,255,0.12);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.2);color:rgba(255,255,255,0.7)"
   onmouseover="this.style.color='#fff';this.style.background='rgba(255,255,255,0.2)'"
   onmouseout="this.style.color='rgba(255,255,255,0.7)';this.style.background='rgba(255,255,255,0.12)'">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Home
</a>

<div class="min-h-screen flex">

    {{-- ── Left Panel ── --}}
    <div class="hidden lg:flex flex-col justify-between w-[48%] relative overflow-hidden p-14"
         style="background:linear-gradient(145deg,#052e16 0%,#14532d 55%,#16A34A 100%)">

        <div class="absolute w-[500px] h-[500px] rounded-full blur-[80px] opacity-20 -top-32 -left-32" style="background:#4ade80"></div>

        <div class="relative z-10">
            <img src="/images/tlab-logo-white.png" alt="TLab" class="h-11 w-auto">
            <p class="text-white/40 text-sm font-semibold mt-2">by Edfrica</p>
        </div>

        <div class="relative z-10">
            <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-6" style="background:rgba(255,255,255,0.1);border:1px solid rgba(255,255,255,0.18)">
                <svg class="w-7 h-7 text-white/80" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
            </div>
            <h2 class="font-black text-4xl text-white leading-[1.15] mb-4">
                Two-factor<br>security is on.
            </h2>
            <p class="text-white/50 text-sm font-semibold max-w-sm">
                Enter the 6-digit code sent to your email to finish signing in. Codes expire after 10 minutes.
            </p>
        </div>

        <p class="text-white/20 text-xs font-semibold relative z-10">&copy; {{ date('Y') }} Edfrica. All rights reserved.</p>
    </div>

    {{-- ── Right: Code Form ── --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-white overflow-y-auto">
        <div class="w-full max-w-[420px] py-8">

            <div class="lg:hidden mb-10">
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-10 w-auto">
            </div>

            <h1 class="font-black text-3xl sm:text-4xl text-ink mb-1.5 leading-tight">Check your inbox</h1>
            <p class="text-muted font-semibold text-sm mb-8">
                We sent a 6-digit code to <span class="font-black text-ink">{{ $user->email }}</span>.
            </p>

            {{-- Flash messages --}}
            @if(session('status'))
                <div class="flash flash-success">{{ session('status') }}</div>
            @endif
            @if(session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif
            @if($errors->any())
                <div class="flash flash-error">
                    @foreach($errors->all() as $err)<p>{{ $err }}</p>@endforeach
                </div>
            @endif

            {{-- Code form --}}
            <form method="POST" action="{{ route('two-factor.verify') }}" class="space-y-5" autocomplete="off">
                @csrf
                <div>
                    <label for="code" class="form-label">Verification Code</label>
                    <input id="code" type="text" name="code" inputmode="numeric" maxlength="6"
                           required autocomplete="one-time-code" placeholder="• • • • • •"
                           class="form-input text-center text-2xl font-black tracking-[0.5em]"
                           style="letter-spacing:0.5em">
                </div>

                <button type="submit" class="btn-submit">
                    Verify &amp; Continue
                </button>
            </form>

            <form method="POST" action="{{ route('two-factor.resend') }}" class="mt-4 text-center">
                @csrf
                <button type="submit" class="text-sm font-black text-primary hover:underline bg-transparent border-0 cursor-pointer">
                    Resend code
                </button>
            </form>

            <p class="text-center text-muted font-semibold text-sm mt-6">
                Wrong account?
                <a href="{{ route('login') }}" class="text-primary font-black hover:underline">Sign in again</a>
            </p>
        </div>
    </div>

</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('code');
    if (input) {
        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '').slice(0, 6);
        });
    }
});
</script>
@endpush
@endsection