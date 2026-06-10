@extends('layouts.admin')
@section('title', 'Feature Flags')
@section('content')
<div class="mb-8 flex items-center justify-between">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Feature Flags</h1>
        <p class="text-cream/50 text-sm">Manage feature toggles across the platform.</p>
    </div>
    <button onclick="document.getElementById('createForm').classList.toggle('hidden')" class="btn-primary">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Flag
    </button>
</div>

<form id="createForm" method="POST" action="{{ route('admin.feature-flags.index') }}" class="hidden card p-6 mb-8">
    @csrf
    <div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-4">
        <div>
            <label class="label">Key</label>
            <input type="text" name="key" class="input" placeholder="e.g. new_dashboard" required>
        </div>
        <div>
            <label class="label">Name</label>
            <input type="text" name="name" class="input" placeholder="e.g. New Dashboard Design" required>
        </div>
        <div class="md:col-span-2">
            <label class="label">Description</label>
            <textarea name="description" class="input" rows="2" placeholder="Optional description"></textarea>
        </div>
        <div class="flex items-center gap-6">
            <label class="flex items-center gap-2">
                <input type="checkbox" name="is_active" value="1" class="rounded bg-surface border-white/10">
                <span class="text-sm font-semibold text-cream/70">Active</span>
            </label>
            <label class="flex items-center gap-2">
                <input type="checkbox" name="staging_only" value="1" class="rounded bg-surface border-white/10">
                <span class="text-sm font-semibold text-cream/70">Staging Only</span>
            </label>
        </div>
    </div>
    <button type="submit" class="btn-primary">Create Flag</button>
</form>

<div class="card overflow-hidden">
    <table class="w-full text-sm">
        <thead>
            <tr class="border-b border-white/5 text-left text-xs text-cream/50 font-bold uppercase tracking-wider">
                <th class="p-4">Key</th>
                <th class="p-4">Name</th>
                <th class="p-4">Active</th>
                <th class="p-4">Staging Only</th>
                <th class="p-4">Roles</th>
                <th class="p-4">Users</th>
                <th class="p-4">Actions</th>
            </tr>
        </thead>
        <tbody>
            @forelse($flags as $flag)
            <tr class="table-row">
                <td class="p-4 font-mono text-xs">{{ $flag->key }}</td>
                <td class="p-4 font-semibold">{{ $flag->name }}</td>
                <td class="p-4">
                    <span class="badge {{ $flag->is_active ? 'badge-green' : 'badge-gray' }}">
                        {{ $flag->is_active ? 'ON' : 'OFF' }}
                    </span>
                </td>
                <td class="p-4">
                    @if($flag->staging_only)
                        <span class="badge badge-gold">STAGING</span>
                    @else
                        <span class="badge badge-gray">ALL</span>
                    @endif
                </td>
                <td class="p-4 text-cream/60 text-xs">
                    {{ $flag->enabled_for_roles ? implode(', ', $flag->enabled_for_roles) : '—' }}
                </td>
                <td class="p-4 text-cream/60 text-xs">
                    {{ $flag->enabled_for_users ? count($flag->enabled_for_users) . ' user(s)' : '—' }}
                </td>
                <td class="p-4">
                    <div class="flex items-center gap-2">
                        <form method="POST" action="{{ route('admin.feature-flags.toggle', $flag) }}">
                            @csrf
                            <button type="submit" class="btn-secondary text-xs px-3 py-1.5">
                                {{ $flag->is_active ? 'Deactivate' : 'Activate' }}
                            </button>
                        </form>
                        <form method="POST" action="{{ route('admin.feature-flags.update', $flag) }}">
                            @csrf
                            @method('PUT')
                            <div class="flex items-center gap-1 text-xs">
                                <label class="flex items-center gap-1 cursor-pointer">
                                    <input type="checkbox" name="staging_only" value="1" {{ $flag->staging_only ? 'checked' : '' }} onchange="this.form.submit()" class="rounded bg-surface border-white/10">
                                    <span class="text-cream/50">Staging</span>
                                </label>
                            </div>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr><td colspan="7" class="p-8 text-center text-cream/30">No feature flags defined.</td></tr>
            @endforelse
        </tbody>
    </table>
</div>
@endsection
