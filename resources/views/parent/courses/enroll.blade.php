@extends('layouts.parent')
@section('title', 'Enrol — ' . $course->title)

@section('parent-content')
@include('parent.partials.flow-nav', ['label' => 'Enrolment'])

<main class="flow-body min-h-screen px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="max-w-3xl mx-auto">

        @include('parent.partials.stepper', ['step' => 3, 'club' => $course->club])

        @if(session('error'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-xl border border-gray-200 bg-[#FDECEC] font-bold text-sm mb-8" style="box-shadow:0 1px 2px rgba(11,31,28,0.05)">
                <svg class="w-5 h-5 text-[#DC2626] flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                {{ session('error') }}
            </div>
        @endif

        @php
            $accent = $course->club?->accentColor() ?? \App\Models\Club::ACCENTS['teal'];
        @endphp

        <div class="paper-card p-6 sm:p-8 mb-8">
            <div class="flex items-center gap-4 mb-5 border-b-2 border-[#0F201E]/10 pb-5">
                <div class="w-14 h-14 rounded-xl border border-gray-200 grid place-items-center flex-shrink-0 bg-white" style="box-shadow:0 4px 14px -8px {{ $accent }}">
                    <svg class="w-7 h-7" style="color:{{ $accent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/></svg>
                </div>
                <div>
                    <span class="paper-chip text-white mb-1.5" style="background:{{ $accent }}">{{ $course->club->name }}</span>
                    <h1 class="font-black text-2xl sm:text-3xl tracking-tight" style="color:#0F201E">{{ $course->title }}</h1>
                </div>
            </div>

            @if($course->description)
                <p class="font-semibold text-sm leading-relaxed" style="color:#0F201E80">{{ $course->description }}</p>
            @endif

            <div class="flex flex-wrap items-center gap-2 mt-5">
                @if($course->level)
                    <span class="paper-chip text-white" style="background:{{ $accent }}">{{ $course->level }}</span>
                @endif
                @if($course->grade_level)
                    <span class="paper-chip bg-gray-100 text-ink">Grade {{ $course->grade_level }}</span>
                @endif
                @if($course->fee)
                    <span class="paper-chip text-white" style="background:#0F201E">₦{{ number_format($course->fee) }}</span>
                @endif
                @if($course->teacher)
                    <span class="paper-chip bg-white text-[#0F201E] border border-gray-200">{{ $course->teacher->name }}</span>
                @endif
            </div>
        </div>

        <div class="paper-card p-6 sm:p-8">
            @if($children->isEmpty())
                <div class="text-center py-10">
                    <div class="w-20 h-20 mx-auto mb-5 border border-gray-200 rounded-2xl grid place-items-center bg-white" style="box-shadow:0 6px 18px -10px {{ $accent }}">
                        <svg class="w-9 h-9" style="color:{{ $accent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                    </div>
                    <h2 class="font-black text-xl mb-2" style="color:#0F201E">No Children Added Yet</h2>
                    <p class="font-semibold text-sm max-w-sm mx-auto mb-6" style="color:#0F201E80">Add a child profile first, then come back here to enrol them.</p>
                    <a href="{{ route('parent.children.create') }}" class="btn-flat">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Add a Child Profile
                    </a>
                </div>
            @else
                <div class="flex items-center gap-3 mb-6">
                    <div class="w-10 h-10 rounded-lg border border-gray-200 grid place-items-center bg-white" style="box-shadow:0 3px 10px -6px {{ $accent }}">
                        <svg class="w-5 h-5" style="color:{{ $accent }}" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M9 12l2 2 4-4"/></svg>
                    </div>
                    <h2 class="font-black text-xl tracking-tight" style="color:#0F201E">Select a Child to Enrol</h2>
                </div>

                <form method="POST" action="{{ route('parent.courses.enroll.submit', $course) }}">
                    @csrf

                    <div class="space-y-3 mb-8">
                        @foreach($children as $child)
                            @php
                                $isEnrolled = in_array($child->id, $enrolledChildIds);
                            @endphp
                            <label class="block cursor-pointer">
                                <input type="radio" name="child_profile_id" value="{{ $child->id }}"
                                       class="sr-only peer" {{ $isEnrolled ? 'disabled' : '' }} {{ old('child_profile_id') == $child->id ? 'checked' : '' }}>
                                <div class="flex items-center gap-4 px-5 py-4 rounded-xl border border-gray-200 bg-white transition-all duration-150
                                            peer-checked:border-[#0DAA9C] peer-checked:bg-teal-50
                                            {{ $isEnrolled ? 'opacity-50 cursor-not-allowed bg-[#F1EDE2]' : '' }}">
                                    <div class="w-12 h-12 rounded-lg border border-gray-200 grid place-items-center font-black text-lg flex-shrink-0 bg-white"
                                         style="box-shadow:0 3px 10px -6px {{ $accent }}; color:{{ $accent }}">
                                        {{ strtoupper(substr($child->name, 0, 1)) }}
                                    </div>
                                    <div class="flex-1 min-w-0">
                                        <div class="font-black" style="color:#0F201E">{{ $child->name }}</div>
                                        <div class="text-xs font-bold mt-0.5" style="color:#0F201E80">
                                            Age {{ $child->age ?? 'N/A' }}
                                            @if($child->skill_level)
                                                <span class="mx-1.5">·</span>
                                                {{ ucfirst($child->skill_level) }}
                                            @endif
                                        </div>
                                    </div>
                                    @if($isEnrolled)
                                        <span class="paper-chip bg-gray-100 text-ink">
                                            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg>
                                            Enrolled
                                        </span>
                                    @else
                                        <span class="w-6 h-6 rounded-full border border-gray-200 grid place-items-center shrink-0">
                                            <span class="w-3 h-3 rounded-full scale-0 peer-checked:scale-100 transition-transform bg-[#0DAA9C]"></span>
                                        </span>
                                    @endif
                                </div>
                            </label>
                        @endforeach
                    </div>

                    @error('child_profile_id')
                        <p class="text-red-600 text-sm font-bold mb-4">{{ $message }}</p>
                    @enderror

                    <div class="bg-gray-50 text-ink rounded-xl p-5 mb-6" style="box-shadow:0 6px 18px -10px {{ $accent }}">
                        <div class="flex items-start gap-3">
                            <div class="w-8 h-8 rounded-full grid place-items-center flex-shrink-0 mt-0.5" style="background:rgba(13,170,156,0.12)">
                                <svg class="w-4 h-4 text-[#0A7A6E]" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M18 10a8 8 0 11-16 0 8 8 0 0116 0zm-7-4a1 1 0 11-2 0 1 1 0 012 0zM9 9a1 1 0 000 2v3a1 1 0 001 1h1a1 1 0 100-2v-3a1 1 0 00-1-1H9z" clip-rule="evenodd"/></svg>
                            </div>
                            <div>
                                <p class="font-black text-sm">What happens next</p>
                                <ul class="text-xs font-semibold mt-2 space-y-1.5 text-muted">
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0DAA9C]"></span>
                                        Your child gets enrolled immediately
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0DAA9C]"></span>
                                        Move to the payment step to confirm
                                    </li>
                                    <li class="flex items-center gap-2">
                                        <span class="w-1.5 h-1.5 rounded-full bg-[#0DAA9C]"></span>
                                        Start learning the moment it's confirmed
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>

                    <button type="submit" class="btn-flat w-full py-4 text-base" style="background:{{ $accent }};border-color:{{ $accent }}">
                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                        Enrol in {{ $course->title }}
                    </button>
                </form>
            @endif
        </div>
    </div>
</main>

@include('parent.partials.flow-styles')
<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection