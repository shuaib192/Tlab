@extends('layouts.child')

@section('title', 'Child Login')

@section('content')
<div class="min-h-[80vh] flex items-center justify-center py-8">
    <div class="w-full max-w-sm relative pop-in">
        <div class="absolute -top-10 -left-8 float select-none opacity-60" style="--rot:-10deg"><span class="geo-ring" style="width:44px;height:44px"></span></div>
        <div class="absolute -top-6 -right-8 float select-none opacity-50" style="--rot:12deg;animation-delay:1s"><span class="geo-diamond" style="width:32px;height:32px"></span></div>

        <div class="relative rounded-[2rem] border-[3px] border-cream/20 bg-panel/90 backdrop-blur-md hard-shadow p-7 sm:p-8">
            <div class="text-center mb-7">
                <div class="w-20 h-20 rounded-[1.4rem] grid place-items-center font-display font-extrabold text-4xl text-space border-[3px] border-space bg-gradient-to-br from-mint to-sky shadow-[5px_5px_0_#0a0718] mx-auto mb-4 float">T</div>
                <h1 class="font-display font-extrabold text-2xl text-cream">Welcome Back, Explorer!</h1>
                <p class="text-cream/50 text-sm font-bold mt-1">Enter your username + secret PIN to board</p>
            </div>

            @if(session('success'))
                <div class="mb-4 px-5 py-3.5 rounded-2xl text-sm font-black text-space border-2 border-space shadow-[3px_3px_0_#0a0718]" style="background:#4DFFA2">
                    <span class="inline-block mr-1.5 align-[-2px]" aria-hidden="true">✓</span>{{ session('success') }}
                </div>
            @endif

            @if($errors->any())
                <div class="mb-4 px-5 py-3.5 rounded-2xl text-sm font-black text-cream border-2 border-terra/60 shadow-[3px_3px_0_#0a0718]" style="background:rgba(255,107,77,.18)">
                    <span class="inline-block mr-1.5 align-[-2px]" aria-hidden="true">✕</span>{{ $errors->first('pin') }}
                </div>
            @endif

            <form method="POST" action="{{ route('child.login.submit') }}" class="space-y-5">
                @csrf

                <div>
                    <label class="flex items-center gap-2 text-sm font-black text-cream/70 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                        Username
                    </label>
                    <input type="text" name="username" value="{{ old('username') }}" required autofocus
                           class="input-candy" placeholder="Your username">
                </div>

                <div>
                    <label class="flex items-center gap-2 text-sm font-black text-cream/70 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 7a2 2 0 012 2m4 0a6 6 0 01-7.74 5.74L10 17H8v2H6v2H3v-3l6.26-6.26A6 6 0 1119 9z"/></svg>
                        PIN
                    </label>
                    <input type="password" name="pin" inputmode="numeric" pattern="[0-9]*" maxlength="4" required
                           class="input-candy text-center text-2xl tracking-[1em] font-black"
                           placeholder="····">
                </div>

                <button type="submit"
                        class="btn-candy w-full py-4 text-sm bg-mint hover:bg-mint/90" style="--tw-bg-opacity:1">
                    Enter My Space
                </button>
            </form>

            <div class="mt-7 text-center">
                <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-black text-cream/50 hover:text-cream transition-colors">
                    Parent? Log in here
                </a>
            </div>
        </div>
    </div>
</div>
@endsection