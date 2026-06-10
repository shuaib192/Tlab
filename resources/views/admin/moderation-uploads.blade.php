@extends('layouts.admin')
@section('title', 'Moderated Uploads')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Moderated Uploads</h1>
        <p class="text-cream/50 text-sm">Review and approve child uploads.</p>
    </div>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">File</th>
                    <th class="text-left px-5 py-3">Child</th>
                    <th class="text-left px-5 py-3">Type</th>
                    <th class="text-left px-5 py-3">Size</th>
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Moderator</th>
                    <th class="text-left px-5 py-3">Reason</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($uploads as $upload)
                <tr class="table-row">
                    <td class="px-5 py-3">
                        <a href="{{ $upload->file_url }}" target="_blank" class="text-mint hover:underline font-medium">{{ $upload->file_name }}</a>
                    </td>
                    <td class="px-5 py-3">{{ $upload->child?->name ?? 'N/A' }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ $upload->file_type ?? '—' }}</td>
                    <td class="px-5 py-3 text-cream/60">{{ $upload->file_size ? number_format($upload->file_size / 1024, 1) . ' KB' : '—' }}</td>
                    <td class="px-5 py-3">
                        <span class="badge {{ $upload->status === 'approved' ? 'badge-green' : ($upload->status === 'rejected' ? 'badge-red' : 'badge-gold') }}">
                            {{ $upload->status }}
                        </span>
                    </td>
                    <td class="px-5 py-3 text-cream/60">{{ $upload->moderator?->name ?? '—' }}</td>
                    <td class="px-5 py-3 text-cream/60 max-w-xs truncate">{{ $upload->reason ?? '—' }}</td>
                    <td class="px-5 py-3 text-right">
                        @if($upload->status === 'pending')
                        <div class="flex items-center justify-end gap-2">
                            <form method="POST" action="{{ route('admin.safety.uploads.approve', $upload) }}">
                                @csrf
                                <button class="btn-primary btn-sm text-xs">Approve</button>
                            </form>
                            <form method="POST" action="{{ route('admin.safety.uploads.reject', $upload) }}" onsubmit="return confirm('Reject this upload?')">
                                @csrf
                                <input type="text" name="reason" class="input text-xs py-1 px-2 w-24" placeholder="Reason">
                                <button class="btn-danger btn-sm text-xs mt-1">Reject</button>
                            </form>
                        </div>
                        @else
                        <span class="text-cream/40 text-xs">—</span>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="px-5 py-12 text-center text-cream/40">No uploads found.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>

<div class="mt-6">{{ $uploads->links() }}</div>
@endsection
