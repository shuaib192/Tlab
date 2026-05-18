@extends('layouts.app')
@section('title', 'Login to TLab')

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

    {{-- ── Left Panel (hidden on small screens) ── --}}
    <div class="hidden lg:flex flex-col justify-between w-[48%] relative overflow-hidden p-14"
         style="background:linear-gradient(145deg,#052e16 0%,#14532d 55%,#16A34A 100%)">

        <div class="absolute w-[500px] h-[500px] rounded-full blur-[80px] opacity-20 -top-32 -left-32" style="background:#4ade80"></div>
        <div class="absolute w-96 h-96 rounded-full blur-[60px] opacity-15 bottom-10 right-0" style="background:#a855f7"></div>

        {{-- Logo --}}
        <div class="relative z-10">
            <img src="/images/tlab-logo-white.png" alt="TLab" class="h-11 w-auto">
            <p class="text-white/40 text-sm font-semibold mt-2">by Edfrica</p>
        </div>

        {{-- Headline --}}
        <div class="relative z-10">
            <h2 class="font-black text-5xl text-white leading-[1.1] mb-8">
                Africa's #1<br>
                <span style="color:#4ade80">STEM Platform</span><br>
                for Kids.
            </h2>

            {{-- Stat Grid --}}
            <div class="grid grid-cols-2 gap-4 mb-8">
                @foreach([['500+','Active Learners','#4ade80'],['4','STEM Clubs','#60a5fa'],['16+','Courses','#c084fc'],['5','Rank Levels','#fb923c']] as [$n,$l,$c])
                <div class="rounded-2xl p-5" style="background:rgba(255,255,255,0.07);border:1px solid rgba(255,255,255,0.12)">
                    <div class="font-black text-3xl mb-0.5" style="color:{{ $c }}">{{ $n }}</div>
                    <div class="text-white/50 text-xs font-semibold">{{ $l }}</div>
                </div>
                @endforeach
            </div>

            <div class="space-y-3">
                @foreach(['Parent-controlled access','COPPA & GDPR-K compliant','No ads. No data selling.'] as $point)
                <div class="flex items-center gap-3 text-white/60 text-sm font-semibold">
                    <div class="w-5 h-5 rounded-full bg-green-400/20 border border-green-400/40 flex items-center justify-center flex-shrink-0">
                        <svg class="w-2.5 h-2.5 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    {{ $point }}
                </div>
                @endforeach
            </div>
        </div>

        <p class="text-white/20 text-xs font-semibold relative z-10">&copy; {{ date('Y') }} Edfrica. All rights reserved.</p>
    </div>

    {{-- ── Right: Form ── --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-white overflow-y-auto">
        <div class="w-full max-w-[420px] py-8">

            {{-- Mobile logo --}}
            <div class="lg:hidden mb-10">
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-10 w-auto">
            </div>

            <h1 class="font-black text-3xl sm:text-4xl text-ink mb-1.5 leading-tight">Welcome back!</h1>
            <p class="text-muted font-semibold text-sm mb-8">Login to manage your child's learning journey.</p>

            {{-- Flash messages --}}
            @if(session('error'))
                <div class="flash flash-error">{{ session('error') }}</div>
            @endif
            @if(session('success'))
                <div class="flash flash-success">{{ session('success') }}</div>
            @endif
            @if($errors->any())
                <div class="flash flash-error">
                    @foreach($errors->all() as $err)<p>{{ $err }}</p>@endforeach
                </div>
            @endif

            {{-- Edfrica SSO Button --}}
            <a href="{{ route('auth.edfrica') }}"
               class="btn-edfrica mb-7 group">
                <img src="/images/edfrica-logo.png" alt="Edfrica" class="h-6 w-6 rounded object-contain flex-shrink-0">
                <span class="flex-1 text-center">Continue with Edfrica</span>
                <svg class="w-4 h-4 opacity-40 group-hover:opacity-100 group-hover:translate-x-1 transition-all" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/>
                </svg>
            </a>

            {{-- Divider --}}
            <div class="flex items-center gap-3 mb-7">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-muted text-xs font-bold tracking-wide">or continue with email</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            {{-- Email / Password Form --}}
            <form method="POST" action="{{ route('login') }}" class="space-y-5">
                @csrf

                <div>
                    <label for="email" class="form-label">Email Address</label>
                    <input id="email" type="email" name="email"
                           value="{{ old('email') }}" required autocomplete="email"
                           class="form-input" placeholder="parent@email.com">
                </div>

                <div>
                    <div class="flex items-center justify-between mb-2">
                        <label for="password" class="form-label" style="margin-bottom:0">Password</label>
                        <a href="{{ route('password.request') }}" class="text-xs font-black text-primary hover:underline">
                            Forgot password?
                        </a>
                    </div>
                    <input id="password" type="password" name="password"
                           required autocomplete="current-password"
                           class="form-input" placeholder="Your password">
                </div>

                <button type="submit" class="btn-submit">
                    Login to My Dashboard
                </button>
            </form>

            <p class="text-center text-muted font-semibold text-sm mt-8">
                Don't have an account?
                <a href="{{ route('register') }}" class="text-primary font-black hover:underline">Sign up free</a>
            </p>
        </div>
    </div>

</div>
@endsection
