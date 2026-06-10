@extends('layouts.app')
@section('title', 'Add Child Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-2xl mx-auto px-4 sm:px-8 py-8 sm:py-16">
        
        {{-- Back --}}
        <a href="{{ route('parent.dashboard') }}" 
           class="inline-flex items-center gap-2 text-muted hover:text-ink font-bold text-sm mb-8 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>

        {{-- Header --}}
        <div class="mb-10">
            <div class="flex items-center gap-4 mb-4">
                <div class="w-14 h-14 rounded-2xl bg-gradient-to-br from-primary to-primary/80 flex items-center justify-center shadow-lg shadow-primary/20">
                    <svg class="w-7 h-7 text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <div>
                    <h1 class="font-black text-2xl sm:text-3xl text-ink">Add a Child Profile</h1>
                    <p class="text-muted font-semibold text-sm mt-1">Set up your child's TLab learning journey. Takes 2 minutes.</p>
                </div>
            </div>
        </div>

        {{-- Errors --}}
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

        {{-- Form --}}
        <form method="POST" action="{{ route('parent.children.store') }}" class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 space-y-7">
            @csrf

            {{-- Step indicator --}}
            <div class="flex items-center justify-between mb-2">
                <div class="flex items-center gap-2">
                    <span class="w-2 h-2 rounded-full bg-primary"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-200"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-200"></span>
                    <span class="w-2 h-2 rounded-full bg-gray-200"></span>
                </div>
                <span class="text-xs font-bold text-muted">Step 1 of 4</span>
            </div>

            {{-- Section: Basic Info --}}
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
                        <input type="text" name="name" value="{{ old('name') }}" required placeholder="e.g. Adaeze Okonkwo"
                               class="form-input">
                    </div>

                    <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                        <div>
                            <label class="form-label">Date of Birth</label>
                            <input type="date" name="dob" value="{{ old('dob') }}" required
                                   class="form-input">
                        </div>
                        <div>
                            <label class="form-label">Gender</label>
                            <select name="gender" required class="form-input appearance-none bg-no-repeat" style="background-image:url(\"data:image/svg+xml,%3Csvg xmlns='http://www.w3.org/2000/svg' fill='none' viewBox='0 0 24 24' stroke='%239CA3AF'%3E%3Cpath stroke-linecap='round' stroke-linejoin='round' stroke-width='2' d='M19 9l-7 7-7-7'/%3E%3C/svg%3E\");background-position:right 16px center;background-size:20px;">
                                <option value="">Select...</option>
                                <option value="male" {{ old('gender') == 'male' ? 'selected' : '' }}>Male</option>
                                <option value="female" {{ old('gender') == 'female' ? 'selected' : '' }}>Female</option>
                                <option value="prefer_not_to_say" {{ old('gender') == 'prefer_not_to_say' ? 'selected' : '' }}>Prefer not to say</option>
                            </select>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100"></div>

            {{-- Section: Login --}}
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
                        <input type="text" name="username" value="{{ old('username') }}" maxlength="50" placeholder="e.g. adaeze"
                               class="form-input">
                        <p class="text-xs text-muted mt-2">Used with PIN for child-safe login. Must be unique.</p>
                    </div>

                    <div>
                        <label class="form-label">
                            Child Login PIN
                            <span class="font-normal text-muted">(4 digits)</span>
                        </label>
                        <div class="flex items-center gap-4">
                            <input type="text" name="pin" maxlength="4" pattern="\d{4}" value="{{ old('pin') }}"
                                   class="form-input !w-32 text-center text-2xl tracking-widest" placeholder="&bull;&bull;&bull;&bull;">
                            <label class="flex items-center gap-2.5 cursor-pointer select-none">
                                <input type="checkbox" name="pin_enabled" value="1" {{ old('pin_enabled') ? 'checked' : '' }}
                                       class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary">
                                <span class="text-sm font-semibold text-muted">Enable PIN login</span>
                            </label>
                        </div>
                        <p class="text-xs text-muted mt-2">Lets your child log in independently without accessing your parent account.</p>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100"></div>

            {{-- Section: Learning Profile --}}
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
                                       {{ old('skill_level', 'beginner') == $value ? 'checked' : '' }}>
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
                                        {{ in_array($value, old('interests', [])) ? 'border-primary bg-primary/5' : '' }}">
                                <input type="checkbox" name="interests[]" value="{{ $value }}"
                                       class="w-4 h-4 rounded border-gray-300 text-primary focus:ring-primary"
                                       {{ in_array($value, old('interests', [])) ? 'checked' : '' }}>
                                <span class="text-sm font-semibold"><span class="mr-1.5">{{ $emoji }}</span>{{ $label }}</span>
                            </label>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>

            {{-- Divider --}}
            <div class="border-t border-gray-100"></div>

            {{-- Section: Confirm --}}
            <div>
                <div class="flex items-center gap-3 mb-5">
                    <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center">
                        <svg class="w-4 h-4 text-amber-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                    </div>
                    <h2 class="font-black text-lg text-ink">Ready to Launch</h2>
                </div>

                <div class="bg-gradient-to-br from-primary/5 to-primary/10 rounded-2xl p-5 border border-primary/20">
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-primary/20 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-primary" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                        </div>
                        <div>
                            <p class="font-bold text-sm text-ink">After creating this profile, you can:</p>
                            <ul class="text-sm text-muted mt-2 space-y-1.5">
                                <li class="flex items-center gap-2">· Enroll them in any TLab club and course</li>
                                <li class="flex items-center gap-2">· Track their XP, rank, and attendance</li>
                                <li class="flex items-center gap-2">· Switch to their dashboard to see their view</li>
                                <li class="flex items-center gap-2">· Edit or manage their profile anytime</li>
                            </ul>
                        </div>
                    </div>
                </div>

                <div class="mt-6">
                    <button type="submit"
                            class="w-full py-4 rounded-2xl font-bold text-white text-base transition-all hover:-translate-y-0.5 active:translate-y-0 shadow-lg hover:shadow-xl"
                            style="background:linear-gradient(135deg,#16A34A,#15803D)">
                        <span class="flex items-center justify-center gap-3">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                            Create Child Profile
                        </span>
                    </button>
                    <p class="text-center text-muted text-sm mt-4">You can add more children anytime from your dashboard.</p>
                </div>
            </div>
        </form>
    </div>
</div>
@endsection
