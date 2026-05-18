@extends('layouts.admin')
@section('title', 'Users')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Users</h1>
        <p class="text-cream/50 text-sm">All registered parents and staff accounts.</p>
    </div>
</div>

{{-- Filters --}}
<form method="GET" class="flex flex-col sm:flex-row gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}"
           class="input flex-1 max-w-xs" placeholder="Search name or email...">
    <select name="role" class="input w-auto appearance-none">
        <option value="">All Roles</option>
        <option value="parent"       {{ request('role') === 'parent'       ? 'selected' : '' }}>Parent</option>
        <option value="teacher"      {{ request('role') === 'teacher'      ? 'selected' : '' }}>Teacher</option>
        <option value="school_admin" {{ request('role') === 'school_admin' ? 'selected' : '' }}>School Admin</option>
        <option value="super_admin"  {{ request('role') === 'super_admin'  ? 'selected' : '' }}>Super Admin</option>
    </select>
    <button type="submit" class="btn-primary">Filter</button>
    @if(request()->hasAny(['search','role']))
    <a href="{{ route('admin.users.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">User</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden sm:table-cell">Role</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden md:table-cell">Children</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">Joined</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($users as $user)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl bg-mint/10 border border-mint/20 flex items-center justify-center text-xs font-bold text-mint flex-shrink-0">
                                {{ strtoupper(substr($user->name, 0, 1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-sm">{{ $user->name }}</div>
                                <div class="text-cream/40 text-xs">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell">
                        <span class="badge {{ $user->role === 'super_admin' ? 'badge-gold' : ($user->role === 'parent' ? 'badge-green' : 'badge-gray') }}">
                            {{ str_replace('_', ' ', $user->role) }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="font-bold text-sm text-cream/70">{{ $user->children_count }}</span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell text-cream/50 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.users.edit', $user) }}" class="btn-secondary text-xs px-3 py-2">Edit</a>
                            @if($user->id !== auth()->id())
                            <form method="POST" action="{{ route('admin.users.destroy', $user) }}"
                                  onsubmit="return confirm('Remove user {{ addslashes($user->name) }}?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger text-xs">Remove</button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-6 py-12 text-center text-cream/30 text-sm">No users found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($users->hasPages())
    <div class="px-6 py-4 border-t border-white/5">{{ $users->links() }}</div>
    @endif
</div>
@endsection
