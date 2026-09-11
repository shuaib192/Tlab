@extends('layouts.parent')
@section('title', 'My Children')

@section('parent-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    @php
        $rankData = [
            'Explorer'       => ['color'=>'#16A34A','bg'=>'#F0FDF4','svg'=>'M3 3v1.5A5.5 5.5 0 008.5 10H13m1-6v7m-2-7v7m-5 5h10','gradient'=>'from-emerald-500 to-emerald-600'],
            'Innovator'      => ['color'=>'#2563EB','bg'=>'#EFF6FF','svg'=>'M13 2L3 14h7l-1 8 10-12h-7l1-8z','gradient'=>'from-blue-500 to-blue-600'],
            'Builder'        => ['color'=>'#EA580C','bg'=>'#FFF7ED','svg'=>'M14.7 6.3a1 1 0 000 1.4l1.6 1.6a1 1 0 001.4 0l3.77-3.77a6 6 0 01-7.94 7.94l-6.91 6.91a2.12 2.12 0 01-3-3l6.91-6.91a6 6 0 017.94-7.94l-3.76 3.76z','gradient'=>'from-orange-500 to-orange-600'],
            'Creator'        => ['color'=>'#7C3AED','bg'=>'#F5F3FF','svg'=>'M9.53 16.122a3 3 0 00-5.78 1.128 2.25 2.25 0 01-2.4 2.245 4.5 4.5 0 008.4-2.245 4.5 4.5 0 00-.22-1.128zm0 0L15.75 9.75m-6.465 13.872A2.25 2.25 0 005.3 14.417a5.9 5.9 0 015.622-6.622A2.25 2.25 0 0013.25 2.25H11.25a2.25 2.25 0 00-.965 4.3','gradient'=>'from-violet-500 to-violet-600'],
            'Master Inventor'=> ['color'=>'#D97706','bg'=>'#FFFBEB','svg'=>'M15.36 2.64c1.96 1.76 4.57 3.1 7.14 3.43-.33 2.57-1.67 5.18-3.43 7.14-3.83 3.83-8 5.29-8 5.29l-6-6s1.46-4.17 5.29-8c1.96-1.96 4.57-3.11 7.14-3.43zM5.5 16.5c-1.5 1.5-2.5 5-2.5 5s3.5-1 5-2.5','gradient'=>'from-amber-500 to-amber-600'],
        ];
    @endphp

    {{-- Header --}}
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
        <div>
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-primary/10 to-accent/10 flex items-center justify-center">
                    <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                </div>
                <h1 class="font-black text-2xl text-ink">My Children</h1>
                <span class="text-xs font-bold bg-gray-100 text-muted px-3 py-1.5 rounded-full">{{ $children->count() }} total</span>
            </div>
            <p class="text-muted/70 text-sm mt-1 ml-[3.25rem]">Manage profiles, track progress, and switch between children.</p>
        </div>
        <a href="{{ route('parent.children.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-3 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all shadow-sm hover:shadow-md active:scale-95 flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
            Add Child
        </a>
    </div>

    @if($children->isEmpty())
        <div class="relative overflow-hidden bg-white rounded-3xl border border-gray-100 shadow-sm p-16 text-center">
            <div class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-primary/5 to-accent/5 rounded-full blur-3xl -translate-x-1/2 -translate-y-1/2"></div>
            <div class="relative z-10">
                <div class="w-24 h-24 rounded-3xl bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center mx-auto mb-5">
                    <svg class="w-10 h-10 text-primary/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M18 9v3m0 0v3m0-3h3m-3 0h-3m-2-5a4 4 0 11-8 0 4 4 0 018 0zM3 20a6 6 0 0112 0v1H3v-1z"/></svg>
                </div>
                <h2 class="font-black text-2xl text-ink mb-2">No Children Yet</h2>
                <p class="text-muted text-sm max-w-sm mx-auto mb-6">Add your first child's profile to start tracking their STEM learning journey.</p>
                <a href="{{ route('parent.children.create') }}" class="inline-flex items-center gap-2 bg-primary text-white px-6 py-3 rounded-2xl font-bold text-sm hover:bg-primary/90 transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 4v16m8-8H4"/></svg>
                    Add Your First Child
                </a>
            </div>
        </div>
    @else
        <div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
            @foreach($children as $child)
            @php
                $rd = $rankData[$child->rank] ?? $rankData['Explorer'];
                $enrollmentsCount = $child->enrollments()->count();
                $attendedCount = $child->attendance()->where('status', 'present')->count();
                $lastActive = $child->xpLogs()->latest()?->first()?->created_at?->diffForHumans() ?? 'No activity';
            @endphp
            <div class="group bg-white rounded-2xl border border-gray-100 shadow-sm hover:shadow-xl transition-all duration-300 overflow-hidden hover:-translate-y-1">
                <div class="h-2" style="background:linear-gradient(90deg,{{ $rd['color'] }},{{ $rd['color'] }}88)"></div>
                <div class="p-6">
                    <div class="flex items-center gap-4 mb-5">
                        <div class="relative">
                            <div class="w-16 h-16 rounded-2xl font-black text-2xl flex items-center justify-center shadow-sm transition-transform group-hover:scale-105"
                                 style="background:{{ $rd['bg'] }};color:{{ $rd['color'] }};border:2px solid {{ $rd['color'] }}30">
                                {{ strtoupper(substr($child->name, 0, 1)) }}
                            </div>
                            <div class="absolute -top-1 -right-1 w-6 h-6 rounded-full bg-white shadow-sm grid place-items-center text-xs border border-gray-100" style="color:{{ $rd['color'] }}">
                                    <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $rd['svg'] }}"/></svg>
                                </div>
                        </div>
                        <div class="flex-1 min-w-0">
                            <div class="font-black text-lg text-ink truncate">{{ $child->name }}</div>
                            <div class="flex items-center gap-2 mt-0.5">
                                <span class="text-muted text-xs font-semibold">Age {{ $child->age ?? 'N/A' }}</span>
                                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                                <span class="text-xs font-bold uppercase tracking-wider" style="color:{{ $rd['color'] }}">{{ $child->rank }}</span>
                            </div>
                        </div>
                    </div>

                    <div class="mb-5 p-4 rounded-xl" style="background:{{ $rd['bg'] }}">
                        <div class="flex justify-between text-xs font-bold mb-2">
                            <span class="text-ink">{{ number_format($child->xp) }} XP</span>
                            <span class="text-muted/80">{{ $child->rank_progress }}% to next rank</span>
                        </div>
                        <div class="h-2.5 rounded-full bg-white/60 overflow-hidden">
                            <div class="h-full rounded-full transition-all duration-1000 ease-out" style="width:{{ $child->rank_progress }}%;background:linear-gradient(90deg,{{ $rd['color'] }},{{ $rd['color'] }}88)"></div>
                        </div>
                    </div>

                    <div class="grid grid-cols-3 gap-2 mb-4">
                        <div class="rounded-xl p-3 text-center border border-gray-100">
                            <div class="font-black text-lg" style="color:{{ $rd['color'] }}">{{ $enrollmentsCount }}</div>
                            <div class="text-muted text-xs font-semibold">Courses</div>
                        </div>
                        <div class="rounded-xl p-3 text-center border border-gray-100">
                            <div class="font-black text-lg text-accent">{{ $attendedCount }}</div>
                            <div class="text-muted text-xs font-semibold">Attended</div>
                        </div>
                        <div class="rounded-xl p-3 text-center border border-gray-100">
                            <div class="font-black text-lg text-amber-600">{{ number_format($child->xp) }}</div>
                            <div class="text-muted text-xs font-semibold">XP</div>
                        </div>
                    </div>

                    <div class="flex items-center gap-1.5 text-xs text-muted mb-4">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4l3 3m6-3a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                        {{ $lastActive }}
                    </div>

                    <div class="flex gap-2">
                        <a href="{{ route('parent.children.switch', $child) }}"
                           class="flex-1 py-3 rounded-xl font-bold text-white text-xs text-center transition-all hover:-translate-y-0.5 shadow-sm hover:shadow-md active:scale-95"
                           style="background:linear-gradient(135deg,{{ $rd['color'] }},{{ $rd['color'] }}cc)">
                            <span class="flex items-center justify-center gap-1.5">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 3.055A9.001 9.001 0 1020.945 13H11V3.055z"/></svg>
                                Dashboard
                            </span>
                        </a>
                        <a href="{{ route('parent.children.show', $child) }}"
                           class="px-4 py-3 rounded-xl border border-gray-200 text-muted text-xs font-bold hover:border-gray-300 hover:text-ink transition-all">Profile</a>
                        <a href="{{ route('parent.children.edit', $child) }}"
                           class="px-4 py-3 rounded-xl border border-gray-200 text-muted text-xs font-bold hover:border-gray-300 hover:text-ink transition-all">Edit</a>
                    </div>
                </div>
            </div>
            @endforeach

            {{-- Add child card --}}
            <a href="{{ route('parent.children.create') }}"
               class="group bg-white rounded-2xl border-2 border-dashed border-gray-200 hover:border-primary/40 transition-all flex flex-col items-center justify-center p-8 min-h-[300px] hover:shadow-lg hover:-translate-y-1 duration-300">
                <div class="w-16 h-16 rounded-3xl bg-gradient-to-br from-primary/10 to-primary/5 flex items-center justify-center mb-4 group-hover:scale-110 group-hover:from-primary/20 group-hover:to-primary/10 transition-all">
                    <svg class="w-7 h-7 text-primary/50 group-hover:text-primary transition-colors" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                </div>
                <div class="font-black text-sm text-muted group-hover:text-primary transition-colors">Add Another Child</div>
                <div class="text-xs text-muted/50 mt-1">Click to create a new profile</div>
            </a>
        </div>
    @endif
</div>
@endsection
