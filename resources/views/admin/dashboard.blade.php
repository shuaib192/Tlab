@extends('layouts.admin')

@section('title', 'Admin Dashboard')

@section('content')

{{-- Welcome Banner --}}
<div class="relative overflow-hidden card p-6 sm:p-8 mb-8 bg-gradient-to-r from-panel via-surface to-panel border border-mint/20">
    <div class="absolute -right-10 -bottom-10 w-64 h-64 bg-mint/5 rounded-full blur-3xl pointer-events-none"></div>
    <div class="relative z-10 flex flex-col md:flex-row md:items-center justify-between gap-6">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-full bg-mint/10 border border-mint/30 text-mint text-xs font-bold uppercase tracking-wider mb-3">
                <span class="w-2 h-2 rounded-full bg-mint animate-pulse"></span>
                {{ auth()->user()->isSuperAdmin() ? 'Super Admin Control Center' : 'Admin Portal' }}
            </div>
            <h1 class="font-display text-3xl sm:text-4xl font-extrabold tracking-tight mb-2">
                Welcome back, {{ auth()->user()->name }} 👋
            </h1>
            <p class="text-cream/60 text-sm max-w-2xl">
                Here is what is happening across the TLab ecosystem today. Live stats, revenue trends, and quick access to management tools.
            </p>
        </div>
        <div class="flex items-center gap-3 flex-wrap">
            <a href="{{ route('admin.upcoming.index') }}" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
                Manage Classes
            </a>
            <a href="{{ route('admin.courses.create') }}" class="btn-secondary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
                Add Course
            </a>
        </div>
    </div>
</div>

