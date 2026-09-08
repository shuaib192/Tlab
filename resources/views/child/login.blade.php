@extends('layouts.child')

@section('title', 'Child Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-8">
    <div class="w-full max-w-sm relative pop-in">
        <div class="absolute -top-10 -left-8 text-5xl float select-none" style="--rot:-10deg">🪐</div>
        <div class="absolute -top-6 -right-8 text-4xl float select-none" style="--rot:12deg;animation-delay:1s">🌟</div>

        <div class="relative rounded-[2rem] border-[3px] border-cream/20 bg-panel/90 backdrop-blur-md hard-shadow p-7 sm:p-8">
            <div class="text-center mb-7">
                <div class="w-20 h-20 rounded-[1.4rem] grid place-items-center text-4xl border-[3px] border-space bg-gradient-to-br from-mint to-sky shadow-[5px_5px_0_#0a0718] mx-auto mb-4 float">🚀</div>
                <h1 class="font-display font-extrabold text-2xl text-cream">Welcome Back, Explorer!</h1>
                <p class="text-cream/50 text-sm font-bold mt-1">Enter your username + secret PIN to board</p>
            </div>

            @if(session('success'))
                <div class="mb-4 px-5 py-3.5 rounded-2xl text-sm font-black text-space border-2 border-space shadow-[3px_3px_0_#0a0718]" style="background:#4DFFA2">
                    ✅ {{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 px-5 py-3.5 rounded-2xl text-sm font-black text-cream border-2 border-terra/60 shadow-[3px_3px_0_#0a0718]" style="background:rgba(255,107,77,.18)">
                    ❌ {{ $errors->first('pin') }}
                </div>
            @endif

            <form method="POST" action="{{ route('child.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="block text-sm font-black text-cream/70 mb-2">
                        <span class="mr-1">👤</span> Username
                    </label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus
                           class="input-candy" placeholder="Your username">
                </div>

                <div>
                    <label class="block text-sm font-black text-cream/70 mb-2">
                        <span class="mr-1">🔑</span> PIN
                    </label>
                    <input type="password" name="pin" inputmode="numeric" pattern="[0-9]*" maxlength="4" required
                           class="input-candy text-center text-2xl tracking-[1em] font-black"
                           placeholder="····">
                </div>

                <button type="submit"
                        class="btn-candy w-full py-4 text-sm bg-mint hover:bg-mint/90" style="--tw-bg-opacity:1">
                    🎮 Enter My Space
                </button>
            </form>

            <div class="mt-7 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-black text-cream/50 hover:text-cream transition-colors">
                    <span>👨‍👩‍👧‍👦</span> Parent? Log in here
                </a>
            </div>
        </div>
    </div>
</div>
@endsection