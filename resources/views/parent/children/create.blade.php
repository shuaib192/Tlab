@extends('layouts.app')

@section('title', 'Add Child Profile')

@section('content')
<div class="max-w-2xl mx-auto px-8 py-16">
    <!-- Back -->
    <a href="{{ route('parent.dashboard') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-10 transition-colors font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Dashboard
    </a>

    <!-- Header -->
    <div class="mb-10">
        <h1 class="font-display text-4xl font-bold mb-2">Add a Child Profile</h1>
        <p class="text-cream/50">Set up your child's learning profile. You can manage it anytime from your dashboard.</p>
    </div>

    <!-- Form -->
    @if($errors->any())
        <div class="flash flash-error mb-6">
            @foreach($errors->all() as $error) <p>{{ $error }}</p> @endforeach
        </div>
    @endif

    <form method="POST" action="{{ route('parent.children.store') }}" class="space-y-6">
        @csrf

        <!-- Name -->
        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">Child's Full Name</label>
            <input type="text" name="name" value="{{ old('name') }}" required
                   class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream placeholder-cream/30
                          focus:outline-none focus:border-mint focus:bg-mint/5 transition-all"
                   placeholder="e.g. Adaeze Okonkwo">
        </div>

        <!-- Date of Birth + Gender -->
        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">Date of Birth</label>
                <input type="date" name="dob" value="{{ old('dob') }}" required
                       class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream
                              focus:outline-none focus:border-mint focus:bg-mint/5 transition-all">
            </div>
            <div>
                <label class="block text-sm font-bold mb-2 text-cream/70">Gender</label>
                <select name="gender" required
                        class="w-full px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream
                               focus:outline-none focus:border-mint focus:bg-mint/5 transition-all appearance-none">
                    <option value="">Select...</option>
                    <option value="male"             {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                    <option value="female"           {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                    <option value="prefer_not_to_say"{{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                </select>
            </div>
        </div>

        <!-- Skill Level -->
        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">Skill Level</label>
            <div class="grid grid-cols-3 gap-3">
                @foreach(['beginner' => '🌱 Beginner', 'intermediate' => '⚡ Intermediate', 'advanced' => '🚀 Advanced'] as $value => $label)
                <label class="cursor-pointer">
                    <input type="radio" name="skill_level" value="{{ $value }}" class="sr-only peer"
                           {{ old('skill_level', 'beginner') == $value ? 'checked' : '' }}>
                    <div class="px-4 py-3 rounded-xl border border-white/10 text-center text-sm font-bold transition-all
                                peer-checked:border-mint peer-checked:bg-mint/10 peer-checked:text-mint hover:border-white/30">
                        {{ $label }}
                    </div>
                </label>
                @endforeach
            </div>
        </div>

        <!-- Interests -->
        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">Learning Interests <span class="font-normal text-cream/40">(select all that apply)</span></label>
            <div class="grid grid-cols-2 gap-3">
                @foreach([
                    'robotics'    => '🤖 Robotics',
                    'coding'      => '💻 Coding',
                    'math'        => '➕ Mathematics',
                    'science'     => '🔬 Science',
                    'art'         => '🎨 Art & Design',
                    'leadership'  => '🗣️ Leadership',
                    'chess'       => '♟️ Chess & Strategy',
                    'entrepreneurship' => '💡 Entrepreneurship',
                ] as $value => $label)
                <label class="cursor-pointer flex items-center gap-3 px-4 py-3 rounded-xl border border-white/10 hover:border-white/30 transition-all"
                       x-data>
                    <input type="checkbox" name="interests[]" value="{{ $value }}"
                           class="w-4 h-4 rounded accent-mint"
                           {{ in_array($value, old('interests', [])) ? 'checked' : '' }}>
                    <span class="text-sm font-medium">{{ $label }}</span>
                </label>
                @endforeach
            </div>
        </div>

        <!-- PIN -->
        <div>
            <label class="block text-sm font-bold mb-2 text-cream/70">
                Child Login PIN
                <span class="font-normal text-cream/40">(4 digits — used for child-safe login)</span>
            </label>
            <input type="text" name="pin" maxlength="4" pattern="\d{4}" value="{{ old('pin') }}"
                   class="w-32 px-4 py-4 rounded-xl bg-white/5 border border-white/10 text-cream placeholder-cream/30
                          focus:outline-none focus:border-mint focus:bg-mint/5 transition-all text-center text-2xl tracking-widest"
                   placeholder="••••">
            <p class="text-xs text-cream/40 mt-2">This PIN lets your child access their own dashboard without logging in to your account.</p>
        </div>

        <!-- Submit -->
        <div class="pt-4">
            <button type="submit"
                    class="w-full py-4 rounded-xl font-bold text-white text-lg transition-all hover:scale-[1.02] active:scale-95"
                    style="background:linear-gradient(135deg,#4E9966,#2a6e44); box-shadow:0 8px 32px rgba(78,153,102,0.3)">
                Create Child Profile 🎉
            </button>
            <p class="text-center text-cream/40 text-sm mt-4">You can add more children after this step.</p>
        </div>
    </form>
</div>
@endsection
