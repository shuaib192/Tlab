@extends('layouts.app')
@section('title', 'Create Your Account')

@section('content')

{{-- Back Home --}}
<a href="{{ route('home') }}"
   class="fixed top-5 left-5 z-50 flex items-center gap-2 text-xs font-black tracking-wider uppercase px-4 py-2 rounded-full"
   style="background:rgba(5,46,22,0.7);backdrop-filter:blur(12px);border:1px solid rgba(255,255,255,0.15);color:rgba(255,255,255,0.7)">
    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M10 19l-7-7m0 0l7-7m-7 7h18"/></svg>
    Home
</a>

<div class="min-h-screen flex">
    {{-- Left Panel --}}
    <div class="hidden lg:flex flex-col justify-between w-[45%] relative overflow-hidden p-14"
         style="background:linear-gradient(145deg,#052e16 0%,#14532d 55%,#166534 100%)">
        <div class="absolute w-[400px] h-[400px] rounded-full blur-3xl opacity-20 -top-20 -left-20" style="background:#4ade80"></div>
        <div class="absolute w-80 h-80 rounded-full blur-3xl opacity-15 bottom-20 right-10" style="background:#a855f7"></div>
        <div class="relative z-10">
            <img src="/Tlab/public/images/tlab-logo-white.png" alt="TLab" class="h-10 w-auto">
        </div>
        <div class="relative z-10">
            <h2 class="font-black text-5xl text-white leading-[1.1] mb-8">
                Your child's<br>
                <span style="color:#4ade80">STEM journey</span><br>
                starts here.
            </h2>
            <div class="space-y-5">
                @foreach([
                    ['4 World-Class Clubs',    'STEM, Brain, Art and Leadership programmes.'],
                    ['Gamified XP System',     'Kids earn XP points and climb 5 ranks as they learn.'],
                    ['100% Parent-Controlled', 'You manage access, progress and everything in between.'],
                    ['Completely Safe',        'COPPA & GDPR-K compliant. No ads. No data selling.'],
                ] as [$title,$desc])
                <div class="flex items-start gap-4">
                    <div class="w-6 h-6 rounded-full bg-green-400/20 border border-green-400/40 flex items-center justify-center flex-shrink-0 mt-0.5">
                        <svg class="w-3 h-3 text-green-400" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="3" d="M5 13l4 4L19 7"/></svg>
                    </div>
                    <div>
                        <div class="text-white font-black text-sm">{{ $title }}</div>
                        <div class="text-green-200/60 font-semibold text-xs mt-0.5">{{ $desc }}</div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
        <p class="text-white/20 text-xs font-semibold relative z-10">&copy; {{ date('Y') }} Edfrica. COPPA &amp; GDPR-K Compliant.</p>
    </div>

    {{-- Right: Form --}}
    <div class="flex-1 flex items-center justify-center p-6 sm:p-12 bg-white overflow-y-auto">
        <div class="w-full max-w-md py-8">
            <div class="lg:hidden mb-8">
                <img src="/Tlab/public/images/tlab-logo-color.png" alt="TLab" class="h-9 w-auto">
            </div>
            <h1 class="font-black text-3xl sm:text-4xl text-ink mb-1.5">Create your account</h1>
            <p class="text-muted font-semibold text-sm mb-8">Join as a parent and manage your child's learning.</p>

            @if($errors->any())
                <div class="flash flash-error">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
            @endif

            {{-- Edfrica SSO --}}
            <a href="{{ route('auth.edfrica') }}" class="btn-edfrica mb-6">
                <img src="/Tlab/public/images/edfrica-logo.png" alt="Edfrica" class="h-6 w-6 rounded object-contain flex-shrink-0">
                <span class="flex-1 text-center">Sign up with Edfrica</span>
                <svg class="w-4 h-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7"/></svg>
            </a>

            <div class="flex items-center gap-4 mb-6">
                <div class="flex-1 h-px bg-gray-200"></div>
                <span class="text-muted text-xs font-bold">or register with email</span>
                <div class="flex-1 h-px bg-gray-200"></div>
            </div>

            <form method="POST" action="{{ route('register') }}" class="space-y-4">
                @csrf
                <div>
                    <label for="reg_name" class="form-label">Full Name</label>
                    <input id="reg_name" type="text" name="name" value="{{ old('name') }}" required class="form-input" placeholder="Your full name">
                </div>
                <div>
                    <label for="reg_email" class="form-label">Email Address</label>
                    <input id="reg_email" type="email" name="email" value="{{ old('email') }}" required class="form-input" placeholder="parent@email.com">
                </div>
                <div>
                    <label for="reg_pass" class="form-label">Password</label>
                    <input id="reg_pass" type="password" name="password" required class="form-input" placeholder="At least 8 characters">
                </div>
                <div>
                    <label for="reg_pass2" class="form-label">Confirm Password</label>
                    <input id="reg_pass2" type="password" name="password_confirmation" required class="form-input" placeholder="Repeat your password">
                </div>
                <div class="flex items-start gap-3 pt-1">
                    <input type="checkbox" name="terms" id="terms" required class="mt-1 w-4 h-4 accent-primary flex-shrink-0">
                    <label for="terms" class="text-xs font-semibold text-muted leading-relaxed">
                        I agree to TLab's <a href="#" class="text-primary font-black hover:underline">Terms of Service</a> and <a href="#" class="text-primary font-black hover:underline">Privacy Policy</a>.
                    </label>
                </div>
                <button type="submit" class="btn-submit mt-2">Create Free Account</button>
            </form>

            <p class="text-center text-muted font-semibold mt-6 text-sm">
                Already have an account?
                <a href="{{ route('login') }}" class="text-primary font-black hover:underline">Login</a>
            </p>
        </div>
    </div>
</div>
@endsection
