@extends('layouts.app')

@section('title', 'Edit ' . $child->name)

@section('content')
<div class="max-w-2xl mx-auto px-4 sm:px-8 py-12">

    <a href="{{ route('parent.children.show', $child) }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-8 transition-colors font-medium text-sm">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Profile
    </a>

    <div class="mb-8">
        <h1 class="font-display text-3xl font-bold mb-1">Edit Profile</h1>
        <p class="text-cream/50">Update {{ $child->name }}'s learning profile.</p>
    </div>

    @if($errors->any())
        <div class="flash flash-error mb-6">
            @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('parent.children.update', $child) }}" class="space-y-6">
        @csrf
        @method('PUT')

        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">Child's Full Name</label>
            <input type="text" name="name" value="{{ old('name', $child->name) }}" required
                   class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream
                          focus:outline-none focus:border-mint focus:bg-mint/5 transition-all">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">Date of Birth</label>
                <input type="date" name="dob" value="{{ old('dob', $child->dob?->format('Y-m-d')) }}" required
                       class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream
                              focus:outline-none focus:border-mint focus:bg-mint/5 transition-all">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">Gender</label>
                <select name="gender" required
                        class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream
                               focus:outline-none focus:border-mint focus:bg-mint/5 transition-all appearance-none">
                    <option value="male"             {{ old('gender', $child->gender) == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female"           {{ old('gender', $child->gender) == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="prefer_not_to_say"{{ old('gender', $child->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                </select>
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">Skill Level</label>
            <div class="grid grid-cols-3 gap-3">
                @foreach(['beginner' => 'Beginner', 'intermediate' => 'Intermediate', 'advanced' => 'Advanced'] as $value => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="skill_level" value="{{ $value }}" class="sr-only peer"
                           {{ old('skill_level', $child->skill_level) == $value ? 'checked' : '' }}>
                    <div class="px-4 py-3 rounded-xl border border-white/10 text-center text-sm font-bold transition-all
                                peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:text-mint hover:border-white/30">
                        {{ $label }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">Learning Interests</label>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3">
                @foreach([
                    'robotics'         => 'Robotics',
                    'coding'           => 'Coding',
                    'math'             => 'Mathematics',
                    'science'          => 'Science',
                    'art'              => 'Art & Design',
                    'leadership'       => 'Leadership',
                    'chess'            => 'Chess & Strategy',
                    'entrepreneurship' => 'Entrepreneurship',
                ] as $value => $label)
                @php $currentInterests = old('interests', $child->interests ?? []); @endphp
                <label class="cursor-pointer flex items-center gap-3 px-4 py-3 rounded-xl border border-white/10 hover:border-white/30 transition-all">
                    <input type="checkbox" name="interests[]" value="{{ $value }}"
                           class="w-4 h-4 rounded accent-mint"
                           {{ in_array($value, $currentInterests) ? 'checked' : '' }}>
                    <span class="text-sm font-medium">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">
                Login PIN
                <span class="font-normal text-cream/40 text-xs">(4-digit child-safe PIN)</span>
            </label>
            <input type="text" name="pin" maxlength="4" pattern="\d{4}" value="{{ old('pin', $child->pin) }}"
                   class="w-32 px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream
                          focus:outline-none focus:border-mint focus:bg-mint/5 transition-all text-center text-2xl tracking-widest"
                   placeholder="••••">
        </div>

        <div class="flex flex-col sm:flex-row gap-3 pt-4">
            <button type="submit"
                    class="flex-1 py-4 rounded-xl font-bold text-white transition-all hover:scale-[1.02] active:scale-95"
                    style="background:linear-gradient(135deg,#4E9966,#2a6e44); box-shadow:0 8px 32px rgba(78,153,102,0.3)">
                Save Changes
            </button>
            <a href="{{ route('parent.children.show', $child) }}"
               class="flex-1 py-4 rounded-xl font-bold glass text-cream/60 text-center hover:text-cream transition-all">
               Cancel
            </a>
        </div>
    </form>
</div>
@endsection
