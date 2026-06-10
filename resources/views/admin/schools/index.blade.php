@extends('layouts.admin')
@section('title', 'Schools')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Schools</h1>
        <p class="text-cream/50 text-sm">B2B school management.</p>
    </div>
    <a href="{{ route('admin.schools.create') }}" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        Add School
    </a>
</div>

<div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-4">
    @forelse($schools as $school)
    <a href="{{ route('admin.schools.show', $school) }}" class="card p-5 block hover:border-mint/30 transition-all group">
        <div class="flex items-start justify-between mb-4">
            <div class="w-10 h-10 rounded-xl bg-mint/10 border border-mint/20 flex items-center justify-center text-sm font-bold text-mint flex-shrink-0">
                {{ strtoupper(substr($school->name, 0, 1)) }}
            </div>
            <span class="badge {{ $school->status === 'active' ? 'badge-green' : 'badge-red' }}">{{ $school->status }}</span>
        </div>
        <h3 class="font-bold text-base group-hover:text-mint transition-colors mb-1">{{ $school->name }}</h3>
        <p class="text-cream/50 text-xs mb-3">{{ $school->city ?? '—' }}, {{ $school->state ?? '—' }}</p>
        <div class="flex items-center gap-3 text-xs text-cream/50">
            <span>{{ $school->licenses_count }} {{ Str::plural('license', $school->licenses_count) }}</span>
            <span>&middot;</span>
            <span class="capitalize">{{ $school->subscription_tier }}</span>
        </div>
    </a>
    @empty
    <div class="card p-12 text-center text-cream/40 col-span-full">
        <p>No schools registered yet.</p>
    </div>
    @endforelse
</div>

<div class="mt-6">{{ $schools->links() }}</div>
@endsection
