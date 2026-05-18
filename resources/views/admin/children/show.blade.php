@extends('layouts.admin')
@section('title', $child->name)
@section('content')

<div class="mb-8">
    <a href="{{ route('admin.children.index') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-4 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Children
    </a>
    <div class="flex items-center gap-4">
        @php $rankColors = ['Explorer'=>'#4E9966','Innovator'=>'#D4A224','Builder'=>'#C24B1E','Creator'=>'#6B3FA0','Master Inventor'=>'#2E8BC0']; $color = $rankColors[$child->rank] ?? '#4E9966'; @endphp
        <div class="w-16 h-16 rounded-2xl flex items-center justify-center font-display font-black text-3xl flex-shrink-0"
             style="background:{{ $color }}15; border:2px solid {{ $color }}35; color:{{ $color }}">
            {{ strtoupper(substr($child->name, 0, 1)) }}
        </div>
        <div>
            <h1 class="font-display text-3xl font-bold">{{ $child->name }}</h1>
            <p class="text-cream/50 text-sm">{{ $child->rank }} &bull; {{ number_format($child->xp) }} XP &bull; Parent: {{ $child->parent->name ?? 'Unknown' }}</p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">

    {{-- Award XP --}}
    <div class="card p-6">
        <h2 class="font-display text-lg font-bold mb-4">Award XP</h2>
        <form method="POST" action="{{ route('admin.children.award-xp', $child) }}" class="space-y-4">
            @csrf
            <div>
                <label class="label">Activity</label>
                <select name="activity" class="input appearance-none">
                    <option>Attend Session</option>
                    <option>Complete Challenge</option>
                    <option>Teamwork</option>
                    <option>Project Presentation</option>
                    <option>Custom</option>
                </select>
            </div>
            <div>
                <label class="label">XP Amount</label>
                <input type="number" name="amount" value="10" min="1" max="500" class="input">
            </div>
            <button type="submit" class="btn-primary w-full justify-center">Award XP</button>
        </form>
    </div>

    {{-- Enrollments --}}
    <div class="card p-6">
        <h2 class="font-display text-lg font-bold mb-4">Enrolled Courses</h2>
        @forelse($child->enrollments as $e)
        <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
            <div>
                <div class="font-semibold text-sm">{{ $e->course->title ?? 'N/A' }}</div>
                <div class="text-cream/40 text-xs">{{ $e->course->club->name ?? '' }}</div>
            </div>
            <span class="badge {{ $e->status === 'active' ? 'badge-green' : 'badge-gray' }}">{{ $e->status }}</span>
        </div>
        @empty
        <p class="text-cream/30 text-sm text-center py-6">No enrollments yet.</p>
        @endforelse
    </div>

    {{-- Recent XP Logs --}}
    <div class="card p-6">
        <h2 class="font-display text-lg font-bold mb-4">XP History</h2>
        @forelse($child->xpLogs as $log)
        <div class="flex items-center justify-between py-2 border-b border-white/5 last:border-0">
            <div>
                <div class="font-medium text-sm">{{ $log->activity }}</div>
                <div class="text-cream/40 text-xs">{{ $log->created_at->diffForHumans() }}</div>
            </div>
            <span class="font-display font-bold text-sm text-gold">+{{ $log->amount }}</span>
        </div>
        @empty
        <p class="text-cream/30 text-sm text-center py-6">No XP logged yet.</p>
        @endforelse
    </div>

</div>
@endsection
