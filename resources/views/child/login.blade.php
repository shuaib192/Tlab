@extends('layouts.app')

@section('title', 'Child Login')

@section('content')
<div class="min-h-screen flex items-center justify-center px-4 py-12" style="background:#0a0f1a">
    <div class="w-full max-w-sm">
        <div class="text-center mb-8">
            <div class="w-16 h-16 rounded-2xl flex items-center justify-center font-display text-3xl font-black italic text-white mx-auto mb-4"
                 style="background:linear-gradient(135deg,#16A34A,#15803d)">T</div>
            <h1 class="font-display text-2xl font-bold text-white">Welcome Back!</h1>
            <p class="text-gray-400 text-sm mt-1">Enter your username and PIN to enter your learning space</p>
        </div>

        @if(session('success'))
            <div class="mb-4 px-4 py-3 rounded-xl text-sm font-medium text-green-400 bg-green-500/10 border border-green-500/20">
                {{ session('success') }}
            </div>
        @endif

        @if($errors->any())
            <div class="mb-4 px-4 py-3 rounded-xl text-sm font-medium text-red-400 bg-red-500/10 border border-red-500/20">
                {{ $errors->first('pin') }}
            </div>
        @endif

        <form method="POST" action="{{ route('child.login.submit') }}" class="space-y-5">
            @csrf

            <div>
                <label class="block text-sm font-bold text-gray-300 mb-2">Username</label>
                <input type="text" name="username" value="{{ old('username') }}" required autofocus
                       class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all"
                       placeholder="Your username">
            </div>

            <div>
                <label class="block text-sm font-bold text-gray-300 mb-2">PIN</label>
                <input type="password" name="pin" inputmode="numeric" pattern="[0-9]*" maxlength="4" required
                       class="w-full px-4 py-3 rounded-xl bg-white/5 border border-white/10 text-white placeholder-gray-500 focus:outline-none focus:border-primary/50 focus:ring-1 focus:ring-primary/30 transition-all text-center text-2xl tracking-[1em] font-bold"
                       placeholder="····">
            </div>

            <button type="submit"
                    class="w-full py-3.5 rounded-xl font-bold text-white text-sm transition-all"
                    style="background:linear-gradient(135deg,#16A34A,#15803d)">
                Enter My Space
            </button>
        </form>

        <div class="mt-6 text-center">
            <a href="{{ route('login') }}" class="text-sm text-gray-500 hover:text-gray-300 transition-colors">
                Parent? Log in here
            </a>
        </div>
    </div>
</div>
@endsection
