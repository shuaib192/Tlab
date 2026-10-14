@extends('layouts.admin')
@section('title', 'Enquiries')

@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Website Enquiries</h1>
        <p class="text-cream/50 text-sm">Messages sent through the public contact form.</p>
    </div>
    <span class="text-xs font-bold text-cream/40">{{ $messages->total() }} total</span>
</div>

<div class="card p-4 mb-6">
    <form method="GET" class="flex flex-col sm:flex-row gap-3">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="Search name, email, subject or message..." class="form-input flex-1">
        <select name="filter" class="form-input">
            <option value="">All messages</option>
            <option value="unread" @selected(request('filter') === 'unread')>Unread only</option>
        </select>
        <button type="submit" class="btn-primary">Filter</button>
        @if(request()->hasAny(['search', 'filter']))
            <a href="{{ route('admin.contact-messages.index') }}" class="btn-secondary">Clear</a>
        @endif
    </form>
</div>

<div class="card overflow-hidden">
    @forelse($messages as $message)
        <a href="{{ route('admin.contact-messages.show', $message) }}"
           class="flex items-start gap-4 p-5 border-b border-cream/10 last:border-0 hover:bg-cream/5 transition-colors">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center flex-shrink-0 font-black"
                 style="background:rgba(13,170,156,0.12);color:#0A7A6E;">
                {{ strtoupper(substr($message->name, 0, 1)) }}
            </div>
            <div class="flex-1 min-w-0">
                <div class="flex items-center gap-2 flex-wrap">
                    <span class="font-bold {{ $message->is_read ? 'text-cream/60' : 'text-cream' }}">{{ $message->name }}</span>
                    <span class="text-xs text-cream/40">{{ $message->email }}</span>
                    @unless($message->is_read)
                        <span class="badge badge-green">New</span>
                    @endunless
                </div>
                <div class="font-semibold text-sm mt-0.5 {{ $message->is_read ? 'text-cream/60' : 'text-cream' }}">{{ $message->subject }}</div>
                <div class="text-xs text-cream/40 mt-1 truncate">{{ \Str::limit($message->message, 120) }}</div>
            </div>
            <div class="text-xs text-cream/40 font-semibold flex-shrink-0">{{ $message->created_at->diffForHumans() }}</div>
        </a>
    @empty
        <div class="p-12 text-center">
            <p class="text-cream/50 font-semibold">No enquiries yet.</p>
            <p class="text-cream/30 text-sm mt-1">Messages from the contact form will appear here.</p>
        </div>
    @endforelse
</div>

@if($messages->hasPages())
    <div class="mt-6">{{ $messages->links() }}</div>
@endif

@endsection