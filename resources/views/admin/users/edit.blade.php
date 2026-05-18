@extends('layouts.admin')
@section('title', 'Edit User')
@section('content')

<div class="mb-8">
    <a href="{{ route('admin.users.index') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-4 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Users
    </a>
    <h1 class="font-display text-3xl font-bold">Edit User: {{ $user->name }}</h1>
</div>

<div class="max-w-2xl">
    @if($errors->any())
    <div class="flash-error mb-6">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div>
    @endif

    <form method="POST" action="{{ route('admin.users.update', $user) }}" class="card p-6 space-y-5">
        @csrf @method('PUT')

        <div>
            <label class="label">Full Name</label>
            <input type="text" name="name" value="{{ old('name', $user->name) }}" required class="input">
        </div>

        <div>
            <label class="label">Email Address</label>
            <input type="email" name="email" value="{{ old('email', $user->email) }}" required class="input">
            <p class="text-cream/30 text-xs mt-1">Note: email changes are local only. Identity is managed by Edfrica Auth.</p>
        </div>

        <div>
            <label class="label">Role</label>
            <select name="role" required class="input appearance-none">
                @foreach(['parent'=>'Parent', 'teacher'=>'Teacher', 'school_admin'=>'School Admin', 'super_admin'=>'Super Admin'] as $val => $label)
                <option value="{{ $val }}" {{ old('role', $user->role) === $val ? 'selected' : '' }}>{{ $label }}</option>
                @endforeach
            </select>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Save Changes</button>
            <a href="{{ route('admin.users.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
