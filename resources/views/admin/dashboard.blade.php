@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="font-display text-3xl font-bold mb-1">Dashboard</h1>
    <p class="text-cream/50 text-sm">Platform overview — real-time stats across the TLab ecosystem.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-6 gap-4 mb-10">
    @foreach([
        ['Parents',     $stats['parents'],     '#4E9966', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Children',    $stats['children'],    '#D4A224', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['Clubs',       $stats['clubs'],       '#C24B1E', 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
        ['Courses',     $stats['courses'],     '#6B3FA0', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['Enrollments', $stats['enrollments'], '#2E8BC0', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['Paid',        $stats['paid'],         '#4E9966', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
    ] as [$label, $val, $color, $icon])
    <div class="card p-5">
        <div class="flex items-center justify-between mb-3">
            <span class="text-cream/50 text-xs font-bold uppercase tracking-wider">{{ $label }}</span>
            <svg class="w-4 h-4 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $color }}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
        </div>
        <div class="font-display text-3xl font-black" style="color:{{ $color }}">{{ number_format($val) }}</div>
    </div>
    @endforeach
</div>

{{-- Two Column: Recent Users + Recent Children --}}
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

    {{-- Recent Registrations --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display text-lg font-bold">Recent Registrations</h2>
            <a href="{{ route('admin.users.index') }}" class="text-mint text-sm font-bold hover:underline">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($recentUsers as $user)
            <div class="flex items-center gap-3 py-2 table-row">
                <div class="w-9 h-9 rounded-xl bg-mint/10 border border-mint/20 flex items-center justify-center text-xs font-bold text-mint flex-shrink-0">
                    {{ strtoupper(substr($user->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-sm truncate">{{ $user->name }}</div>
                    <div class="text-cream/40 text-xs truncate">{{ $user->email }}</div>
                </div>
                <span class="badge {{ $user->role === 'super_admin' ? 'badge-gold' : 'badge-green' }}">
                    {{ $user->role }}
                </span>
            </div>
            @empty
            <p class="text-cream/30 text-sm text-center py-6">No users registered yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Children --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-5">
            <h2 class="font-display text-lg font-bold">Recent Child Profiles</h2>
            <a href="{{ route('admin.children.index') }}" class="text-mint text-sm font-bold hover:underline">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($recentChildren as $child)
            <div class="flex items-center gap-3 py-2 table-row">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold flex-shrink-0"
                     style="background:rgba(212,162,36,0.1); border:1px solid rgba(212,162,36,0.2); color:#D4A224">
                    {{ strtoupper(substr($child->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-sm truncate">{{ $child->name }}</div>
                    <div class="text-cream/40 text-xs">via {{ $child->parent->name ?? 'Unknown' }}</div>
                </div>
                <span class="text-cream/50 text-xs font-bold">{{ number_format($child->xp) }} XP</span>
            </div>
            @empty
            <p class="text-cream/30 text-sm text-center py-6">No child profiles yet.</p>
            @endforelse
        </div>
    </div>

</div>
@endsection
