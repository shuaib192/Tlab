@extends(auth()->user()->isSchoolAdmin()
    ? 'school.layouts.school'
    : (auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.teacher'))
@section('title', 'Security Settings')

@section('content')
<div class="mb-8">
    <h1 class="font-display text-3xl font-bold mb-1">Security Settings</h1>
    <p class="text-cream/50 text-sm">Manage two-factor authentication for your staff account.</p>
</div>

@if(session('success'))
    <div class="flash flash-success mb-6">{{ session('success') }}</div>
@endif
@if(session('info'))
    <div class="flash mb-6" style="background:rgba(212,162,36,0.12);border:1px solid rgba(212,162,36,0.3);color:#D4A224">{{ session('info') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-error mb-6">{{ session('error') }}</div>
@endif

<div class="card p-6 max-w-2xl">
    <div class="flex flex-col sm:flex-row sm:items-center gap-4 sm:gap-6">
        <div class="w-14 h-14 rounded-2xl flex items-center justify-center flex-shrink-0"
             style="background:{{ $user->two_factor_enabled ? 'rgba(78,153,102,0.12)' : 'rgba(250,245,232,0.05)' }};border:1px solid {{ $user->two_factor_enabled ? 'rgba(78,153,102,0.3)' : 'rgba(250,245,232,0.1)' }}">
            <svg class="w-7 h-7 {{ $user->two_factor_enabled ? 'text-mint' : 'text-cream/40' }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
        </div>
        <div class="flex-1">
            <h2 class="font-bold text-lg">Two-Factor Authentication</h2>
            @if($user->two_factor_enabled)
                <p class="text-sm text-cream/60 mt-0.5">
                    Enabled since {{ $user->two_factor_enrolled_at?->format('d M Y') }}. You'll be asked for a code on every sign-in.
                </p>
            @else
                <p class="text-sm text-cream/60 mt-0.5">
                    Currently off. For staff accounts, TLab recommends turning this on — a code is emailed on each sign-in.
                </p>
            @endif
        </div>
        <div>
            @if($user->two_factor_enabled)
                <form method="POST" action="{{ route('two-factor.disable') }}">
                    @csrf
                    <button type="submit" class="btn-danger btn-sm" onclick="return confirm('Disable two-factor authentication?')">Disable</button>
                </form>
            @else
                <form method="POST" action="{{ route('two-factor.enable') }}">
                    @csrf
                    <button type="submit" class="btn-primary btn-sm">Enable 2FA</button>
                </form>
            @endif
        </div>
    </div>
</div>

<div class="card p-6 mt-6 max-w-2xl">
    <h3 class="font-bold mb-2">Account status</h3>
    <div class="flex items-center gap-2 text-sm mb-4">
        @if($user->isSuspended())
            <span class="badge badge-red">SUSPENDED</span>
            <span class="text-cream/50">Contact the Super Admin to restore this account.</span>
        @else
            <span class="badge badge-green">ACTIVE</span>
            <span class="text-cream/50">Your account is active.</span>
        @endif
    </div>
    <div class="flex items-center gap-2 text-sm">
        <span class="text-cream/40 text-xs w-32">Role</span>
        <span class="badge badge-gold">{{ str_replace('_',' ', $user->role) }}</span>
    </div>
</div>
@endsection