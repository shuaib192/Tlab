@extends('layouts.admin')
@section('title', 'Staff — Admin Management')
@section('content')

<div class="mb-8">
    <h1 class="font-display text-3xl font-bold mb-1">Staff Management</h1>
    <p class="text-cream/50 text-sm">Super Admin — manage the admin team. Promote trusted users to Admin or Super Admin, or remove them.</p>
</div>

<form method="GET" class="flex gap-3 mb-6">
    <input type="text" name="search" value="{{ request('search') }}" class="input flex-1 max-w-xs" placeholder="Search staff...">
    <button type="submit" class="btn-primary">Search</button>
    @if(request('search'))<a href="{{ route('admin.staff.index') }}" class="btn-secondary">Clear</a>@endif
</form>

<div class="card overflow-hidden">
    <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
        <h2 class="font-display font-bold">Management Team</h2>
        <span class="badge badge-gold">{{ $staff->count() }} members</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Member</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Role</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40 hidden lg:table-cell">Joined</th>
                    <th class="text-right px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($staff as $user)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <div class="flex items-center gap-3">
                            <div class="w-9 h-9 rounded-xl flex items-center justify-center text-xs font-bold flex-shrink-0" style="background:rgba(212,162,36,0.12);border:1px solid rgba(212,162,36,0.25);color:#D4A224">
                                {{ strtoupper(substr($user->name,0,1)) }}
                            </div>
                            <div>
                                <div class="font-semibold text-sm">{{ $user->name }}</div>
                                <div class="text-cream/40 text-xs">{{ $user->email }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="badge {{ $user->role === 'super_admin' ? 'badge-gold' : 'badge-green' }}">{{ str_replace('_',' ', $user->role) }}</span>
                    </td>
                    <td class="px-6 py-4 hidden lg:table-cell text-cream/50 text-sm">{{ $user->created_at->format('d M Y') }}</td>
                    <td class="px-6 py-4">
                        @if(auth()->user()->isSuperAdmin())
                        <div class="flex items-center justify-end gap-2">
                            @if($user->id !== auth()->id())
                                @if($user->role === 'admin')
                                <form method="POST" action="{{ route('admin.staff.promote', $user) }}">
                                    @csrf
                                    <input type="hidden" name="super" value="1">
                                    <button class="btn-secondary text-xs px-3 py-2">Make Super Admin</button>
                                </form>
                                <form method="POST" action="{{ route('admin.staff.demote', $user) }}" onsubmit="return confirm('Remove {{ addslashes($user->name) }} from admin team?')">
                                    @csrf
                                    <button class="btn-danger text-xs">Remove</button>
                                </form>
                                @else
                                <form method="POST" action="{{ route('admin.staff.promote', $user) }}">
                                    @csrf
                                    <button class="btn-secondary text-xs px-3 py-2">Make Admin</button>
                                </form>
                                <form method="POST" action="{{ route('admin.staff.demote', $user) }}" onsubmit="return confirm('Remove {{ addslashes($user->name) }} from admin team?')">
                                    @csrf
                                    <button class="btn-danger text-xs">Remove</button>
                                </form>
                                @endif
                            @else
                                <span class="text-cream/30 text-xs">You</span>
                            @endif
                        </div>
                        @else
                        <span class="text-cream/30 text-xs">Super Admin only</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-cream/30 text-sm">No admin staff yet. Promote a user from the Users page or here.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="card p-6 mt-6">
    <h3 class="font-bold mb-2">How to add a new Admin</h3>
    <p class="text-cream/50 text-sm mb-3">Go to <a href="{{ route('admin.users.index') }}" class="text-mint hover:underline font-bold">Users</a> → Edit any user → change Role to <code class="text-gold">admin</code> or <code class="text-gold">super_admin</code>. They will appear here instantly.</p>
    <p class="text-cream/30 text-xs">Admin = can manage Clubs, Courses, Curriculum, Enrollments, Upcoming Classes, Carousel. Super Admin = full access including Staff, Settings, Safety, Invoices, Schools.</p>
</div>

@endsection
