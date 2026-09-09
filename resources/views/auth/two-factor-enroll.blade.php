@extends(auth()->user()->isSchoolAdmin()
    ? 'school.layouts.school'
    : (auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.teacher'))
@section('title', 'Enable Two-Factor Authentication')

@section('content')
<div class="max-w-lg mx-auto">
    <div class="card p-8">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center mb-5" style="background:rgba(78,153,102,0.12);border:1px solid rgba(78,153,102,0.3)">
            <svg class="w-7 h-7 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>

        <h1 class="font-display text-2xl font-bold mb-2">Confirm set-up</h1>
        <p class="text-sm text-cream/60 mb-6">
            Enter the 6-digit code sent to <span class="font-black text-cream">{{ auth()->user()->email }}</span>.
            Two-factor will be enabled once verified.
        </p>

        @if(session('status'))
            <div class="flash flash-success mb-4">{{ session('status') }}</div>
        @endif
        @if(session('error'))
            <div class="flash flash-error mb-4">{{ session('error') }}</div>
        @endif
        @if($errors->any())
            <div class="flash flash-error mb-4">
                @foreach($errors->all() as $err)<p>{{ $err }}</p>@endforeach
            </div>
        @endif

        <form method="POST" action="{{ route('two-factor.enroll-verify.store') }}" class="space-y-4" autocomplete="off">
            @csrf
            <div>
                <label for="code" class="label">Verification Code</label>
                <input id="code" type="text" name="code" inputmode="numeric" maxlength="6" required
                       class="input text-center text-xl font-black tracking-[0.4em]" placeholder="••••••">
            </div>
            <button type="submit" class="btn-primary w-full justify-center">Confirm &amp; Enable</button>
        </form>

        <form method="POST" action="{{ route('two-factor.enable') }}" class="mt-3 text-center">
            @csrf
            <button type="submit" class="text-xs font-bold text-cream/50 hover:text-cream bg-transparent border-0 cursor-pointer">
                Resend code
            </button>
        </form>
    </div>
</div>
@endsection