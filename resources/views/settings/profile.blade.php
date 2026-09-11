@extends(auth()->user()->isSchoolAdmin()
    ? 'school.layouts.school'
    : (auth()->user()->isAdmin() ? 'layouts.admin' : 'layouts.teacher'))
@section('title', 'Profile')

@section('content')
<div class="mb-8">
    <h1 class="font-display text-3xl font-bold mb-1">Profile</h1>
    <p class="text-sm opacity-60">Your photo is shown in the sidebar.</p>
</div>

@if(session('success'))
    <div class="flash flash-success mb-6">{{ session('success') }}</div>
@endif
@if(session('error'))
    <div class="flash flash-error mb-6">{{ session('error') }}</div>
@endif

<div class="card p-6 max-w-2xl">
    <div class="flex items-center gap-4 mb-6 pb-6 border-b border-cream/10">
        @if(auth()->user()->avatar)
            <img src="{{ str_starts_with(auth()->user()->avatar, 'http') ? auth()->user()->avatar : \Illuminate\Support\Facades\Storage::url(auth()->user()->avatar) }}"
                 alt="{{ auth()->user()->name }}"
                 class="w-16 h-16 rounded-full object-cover" style="border:2px solid rgba(79,70,229,0.25)">
        @else
            <div class="w-16 h-16 rounded-full flex items-center justify-center text-xl font-bold"
                 style="background:rgba(79,70,229,0.12);border:1px solid rgba(79,70,229,0.3);color:#4F46E5">
                {{ strtoupper(substr(auth()->user()->name ?? 'T', 0, 1)) }}
            </div>
        @endif
        <div>
            <div class="font-bold text-lg">{{ auth()->user()->name }}</div>
            <div class="text-sm opacity-60">{{ auth()->user()->email }}</div>
        </div>
    </div>

    <form method="POST" action="{{ route('settings.profile.update') }}" enctype="multipart/form-data">
        @csrf
        <div class="mb-4">
            <label class="label">Profile Photo</label>
            <input type="file" name="avatar" accept="image/jpeg,image/png,image/webp" class="input" required>
            @error('avatar')
                <p class="text-xs mt-1" style="color:#DC2626">{{ $message }}</p>
            @enderror
            <p class="text-xs mt-1 opacity-50">JPG, PNG or WEBP — max 2MB.</p>
        </div>
        <button type="submit" class="btn-primary">Save Photo</button>
    </form>
</div>
@endsection