@extends('layouts.admin')

@section('title', 'Dashboard')

@section('content')

<div class="mb-8">
    <h1 class="font-display text-3xl font-bold mb-1">Dashboard</h1>
    <p class="text-cream/50 text-sm">Platform overview — real-time stats across the TLab ecosystem.</p>
</div>

{{-- Stats Grid --}}
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 mb-8">
    @foreach([
        ['Parents', $stats['parents'], '#4E9966', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z'],
        ['Children', $stats['children'], '#D4A224', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z'],
        ['Teachers', $stats['teachers'], '#2E8BC0', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z'],
        ['Clubs', $stats['clubs'], '#C24B1E', 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10'],
        ['Courses', $stats['courses'], '#6B3FA0', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253'],
        ['Enrollments', $stats['enrollments'], '#D4A224', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2'],
        ['Paid', $stats['paid'], '#4E9966', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z'],
        ['Pass Rate', $passRate . '%', '#4E9966', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z'],
    ] as [$label, $val, $color, $icon])
    <div class="card p-4">
        <div class="flex items-center justify-between mb-2">
            <span class="text-cream/50 text-[10px] font-bold uppercase tracking-wider">{{ $label }}</span>
            <svg class="w-3.5 h-3.5 opacity-40" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $color }}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
        </div>
        <div class="font-display text-2xl font-black" style="color:{{ $color }}">{{ is_numeric($val) ? number_format($val) : $val }}</div>
    </div>
    @endforeach
</div>

{{-- Revenue & Growth Row --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Revenue Chart --}}
    <div class="lg:col-span-2 card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg font-bold">Revenue (6 Months)</h2>
            <div class="flex items-center gap-4">
                <span class="text-xs text-cream/50">Total: <strong class="text-gold">{{ number_format($revenue['total']) }} NGN</strong></span>
                <span class="text-xs text-cream/50">This Month: <strong class="text-mint">{{ number_format($revenue['monthly']) }} NGN</strong></span>
            </div>
        </div>
        <canvas id="revenueChart" height="80"></canvas>
    </div>

    {{-- Growth Stats --}}
    <div class="card p-6">
        <h2 class="font-display text-lg font-bold mb-4">This Month's Growth</h2>
        <div class="space-y-4">
            @foreach([
                ['New Parents', $growth['new_parents'], '#4E9966', 'M17 20h5v-2a3 3 0 00-5.356-1.857'],
                ['New Children', $growth['new_children'], '#D4A224', 'M16 7a4 4 0 11-8 0 4 4 0 018 0z'],
                ['New Enrollments', $growth['new_enrollments'], '#2E8BC0', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2'],
            ] as [$label, $val, $color, $icon])
            <div class="flex items-center justify-between p-4 rounded-xl" style="background:rgba(255,255,255,0.03)">
                <div class="flex items-center gap-3">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $color }}">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                    </svg>
                    <span class="text-sm font-semibold text-cream/70">{{ $label }}</span>
                </div>
                <span class="font-black text-xl" style="color:{{ $color }}">{{ $val }}</span>
            </div>
            @endforeach
        </div>
        <div class="mt-4 p-4 rounded-xl" style="background:rgba(78,153,102,0.05)">
            <div class="text-xs text-cream/50 font-bold uppercase tracking-wider mb-2">XP Stats</div>
            <div class="flex justify-between text-sm">
                <span>Total XP: <strong class="text-gold">{{ number_format($xpStats['total']) }}</strong></span>
                <span>Avg: <strong class="text-mint">{{ number_format($xpStats['avg']) }}</strong></span>
            </div>
            @if($xpStats['top_child'])
            <div class="text-xs text-cream/50 mt-2">Top: <strong class="text-cream">{{ $xpStats['top_child']->name }}</strong> ({{ number_format($xpStats['top_child']->xp) }} XP)</div>
            @endif
        </div>
    </div>
</div>

{{-- Three Column: Recent Users, Children, Payments --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Recent Users --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg font-bold">Recent Parents</h2>
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
                <span class="badge badge-green text-[10px]">{{ $user->role }}</span>
            </div>
            @empty
            <p class="text-cream/30 text-sm text-center py-6">No users registered yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Children --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg font-bold">Recent Children</h2>
            <a href="{{ route('admin.children.index') }}" class="text-mint text-sm font-bold hover:underline">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($recentChildren as $child)
            <div class="flex items-center gap-3 py-2 table-row">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold flex-shrink-0" style="background:rgba(212,162,36,0.1);border:1px solid rgba(212,162,36,0.2);color:#D4A224">
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

    {{-- Recent Payments --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-lg font-bold">Recent Payments</h2>
            <a href="{{ route('admin.payments.index') }}" class="text-mint text-sm font-bold hover:underline">View all</a>
        </div>
        <div class="space-y-3">
            @forelse($recentPayments as $payment)
            <div class="flex items-center gap-3 py-2 table-row">
                <div class="w-9 h-9 rounded-xl bg-gold/10 border border-gold/20 flex items-center justify-center text-xs font-bold text-gold flex-shrink-0">
                    ₦
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-sm truncate">{{ number_format($payment->amount) }} NGN</div>
                    <div class="text-cream/40 text-xs">{{ $payment->user->name ?? 'N/A' }}</div>
                </div>
                <span class="text-cream/50 text-xs">{{ $payment->created_at->diffForHumans() }}</span>
            </div>
            @empty
            <p class="text-cream/30 text-sm text-center py-6">No payments yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="card p-6">
    <h2 class="font-display text-lg font-bold mb-4">Quick Actions</h2>
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.clubs.create') }}" class="p-4 rounded-xl border border-white/5 hover:border-mint/30 transition-all text-center group">
            <svg class="w-6 h-6 mx-auto mb-2 text-cream/40 group-hover:text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            <span class="text-xs font-bold text-cream/60 group-hover:text-cream">New Club</span>
        </a>
        <a href="{{ route('admin.courses.create') }}" class="p-4 rounded-xl border border-white/5 hover:border-mint/30 transition-all text-center group">
            <svg class="w-6 h-6 mx-auto mb-2 text-cream/40 group-hover:text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/></svg>
            <span class="text-xs font-bold text-cream/60 group-hover:text-cream">New Course</span>
        </a>
        <a href="{{ route('admin.safety.safe-links') }}" class="p-4 rounded-xl border border-white/5 hover:border-mint/30 transition-all text-center group">
            <svg class="w-6 h-6 mx-auto mb-2 text-cream/40 group-hover:text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.828 10.172a4 4 0 00-5.656 0l-4 4a4 4 0 105.656 5.656l1.102-1.101m-.758-4.899a4 4 0 005.656 0l4-4a4 4 0 00-5.656-5.656l-1.1 1.1"/></svg>
            <span class="text-xs font-bold text-cream/60 group-hover:text-cream">Safe Links</span>
        </a>
        <a href="{{ route('admin.schools.index') }}" class="p-4 rounded-xl border border-white/5 hover:border-mint/30 transition-all text-center group">
            <svg class="w-6 h-6 mx-auto mb-2 text-cream/40 group-hover:text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            <span class="text-xs font-bold text-cream/60 group-hover:text-cream">Schools</span>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
new Chart(document.getElementById('revenueChart'), {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($monthlyRevenue, 'month')) !!},
        datasets: [{
            label: 'Revenue (NGN)',
            data: {!! json_encode(array_column($monthlyRevenue, 'amount')) !!},
            borderColor: '#4E9966',
            backgroundColor: 'rgba(78,153,102,0.1)',
            fill: true,
            tension: 0.4,
            pointBackgroundColor: '#4E9966',
            pointBorderColor: '#0F1612',
            pointBorderWidth: 2,
            pointRadius: 4,
        }]
    },
    options: {
        responsive: true,
        plugins: { legend: { display: false } },
        scales: {
            x: { ticks: { color: 'rgba(250,245,232,0.4)', font: { size: 10 } }, grid: { color: 'rgba(250,245,232,0.05)' } },
            y: { ticks: { color: 'rgba(250,245,232,0.4)', font: { size: 10 }, callback: v => '₦' + (v/1000).toFixed(0) + 'k' }, grid: { color: 'rgba(250,245,232,0.05)' } }
        }
    }
});
</script>
@endpush
