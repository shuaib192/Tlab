@extends('layouts.app')
@section('title', 'Notifications')

@section('content')
<div class="max-w-3xl mx-auto px-4 sm:px-6 py-8 sm:py-12">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl flex items-center justify-center" style="background:#F0FDF4">
                <svg class="w-5 h-5 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h1 class="font-black text-2xl text-ink">Notifications</h1>
            @if($unreadCount > 0)
                <span class="text-xs font-bold bg-primary/10 text-primary px-3 py-1.5 rounded-full">{{ $unreadCount }} unread</span>
            @endif
        </div>
        @if($unreadCount > 0)
            <form method="POST" action="{{ route('notifications.read-all') }}">
                @csrf
                <button class="text-sm font-bold text-primary hover:text-primary/80 transition-colors">Mark all as read</button>
            </form>
        @endif
    </div>

    @if($notifications->isEmpty())
        <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
            <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
                <svg class="w-8 h-8 text-muted" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9"/></svg>
            </div>
            <h2 class="font-black text-xl text-ink mb-2">All Clear!</h2>
            <p class="text-muted text-sm">No notifications yet. You'll see updates here when something happens.</p>
        </div>
    @else
        <div class="space-y-2">
            @foreach($notifications as $notification)
            <div class="flex items-start gap-4 p-5 rounded-2xl transition-colors {{ $notification->is_read ? 'bg-white' : 'bg-primary/5 border border-primary/10' }} hover:bg-gray-50"
                 x-data>
                <div class="w-10 h-10 rounded-xl flex items-center justify-center text-lg flex-shrink-0" style="background:#F0FDF4">
                    {{ $notification->icon ?? '🔔' }}
                </div>
                <div class="flex-1 min-w-0">
                    <div class="font-bold text-sm text-ink">{{ $notification->title }}</div>
                    <div class="text-xs text-muted mt-0.5">{{ $notification->body }}</div>
                    <div class="text-[10px] text-muted/50 mt-1.5">{{ $notification->created_at->diffForHumans() }}</div>
                </div>
                <div class="flex flex-col items-end gap-2 flex-shrink-0">
                    @if(!$notification->is_read)
                    <form method="POST" action="{{ route('notifications.read', $notification) }}">
                        @csrf
                        <button class="text-[10px] font-bold text-primary hover:text-primary/80">Mark read</button>
                    </form>
                    @endif
                    @if($notification->link)
                    <a href="{{ $notification->link }}" class="text-[10px] font-bold text-accent hover:text-accent/80">View →</a>
                    @endif
                </div>
            </div>
            @endforeach
        </div>
        <div class="mt-6">{{ $notifications->links() }}</div>
    @endif
</div>
@endsection
