@extends('layouts.app')
@section('title', $child->name . ' — Profile')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-gray-50 to-white">
    <div class="max-w-5xl mx-auto px-4 sm:px-8 py-8 sm:py-12">

        {{-- Back --}}
        <a href="{{ route('parent.dashboard') }}" 
           class="inline-flex items-center gap-2 text-muted hover:text-ink font-bold text-sm mb-8 transition-colors group">
            <svg class="w-4 h-4 transition-transform group-hover:-translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            Back to Dashboard
        </a>

        @php
            $rankColors = [
                'Explorer'       => ['color'=>'#16A34A','bg'=>'#F0FDF4','light'=>'#DCFCE7','border'=>'#86EFAC','emoji'=>'🌱','desc'=>'Just starting the journey'],
                'Innovator'      => ['color'=>'#2563EB','bg'=>'#EFF6FF','light'=>'#DBEAFE','border'=>'#93C5FD','emoji'=>'⚡','desc'=>'Discovering new ideas'],
                'Builder'        => ['color'=>'#EA580C','bg'=>'#FFF7ED','light'=>'#FFEDD5','border'=>'#FDBA74','emoji'=>'🔨','desc'=>'Building real skills'],
                'Creator'        => ['color'=>'#7C3AED','bg'=>'#F5F3FF','light'=>'#EDE9FE','border'=>'#C4B5FD','emoji'=>'🎨','desc'=>'Creating and innovating'],
                'Master Inventor'=> ['color'=>'#D97706','bg'=>'#FFFBEB','light'=>'#FEF3C7','border'=>'#FCD34D','emoji'=>'🚀','desc'=>'Master of their craft'],
            ];
            $rc = $rankColors[$child->rank] ?? $rankColors['Explorer'];
            $progress = $child->rank_progress;

            $totalSessions = $child->attendance()->count();
            $presentCount = $child->attendance()->where('status', 'present')->count();
            $attendancePct = $totalSessions > 0 ? round(($presentCount / $totalSessions) * 100) : null;
            $courseCount = $child->enrollments()->count();
            $activeCount = $child->enrollments()->where('status', 'active')->count();
            $completedCount = $child->enrollments()->where('status', 'completed')->count();

            $xpLogs = $child->xpLogs()->latest()->take(15)->get();
            $enrollments = $child->enrollments()->with('course.club')->latest()->get();
            $achievements = $child->achievements()->get();
        @endphp

        @if(session('success'))
            <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm mb-8">
                <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
                {{ session('success') }}
            </div>
        @endif

        {{-- ── PROFILE HEADER ── --}}
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-6 sm:p-8 mb-8">
            <div class="flex flex-col sm:flex-row items-start sm:items-center gap-6">
                {{-- Avatar --}}
                <div class="w-20 h-20 sm:w-24 sm:h-24 rounded-3xl flex items-center justify-center font-black text-4xl sm:text-5xl flex-shrink-0 shadow-sm"
                     style="background:{{ $rc['bg'] }};color:{{ $rc['color'] }};border:3px solid {{ $rc['border'] }}">
                    {{ strtoupper(substr($child->name, 0, 1)) }}
                </div>

                {{-- Info --}}
                <div class="flex-1 min-w-0">
                    <div class="flex flex-wrap items-center gap-3 mb-1">
                        <h1 class="font-black text-2xl sm:text-3xl text-ink">{{ $child->name }}</h1>
                        <span class="inline-flex items-center gap-1 px-3 py-1 rounded-full text-xs font-bold"
                              style="background:{{ $rc['bg'] }};color:{{ $rc['color'] }};border:1px solid {{ $rc['border'] }}">
                            {{ $rc['emoji'] }} {{ $child->rank }}
                        </span>
                        @if($child->username)
                        <span class="text-xs text-muted bg-gray-100 px-3 py-1 rounded-full">@ {{ $child->username }}</span>
                        @endif
                    </div>
                    <p class="text-muted font-semibold text-sm">{{ $rc['desc'] }}</p>
                    <div class="flex flex-wrap items-center gap-4 mt-2 text-sm text-muted">
                        <span>Age {{ $child->age ?? 'N/A' }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>{{ ucfirst($child->skill_level) }} level</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span class="font-bold" style="color:{{ $rc['color'] }}">{{ number_format($child->xp) }} XP</span>
                    </div>
                </div>

                {{-- Actions --}}
                <div class="flex gap-3 w-full sm:w-auto">
                    <a href="{{ route('parent.children.switch', $child) }}"
                       class="flex-1 sm:flex-none text-center px-6 py-3 rounded-xl font-bold text-white text-sm transition-all hover:-translate-y-0.5 shadow-sm"
                       style="background:{{ $rc['color'] }}">
                        <span class="flex items-center gap-2 justify-center">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                            Dashboard
                        </span>
                    </a>
                    <a href="{{ route('parent.children.edit', $child) }}"
                       class="flex-1 sm:flex-none text-center px-5 py-3 rounded-xl font-bold text-sm border-2 border-gray-200 text-muted hover:border-gray-300 hover:text-ink transition-all">
                        Edit
                    </a>
                </div>
            </div>

            {{-- XP Bar --}}
            <div class="mt-6 pt-6 border-t border-gray-100">
                <div class="flex justify-between text-sm font-bold mb-2">
                    <span class="text-ink">{{ number_format($child->xp) }} Total XP</span>
                    <span class="text-muted">{{ $child->xp_to_next_rank }} XP to {{ $child->rank === 'Master Inventor' ? 'max rank' : 'next rank' }}</span>
                </div>
                <div class="h-3 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full transition-all duration-1000 ease-out" 
                         style="width:{{ $progress }}%;background:linear-gradient(90deg,{{ $rc['color'] }},{{ $rc['color'] }}88)"
                         x-data x-init="$el.style.width = '0%'; setTimeout(() => $el.style.width = '{{ $progress }}%', 200)">
                    </div>
                </div>
            </div>
        </div>

        {{-- ── STATS ROW ── --}}
        <div class="grid grid-cols-2 sm:grid-cols-4 gap-4 mb-8">
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="font-black text-2xl sm:text-3xl" style="color:{{ $rc['color'] }}">{{ $courseCount }}</div>
                <div class="text-muted font-semibold text-xs mt-1">Total Courses</div>
                @if($activeCount > 0)
                <div class="text-xs text-emerald-600 font-bold mt-1">{{ $activeCount }} active</div>
                @endif
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="font-black text-2xl sm:text-3xl text-accent">{{ $presentCount }}</div>
                <div class="text-muted font-semibold text-xs mt-1">Sessions Attended</div>
                @if($attendancePct !== null)
                <div class="text-xs text-amber-600 font-bold mt-1">{{ $attendancePct }}% rate</div>
                @endif
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="font-black text-2xl sm:text-3xl text-amber-600">{{ $achievements->count() }}</div>
                <div class="text-muted font-semibold text-xs mt-1">Badges Earned</div>
            </div>
            <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 text-center">
                <div class="font-black text-2xl sm:text-3xl text-violet-600">{{ $completedCount }}</div>
                <div class="text-muted font-semibold text-xs mt-1">Completed</div>
            </div>
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">

            {{-- ── LEFT COLUMN ── --}}
            <div class="lg:col-span-2 space-y-8">

                {{-- Enrolled Courses --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-black text-lg text-ink">Enrolled Courses</h2>
                        <span class="text-xs font-bold text-muted bg-gray-100 px-3 py-1.5 rounded-full">{{ $enrollments->count() }}</span>
                    </div>
                    @forelse($enrollments as $e)
                    @php $clubColor = $e->course?->club?->color_theme ?? '#16A34A'; @endphp
                    <div class="flex items-center gap-4 p-4 rounded-xl hover:bg-gray-50 transition-colors {{ !$loop->last ? 'mb-2' : '' }}">
                        <div class="w-10 h-10 rounded-xl flex items-center justify-center text-sm font-bold flex-shrink-0"
                             style="background:{{ $clubColor }}15; color:{{ $clubColor }}">
                            {{ strtoupper(substr($e->course?->club?->name ?? 'C', 0, 1)) }}
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-ink truncate">{{ $e->course?->title ?? 'Unknown Course' }}</div>
                            <div class="text-muted text-xs">{{ $e->course?->club?->name ?? '' }}</div>
                        </div>
                        <div class="flex items-center gap-3">
                            @if($e->cohort)
                            <span class="text-xs text-muted hidden sm:block">{{ $e->cohort->name }}</span>
                            @endif
                            <span class="text-xs px-3 py-1 rounded-full font-bold"
                                  style="background:{{ $e->status === 'active' ? '#F0FDF4' : ($e->status === 'completed' ? '#EFF6FF' : '#FEF2F2') }}; 
                                         color:{{ $e->status === 'active' ? '#16A34A' : ($e->status === 'completed' ? '#2563EB' : '#DC2626') }}">
                                {{ ucfirst($e->status) }}
                            </span>
                        </div>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <div class="text-4xl mb-3">📚</div>
                        <p class="text-muted font-semibold text-sm">No courses enrolled yet.</p>
                        <a href="{{ route('membership') }}" class="text-primary font-bold text-sm hover:underline mt-2 inline-block">View available clubs</a>
                    </div>
                    @endforelse
                </div>

                {{-- XP History --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <div class="flex items-center justify-between mb-5">
                        <h2 class="font-black text-lg text-ink">XP Activity Timeline</h2>
                        <span class="text-xs font-bold text-muted bg-gray-100 px-3 py-1.5 rounded-full">{{ $xpLogs->count() }} events</span>
                    </div>
                    @forelse($xpLogs as $log)
                    <div class="flex items-start gap-4 py-3 {{ !$loop->last ? 'border-b border-gray-50' : '' }}">
                        <div class="w-8 h-8 rounded-lg bg-amber-50 flex items-center justify-center flex-shrink-0 mt-0.5">
                            <svg class="w-4 h-4 text-amber-600" fill="currentColor" viewBox="0 0 20 20"><path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z"/></svg>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-bold text-sm text-ink">{{ $log->activity }}</div>
                            <div class="text-xs text-muted mt-0.5">{{ $log->created_at->format('M j, Y g:i A') }}</div>
                        </div>
                        <span class="font-black text-sm text-amber-600 flex-shrink-0">+{{ $log->amount }} XP</span>
                    </div>
                    @empty
                    <div class="text-center py-10">
                        <div class="text-4xl mb-3">⭐</div>
                        <p class="text-muted font-semibold text-sm">No XP earned yet. Learning adventures await!</p>
                    </div>
                    @endforelse
                </div>
            </div>

            {{-- ── RIGHT COLUMN ── --}}
            <div class="space-y-8">

                {{-- Rank Progression --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="font-black text-lg text-ink mb-5">Rank Journey</h2>
                    <div class="space-y-2">
                        @foreach([
                            ['Explorer', 0, '#16A34A', '🌱'],
                            ['Innovator', 200, '#2563EB', '⚡'],
                            ['Builder', 500, '#EA580C', '🔨'],
                            ['Creator', 1000, '#7C3AED', '🎨'],
                            ['Master Inventor', 2000, '#D97706', '🚀'],
                        ] as [$name, $threshold, $color, $emoji])
                        @php $achieved = $child->xp >= $threshold; @endphp
                        <div class="flex items-center gap-3 p-3 rounded-xl transition-all {{ $child->rank === $name ? 'bg-gray-50 border border-gray-200' : '' }}">
                            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0 transition-all"
                                 style="background:{{ $achieved ? $color . '15' : '#F9FAFB' }}; opacity:{{ $achieved ? '1' : '0.5' }}">
                                {{ $emoji }}
                            </div>
                            <div class="flex-1">
                                <div class="font-bold text-sm {{ $achieved ? 'text-ink' : 'text-muted' }}">{{ $name }}</div>
                                <div class="text-xs text-muted">{{ number_format($threshold) }} XP</div>
                            </div>
                            @if($child->rank === $name)
                                <span class="text-xs font-bold px-2.5 py-1 rounded-full" style="background:{{ $color }}15; color:{{ $color }}">Current</span>
                            @elseif($achieved)
                                <svg class="w-5 h-5 text-emerald-500" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M16.707 5.293a1 1 0 010 1.414l-8 8a1 1 0 01-1.414 0l-4-4a1 1 0 011.414-1.414L8 12.586l7.293-7.293a1 1 0 011.414 0z" clip-rule="evenodd"/></svg>
                            @endif
                        </div>
                        @endforeach
                    </div>
                </div>

                {{-- Achievements --}}
                @if($achievements->isNotEmpty())
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="font-black text-lg text-ink mb-5">Badges & Achievements</h2>
                    <div class="grid grid-cols-3 gap-3">
                        @foreach($achievements as $a)
                        <div class="text-center p-3 rounded-xl bg-gray-50" title="{{ $a->description }}">
                            <div class="text-2xl mb-1">{{ $a->icon ?? '🏆' }}</div>
                            <div class="text-xs font-bold text-muted truncate">{{ $a->name }}</div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                {{-- Quick Actions --}}
                <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
                    <h2 class="font-black text-lg text-ink mb-5">Quick Actions</h2>
                    <div class="space-y-3">
                        <a href="{{ route('parent.children.switch', $child) }}"
                           class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all font-bold text-sm text-ink">
                            <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                            Open Child Dashboard
                        </a>
                        <a href="{{ route('parent.children.edit', $child) }}"
                           class="flex items-center gap-3 p-3 rounded-xl bg-gray-50 hover:bg-gray-100 transition-all font-bold text-sm text-ink">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/></svg>
                            Edit Profile
                        </a>
                    </div>
                </div>

                {{-- Danger Zone --}}
                <div class="bg-white rounded-2xl border border-red-200 shadow-sm p-6">
                    <h2 class="font-black text-lg text-red-600 mb-2">Remove Profile</h2>
                    <p class="text-sm text-muted mb-4">Permanently deletes {{ $child->name }}'s profile, XP, and all enrollments.</p>
                    <form method="POST" action="{{ route('parent.children.destroy', $child) }}"
                          onsubmit="return confirm('Are you sure? This cannot be undone.')">
                        @csrf @method('DELETE')
                        <button type="submit"
                                class="w-full py-3 rounded-xl font-bold text-sm text-red-600 border-2 border-red-200 hover:bg-red-50 transition-all">
                            Remove Profile
                        </button>
                    </form>
                </div>
            </div>

        </div>
    </div>
</div>

<script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.14.1/dist/cdn.min.js"></script>
@endsection
