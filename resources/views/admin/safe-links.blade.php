@extends('layouts.admin')
@section('title', 'Safe Links')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Safe Links</h1>
        <p class="text-cream/50 text-sm">Manage allowed domains for child-safe browsing.</p>
    </div>
</div>

<div class="card p-6 mb-6">
    <h2 class="font-display font-bold text-lg mb-4">Add New Domain</h2>
    <form method="POST" action="{{ route('admin.safety.safe-links.store') }}" class="grid grid-cols-1 md:grid-cols-4 gap-4">
        @csrf
        <div>
            <label class="label">Domain</label>
            <input type="text" name="domain" class="input" placeholder="example.com" required>
        </div>
        <div>
            <label class="label">Category</label>
            <input type="text" name="category" class="input" placeholder="educational">
        </div>
        <div>
            <label class="label">Allowed</label>
            <select name="is_allowed" class="input">
                <option value="1">Yes</option>
                <option value="0">No</option>
            </select>
        </div>
        <div class="flex items-end">
            <button type="submit" class="btn-primary w-full">Add</button>
        </div>
        <div class="md:col-span-4">
            <label class="label">Description</label>
            <input type="text" name="description" class="input" placeholder="Brief description of the domain">
        </div>
    </form>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Domain</th>
                    <th class="text-left px-5 py-3">Category</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Description</th>
                    <th class="text-right px-5 py-3">Action</th>
                </tr>
            </thead>
            <tbody>
                @forelse($links as $link)
                <tr class="table-row">
                    <td class="px-5 py-3 font-medium">{{ $link->domain }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ $link->category ?? '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="badge {{ $link->is_allowed ? 'badge-green' : 'badge-red' }}">
                            {{ $link->is_allowed ? 'Allowed' : 'Blocked' }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-cream/60 max-w-xs truncate">{{ $link->description ?? '—' }}</td>
                    <td class="px-5 py-3 text-right">
                        <form method="POST" action="{{ route('admin.safety.safe-links.destroy', $link) }}" onsubmit="return confirm('Remove this domain?')">
                            @csrf @method('DELETE')
                            <button class="btn-danger text-xs">Delete</button>
                        </form>
                    </td>
                </tr>
                @empty
                <tr><td colspan="5" class="px-5 py-12 text-center text-cream/40">No safe links added yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $links->links() }}</div>
@endsection