{{-- Core Stats Grid --}}
<div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-8 gap-3 mb-8">
    @foreach([
        ['Parents', $stats['parents'], '#4E9966', 'M17 20h5v-2a3 3 0 00-5.356-1.857M17 20H7m10 0v-2c0-.656-.126-1.283-.356-1.857M7 20H2v-2a3 3 0 015.356-1.857M7 20v-2c0-.656.126-1.283.356-1.857m0 0a5.002 5.002 0 019.288 0M15 7a3 3 0 11-6 0 3 3 0 016 0z', route('admin.users.index')],
        ['Children', $stats['children'], '#D4A224', 'M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z', route('admin.children.index')],
        ['Teachers', $stats['teachers'], '#2E8BC0', 'M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z', route('admin.users.index')],
        ['Clubs', $stats['clubs'], '#C24B1E', 'M19 11H5m14 0a2 2 0 012 2v6a2 2 0 01-2 2H5a2 2 0 01-2-2v-6a2 2 0 012-2m14 0V9a2 2 0 00-2-2M5 11V9a2 2 0 012-2m0 0V5a2 2 0 012-2h6a2 2 0 012 2v2M7 7h10', route('admin.clubs.index')],
        ['Courses', $stats['courses'], '#6B3FA0', 'M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253', route('admin.courses.index')],
        ['Enrollments', $stats['enrollments'], '#D4A224', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2', route('admin.enrollments.index')],
        ['Paid', $stats['paid'], '#4E9966', 'M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z', route('admin.payments.index')],
        ['Pass Rate', $passRate . '%', '#4E9966', 'M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', '#'],
    ] as [$label, $val, $color, $icon, $link])
    <a href="{{ $link }}" class="card p-4 hover:border-mint/40 transition-all group block">
        <div class="flex items-center justify-between mb-2">
            <span class="text-cream/50 text-[10px] font-bold uppercase tracking-wider group-hover:text-cream transition-colors">{{ $label }}</span>
            <svg class="w-3.5 h-3.5 opacity-50 group-hover:opacity-100 transition-opacity" fill="none" stroke="currentColor" viewBox="0 0 24 24" style="color:{{ $color }}">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
            </svg>
        </div>
        <div class="font-display text-2xl font-black" style="color:{{ $color }}">{{ is_numeric($val) ? number_format($val) : $val }}</div>
    </a>
    @endforeach
</div>

{{-- Revenue Chart & Growth --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Revenue Chart --}}
    <div class="lg:col-span-2 card p-6">
        <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-6">
            <div>
                <h2 class="font-display text-lg font-bold">Revenue Performance</h2>
                <p class="text-cream/50 text-xs">Past 6 months verified subscription & enrollment payments</p>
            </div>
            <div class="flex items-center gap-4 bg-black/20 px-4 py-2 rounded-xl border border-white/5">
                <div>
                    <div class="text-[10px] uppercase font-bold text-cream/40">Total Volume</div>
                    <div class="font-bold text-gold text-sm">{{ number_format($revenue['total']) }} NGN</div>
                </div>
                <div class="w-px h-8 bg-white/10"></div>
                <div>
                    <div class="text-[10px] uppercase font-bold text-cream/40">This Month</div>
                    <div class="font-bold text-mint text-sm">{{ number_format($revenue['monthly']) }} NGN</div>
                </div>
            </div>
        </div>
        <div class="relative h-72">
            <canvas id="revenueChart"></canvas>
        </div>
    </div>

    {{-- Growth & XP Stats --}}
    <div class="card p-6 flex flex-col justify-between">
        <div>
            <h2 class="font-display text-lg font-bold mb-1">Growth & Engagement</h2>
            <p class="text-cream/50 text-xs mb-4">New signups and student XP metrics</p>
            
            <div class="space-y-3">
                @foreach([
                    ['New Parents', $growth['new_parents'], '#4E9966', 'M17 20h5v-2a3 3 0 00-5.356-1.857'],
                    ['New Children', $growth['new_children'], '#D4A224', 'M16 7a4 4 0 11-8 0 4 4 0 018 0z'],
                    ['New Enrollments', $growth['new_enrollments'], '#2E8BC0', 'M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2'],
                ] as [$label, $val, $color, $icon])
                <div class="flex items-center justify-between p-3.5 rounded-xl bg-white/[0.02] border border-white/5">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-lg flex items-center justify-center bg-black/30" style="color:{{ $color }}">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $icon }}"/>
                            </svg>
                        </div>
                        <span class="text-xs font-semibold text-cream/80">{{ $label }}</span>
                    </div>
                    <span class="font-black text-lg" style="color:{{ $color }}">+{{ $val }}</span>
                </div>
                @endforeach
            </div>
        </div>

        <div class="mt-6 p-4 rounded-xl bg-mint/5 border border-mint/20">
            <div class="flex items-center justify-between mb-2">
                <span class="text-xs font-bold uppercase tracking-wider text-mint">XP Ecosystem</span>
                <span class="text-xs text-cream/60">Total: <strong class="text-gold">{{ number_format($xpStats['total']) }} XP</strong></span>
            </div>
            @if($xpStats['top_child'])
            <div class="flex items-center gap-3 pt-2 border-t border-white/5">
                <div class="w-7 h-7 rounded-full bg-gold/20 text-gold font-bold text-xs flex items-center justify-center">🏆</div>
                <div class="min-w-0">
                    <div class="text-xs text-cream/50">Top Leaderboard Student</div>
                    <div class="text-xs font-bold text-cream truncate">{{ $xpStats['top_child']->name }} <span class="text-gold">({{ number_format($xpStats['top_child']->xp) }} XP)</span></div>
                </div>
            </div>
            @endif
        </div>
    </div>
</div>

{{-- Three Column: Recent Users, Children, Payments --}}
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    {{-- Recent Users --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-base font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4.354a4 4 0 110 5.292M15 21H3v-1a6 6 0 0112 0v1zm0 0h6v-1a6 6 0 00-9-5.197M13 7a4 4 0 11-8 0 4 4 0 018 0z"/></svg>
                Recent Parents
            </h2>
            <a href="{{ route('admin.users.index') }}" class="text-mint text-xs font-bold hover:underline">View all →</a>
        </div>
        <div class="space-y-3">
            @forelse($recentUsers as $user)
            <div class="flex items-center gap-3 py-2.5 px-3 rounded-xl bg-white/[0.01] hover:bg-white/[0.03] transition-colors border border-white/5">
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
            <h2 class="font-display text-base font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-gold" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 10h47v4h-7zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                Recent Children
            </h2>
            <a href="{{ route('admin.children.index') }}" class="text-mint text-xs font-bold hover:underline">View all →</a>
        </div>
        <div class="space-y-3">
            @forelse($recentChildren as $child)
            <div class="flex items-center gap-3 py-2.5 px-3 rounded-xl bg-white/[0.01] hover:bg-white/[0.03] transition-colors border border-white/5">
                <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold flex-shrink-0" style="background:rgba(212,162,36,0.1);border:1px solid rgba(212,162,36,0.2);color:#D4A224">
                    {{ strtoupper(substr($child->name, 0, 1)) }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-sm truncate">{{ $child->name }}</div>
                    <div class="text-cream/40 text-xs">Parent: {{ $child->parent->name ?? 'Unknown' }}</div>
                </div>
                <span class="text-gold text-xs font-extrabold bg-gold/10 px-2.5 py-1 rounded-full border border-gold/20">{{ number_format($child->xp) }} XP</span>
            </div>
            @empty
            <p class="text-cream/30 text-sm text-center py-6">No child profiles yet.</p>
            @endforelse
        </div>
    </div>

    {{-- Recent Payments --}}
    <div class="card p-6">
        <div class="flex items-center justify-between mb-4">
            <h2 class="font-display text-base font-bold flex items-center gap-2">
                <svg class="w-4 h-4 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8c-1.657 0-3 .895-3 2s1.343 2 3 2 3 .895 3 2-1.343 2-3 2m0-8c1.11 0 2.08.402 2.599 1M12 8V7m0 1v8m0 0v1m0-1c-1.11 0-2.08-.402-2.599-1M21 12a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
                Recent Payments
            </h2>
            <a href="{{ route('admin.payments.index') }}" class="text-mint text-xs font-bold hover:underline">View all →</a>
        </div>
        <div class="space-y-3">
            @forelse($recentPayments as $payment)
            <div class="flex items-center gap-3 py-2.5 px-3 rounded-xl bg-white/[0.01] hover:bg-white/[0.03] transition-colors border border-white/5">
                <div class="w-9 h-9 rounded-xl bg-gold/10 border border-gold/20 flex items-center justify-center text-xs font-bold text-gold flex-shrink-0">
                    ₦
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-semibold text-sm text-gold truncate">₦{{ number_format($payment->amount) }}</div>
                    <div class="text-cream/40 text-xs truncate">{{ $payment->user->name ?? 'N/A' }}</div>
                </div>
                <span class="text-cream/40 text-[11px]">{{ $payment->created_at->diffForHumans(null, true) }}</span>
            </div>
            @empty
            <p class="text-cream/30 text-sm text-center py-6">No payments yet.</p>
            @endforelse
        </div>
    </div>
</div>

{{-- Quick Actions --}}
<div class="card p-6">
    <h2 class="font-display text-base font-bold mb-4">Quick Management Actions</h2>
    <div class="grid grid-cols-2 sm:grid-cols-2 md:grid-cols-4 gap-4">
        <a href="{{ route('admin.clubs.create') }}" class="p-4 rounded-xl bg-white/[0.02] border border-white/5 hover:border-mint/40 hover:bg-mint/[0.03] transition-all text-center group">
            <div class="w-10 h-10 rounded-xl bg-mint/10 border border-mint/20 text-mint flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            </div>
            <span class="text-xs font-bold text-cream/80 group-hover:text-cream">Create Club</span>
        </a>
        <a href="{{ route('admin.courses.create') }}" class="p-4 rounded-xl bg-white/[0.02] border border-white/5 hover:border-mint/40 hover:bg-mint/[0.03] transition-all text-center group">
            <div class="w-10 h-10 rounded-xl bg-gold/10 border border-gold/20 text-gold flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253"/></svg>
            </div>
            <span class="text-xs font-bold text-cream/80 group-hover:text-cream">Create Course</span>
        </a>
        <a href="{{ route('admin.upcoming.index') }}" class="p-4 rounded-xl bg-white/[0.02] border border-white/5 hover:border-mint/40 hover:bg-mint/[0.03] transition-all text-center group">
            <div class="w-10 h-10 rounded-xl bg-sky/10 border border-sky/20 text-sky flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/></svg>
            </div>
            <span class="text-xs font-bold text-cream/80 group-hover:text-cream">Schedule Class</span>
        </a>
        <a href="{{ route('admin.schools.index') }}" class="p-4 rounded-xl bg-white/[0.02] border border-white/5 hover:border-mint/40 hover:bg-mint/[0.03] transition-all text-center group">
            <div class="w-10 h-10 rounded-xl bg-violet/10 border border-violet/20 text-violet flex items-center justify-center mx-auto mb-3 group-hover:scale-110 transition-transform">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 21V5a2 2 0 00-2-2H7a2 2 0 00-2 2v16m14 0h2m-2 0h-5m-9 0H3m2 0h5M9 7h1m-1 4h1m4-4h1m-1 4h1m-5 10v-5a1 1 0 011-1h2a1 1 0 011 1v5m-4 0h4"/></svg>
            </div>
            <span class="text-xs font-bold text-cream/80 group-hover:text-cream">School Licenses</span>
        </a>
    </div>
</div>

@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js@4.4.0/dist/chart.umd.min.js"></script>
<script>
const ctx = document.getElementById('revenueChart').getContext('2d');
const gradient = ctx.createLinearGradient(0, 0, 0, 250);
gradient.addColorStop(0, 'rgba(78, 153, 102, 0.3)');
gradient.addColorStop(1, 'rgba(78, 153, 102, 0.0)');

new Chart(ctx, {
    type: 'line',
    data: {
        labels: {!! json_encode(array_column($monthlyRevenue, 'month')) !!},
        datasets: [{
            label: 'Revenue (NGN)',
            data: {!! json_encode(array_column($monthlyRevenue, 'amount')) !!},
            borderColor: '#4E9966',
            backgroundColor: gradient,
            fill: true,
            tension: 0.35,
            pointBackgroundColor: '#4E9966',
            pointBorderColor: '#0F1612',
            pointBorderWidth: 3,
            pointRadius: 5,
            pointHoverRadius: 7,
        }]
    },
    options: {
        responsive: true,
        maintainAspectRatio: false,
        plugins: { 
            legend: { display: false },
            tooltip: {
                backgroundColor: '#141A16',
                titleColor: '#FAF5E8',
                bodyColor: '#4E9966',
                borderColor: 'rgba(250,245,232,0.1)',
                borderWidth: 1,
                padding: 12,
                displayColors: false,
                callbacks: {
                    label: function(context) {
                        return '₦' + context.parsed.y.toLocaleString();
                    }
                }
            }
        },
        scales: {
            x: { 
                ticks: { color: 'rgba(250,245,232,0.5)', font: { size: 11, family: 'Outfit' } }, 
                grid: { color: 'rgba(250,245,232,0.03)' } 
            },
            y: { 
                ticks: { 
                    color: 'rgba(250,245,232,0.5)', 
                    font: { size: 11, family: 'Outfit' }, 
                    callback: v => '₦' + (v >= 1000 ? (v/1000).toFixed(0) + 'k' : v)
                }, 
                grid: { color: 'rgba(250,245,232,0.05)' } 
            }
        }
    }
});
</script>
@endpush
