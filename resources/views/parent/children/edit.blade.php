@extends('layouts.parent')
@section('title', 'Edit ' . $child->name)

@section('parent-content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-8 py-8 sm:py-16">

        <a href="{{ route('parent.children.show', $child) }}"
           class="inline-flex items-center gap-2 text-muted hover:text-ink font-bold text-sm mb-8 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Back to Profile
        </a>

        <div class="mb-10">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-primary/80 flex items-center justify-center shadow-lg shadow-primary/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.066 2.573c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.573 1.066c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.066-2.573c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/></svg>
                </div>
                <div>
                    <h1 class="font-black text-2xl sm:text-3xl text-ink">Edit Profile</h1>
                    <p class="text-muted font-semibold text-sm mt-1">Update {{ $child->name }}'s learning profile.</p>
                </div>
            </div>
        </div>

        @if($errors->any())
        <div class="mb-8 px-5 py-4 rounded-2xl bg-red-50 border border-red-200">
            <div class="flex items-center gap-2 text-red-700 font-bold text-sm mb-2">
                <svg class="w-5 h-5" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zM8.707 7.293a1 1 0 00-1.414 1.414L8.586 10l-1.293 1.293a1 1 0 101.414 1.414L10 11.414l1.293 1.293a1 1 0 001.414-1.414L11.414 10l1.293-1.293a1 1 0 00-1.414-1.414L10 8.586 8.707 7.293z"/></svg>
                Please fix the following:
            </div>
            <ul class="list-disc list-inside text-sm text-red-600 space-y-1">
                @foreach($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
        @endif

        <form method="POST" action="{{ route('parent.children.update', $child) }}" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-7">
            @csrf
            @method('PUT')

            {{-- Basic Information --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-primary/10 flex items-center justify-center">
                        <svg class="w-4 h-4 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                    </div>
                    <h2 class="font-black text-lg text-ink">Basic Information</h2>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="form-label">Child's Full Name</label>
                        <input type="text" name="name" value="{{ old('name', $child->name) }}" required placeholder="e.g. Adaeze Okonkwo"
                               class="form-input">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob', $child->dob?->format('Y-m-d')) }}" required
                                   class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Gender</label>
                            <select name="gender" required class="form-input appearance-none bg-no-repeat" style="background-image:url(&quot;data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239CA3AF'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E&quot;);background-position:right 16px center;background-size:20px;">
                                <option value="">Select...</option>
                                <option value="male"   {{ old('gender', $child->gender) == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender', $child->gender) == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="prefer_not_to_say" {{ old('gender', $child->gender) == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Learning Profile --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-violet-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-violet-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9.663 17h4.673M12 3v1m6.364 1.636l-.707.707M21 12h-1M4 12H3m3.343-5.657l-.707-.707m2.828 9.9a5 5 0 117.072 0l-.548.547A3.374 3.374 0 0014 18.469V19a2 2 0 11-4 0v-.531c0-.895-.356-1.754-.988-2.386l-.548-.547z"/></svg>
                    </div>
                    <h2 class="font-black text-lg text-ink">Learning Profile</h2>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="form-label">Skill Level</label>
                        <div class="grid grid-cols-3 gap-3">
                            @foreach(['beginner' => '🌱 Beginner', 'intermediate' => '⚡ Intermediate', 'advanced' => '🚀 Advanced'] as $value => $label)
                            <label class="cursor-pointer">
                                <input type="radio" name="skill_level" value="{{ $value }}" class="sr-only peer"
                                       {{ old('skill_level', $child->skill_level) == $value ? 'checked' : '' }}>
                                <div class="px-4 py-3.5 rounded-xl border-2 border-gray-200 text-center text-sm font-bold transition-all
                                            peer-checked:border-primary peer-checked:bg-primary/5 peer-checked:text-primary hover:border-gray-300">
                                    {{ $label }}
                                </div>
                            </label>
                            @endforeach
                        </div>
                    </div>

                    <div>
                        <label class="form-label">
                            Learning Interests
                            <span class="font-normal text-muted">(select all that apply)</span>
                        </label>
                        <div class="grid grid-cols-2 gap-3">
                            @php $currentInterests = old('interests', $child->interests ?? []); @endphp
                            @foreach([
                                'robotics'    => ['🤖', 'Robotics'],
                                'coding'      => ['💻', 'Coding'],
                                'math'        => ['➕', 'Mathematics'],
                                'science'     => ['🔬', 'Science Experiments'],
                                'art'         => ['🎨', 'Art & Design'],
                                'leadership'  => ['🗣️', 'Leadership'],
                                'chess'       => ['♟️', 'Chess & Strategy'],
                                'entrepreneurship' => ['💡', 'Entrepreneurship'],
                            ] as $value => [$emoji, $label])
                            <label class="cursor-pointer flex items-center gap-3 px-4 py-3.5 rounded-xl border-2 border-gray-200 hover:border-gray-300 transition-all
                                        {{ in_array($value, $currentInterests) ? 'border-primary bg-primary/5' : '' }}">
                                <input type="checkbox" name="interests[]" value="{{ $value }}"
                                       class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary"
                                       {{ in_array($value, $currentInterests) ? 'checked' : '' }}>
                                <span class="text-sm font-semibold"><span class="mr-1.5">{{ $emoji }}</span>{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Login Setup --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-blue-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                    </div>
                    <h2 class="font-black text-lg text-ink">Login Setup</h2>
                </div>

                <div class="space-y-5">
                    <div>
                        <label class="form-label">
                            Username
                            <span class="font-normal text-muted">(for child login)</span>
                        </label>
                        <input type="text" name="username" value="{{ old('username', $child->username) }}" maxlength="50" placeholder="e.g. adaeze"
                               class="form-input">
                        <p class="text-xs text-muted mt-2">Used with PIN for child-safe login. Must be unique.</p>
                    </div>

                    <div>
                        <label class="form-label">
                            Child Login PIN
                            <span class="font-normal text-muted">(4 digits)</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="text" name="pin" maxlength="4" pattern="\d{4}" value="{{ old('pin', $child->pin) }}"
                                   class="form-input !w-32 text-center text-2xl tracking-widest" placeholder="••••">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" name="pin_enabled" value="1" {{ old('pin_enabled', $child->pin_enabled) ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="text-sm font-semibold text-muted">Enable PIN login</span>
                            </label>
                        </div>
                        <p class="text-xs text-muted mt-2">Lets your child log in independently without accessing your parent account.</p>
                    </div>
                </div>
            </div>

            <div class="border-t border-gray-100"></div>

            {{-- Actions --}}
            <div class="flex flex-col sm:flex-row gap-3 pt-2">
                <button type="submit"
                        class="flex-1 py-4 rounded-2xl font-bold text-white text-base transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg hover:shadow-xl"
                        style="background:linear-gradient(135deg,#16A34A,#15803D)">
                    <span class="flex items-center justify-center gap-3">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                        Save Changes
                    </span>
                </button>
                <a href="{{ route('parent.children.show', $child) }}"
                   class="flex-1 py-4 rounded-2xl font-bold bg-gray-100 text-muted text-center hover:text-ink hover:bg-gray-200 transition-all">
                   Cancel
                </a>
            </div>
        </form>
    </div>
</div>
@endsection
