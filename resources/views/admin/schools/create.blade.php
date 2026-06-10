@extends('layouts.admin')
@section('title', 'Add School')

@section('content')
<div class="max-w-2xl">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.schools.index') }}" class="btn-secondary">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
            Back
        </a>
        <div>
            <h1 class="font-display text-3xl font-bold mb-1">Add School</h1>
            <p class="text-cream/50 text-sm">Register a new school on the platform.</p>
        </div>
    </div>

    <div class="card p-6">
        <form method="POST" action="{{ route('admin.schools.store') }}">
            @csrf

            <div class="mb-5">
                <label class="label">School Name</label>
                <input type="text" name="name" class="input" placeholder="e.g. Greensprings School" value="{{ old('name') }}" required>
                @error('name') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="label">Email</label>
                    <input type="email" name="email" class="input" placeholder="admin@school.edu" value="{{ old('email') }}">
                </div>
                <div>
                    <label class="label">Phone</label>
                    <input type="text" name="phone" class="input" placeholder="+234 800 000 0000" value="{{ old('phone') }}">
                </div>
            </div>

            <div class="mb-5">
                <label class="label">Address</label>
                <textarea name="address" class="input" rows="2" placeholder="School address...">{{ old('address') }}</textarea>
            </div>

            <div class="grid grid-cols-3 gap-4 mb-5">
                <div>
                    <label class="label">City</label>
                    <input type="text" name="city" class="input" placeholder="Lagos" value="{{ old('city') }}">
                </div>
                <div>
                    <label class="label">State</label>
                    <input type="text" name="state" class="input" placeholder="Lagos" value="{{ old('state') }}">
                </div>
                <div>
                    <label class="label">Country</label>
                    <input type="text" name="country" class="input" placeholder="Nigeria" value="{{ old('country', 'Nigeria') }}">
                </div>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-5">
                <div>
                    <label class="label">Max Students</label>
                    <input type="number" name="max_students" class="input" placeholder="100" value="{{ old('max_students', 100) }}">
                </div>
                <div>
                    <label class="label">Subscription Tier</label>
                    <select name="subscription_tier" class="input">
                        <option value="basic" {{ old('subscription_tier') === 'basic' ? 'selected' : '' }}>Basic</option>
                        <option value="premium" {{ old('subscription_tier') === 'premium' ? 'selected' : '' }}>Premium</option>
                        <option value="enterprise" {{ old('subscription_tier') === 'enterprise' ? 'selected' : '' }}>Enterprise</option>
                    </select>
                </div>
            </div>

            <button type="submit" class="btn-primary w-full justify-center">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Create School
            </button>
        </form>
    </div>
</div>
@endsection
