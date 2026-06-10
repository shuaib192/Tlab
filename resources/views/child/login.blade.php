@extends('layouts.app')

@section('title', 'Child Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12" style="background:linear-gradient(135deg,#F0FDF4,#DCFCE7,#EFF6FF)">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="w-20 h-20 rounded-3xl flex items-center justify-center text-4xl shadow-lg mx-auto mb-4"
                 style="background:white;border:3px solid #86EFAC">
                🚀
            </div>
            <h1 class="font-black text-2xl text-ink">Welcome Back, Explorer!</h1>
            <p class="text-muted/70 text-sm mt-1 font-semibold">Enter your username and PIN to enter your learning space</p>
        </div>

        @if(session('success'))
            <div class="mb-4 px-5 py-3.5 rounded-2xl text-sm font-bold text-emerald-700 bg-emerald-100 border border-emerald-200">
                ✅ {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 px-5 py-3.5 rounded-2xl text-sm font-bold text-red-700 bg-red-100 border border-red-200">
                ❌ {{ $errors->first('pin') }}
            </div>
        @endif

        <form method="POST" action="{{ route('child.login.submit') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-bold text-muted mb-2">
                    <span class="mr-1">👤</span> Username
                </label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus
                       class="w-full px-5 py-3.5 rounded-2xl bg-white border-2 border-gray-100 text-ink placeholder-muted/40 focus:outline-none focus:border-primary/40 focus:ring-4 focus:ring-primary/10 transition-all font-bold text-sm"
                       placeholder="Your username">
            </div>

            <div>
                <label class="block text-sm font-bold text-muted mb-2">
                    <span class="mr-1">🔑</span> PIN
                </label>
                <input type="password" name="pin" inputmode="numeric" pattern="[0-9]*" maxlength="4" required
                       class="w-full px-5 py-3.5 rounded-2xl bg-white border-2 border-gray-100 text-ink placeholder-muted/40 focus:outline-none focus:border-primary/40 focus:ring-4 focus:ring-primary/10 transition-all text-center text-2xl tracking-[1em] font-black"
                       placeholder="····">
            </div>

            <button type="submit"
                    class="w-full py-4 rounded-2xl font-black text-white text-sm transition-all active:scale-[0.98] hover:shadow-lg"
                    style="background:linear-gradient(135deg,#16A34A,#15803D)">
                🎮 Enter My Space
            </button>
        </form>

        <div class="mt-8 text-center">
            <a href="{{ route('login') }}" class="inline-flex items-center gap-2 text-sm font-bold text-muted/60 hover:text-muted transition-colors">
                <span>👨‍👩‍👧‍👦</span> Parent? Log in here
            </a>
        </div>
    </div>
</div>
@endsection
