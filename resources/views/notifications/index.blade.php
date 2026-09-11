@extends('layouts.parent')
@section('title', 'Notifications')

@section('parent-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
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
            @php
                $typeIcons = [
                    'enrollment'  => ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', '#16A34A'],
                    'payment'     => ['M3 10h18M7 15h2m3 0h2m3-1a9 9 0 11-18 0 9 9 0 0118 0z', '#2563EB'],
                    'achievement' => ['M8 21h8m-5-4v-4M6 21h12a2 2 0 002-2V9a2 2 0 00-2-2h-5V5a2 2 0 00-4 0v2H6a2 2 0 00-2 2v10a2 2 0 002 2z', '#D97706'],
                    'session'     => ['M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z', '#7C3AED'],
                    'grade'       => ['M11.049 2.927c.3-.921 1.603-.921 1.902 0l1.519 4.674a1 1 0 00.95.69h4.915c.969 0 1.371 1.24.588 1.81l-3.976 2.888a1 1 0 00-.363 1.118l1.518 4.674c.3.922-.755 1.688-1.538 1.118l-3.976-2.888a1 1 0 00-1.176 0l-3.976 2.888c-.783.57-1.838-.196-1.538-1.118l1.518-4.674a1 1 0 00-.363-1.118L2.983 10.1c-.783-.57-.38-1.81.588-1.81h4.914a1 1 0 00.951-.69l1.519-4.674z', '#2563EB'],
                    'approval'    => ['M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z', '#16A34A'],
                    'safety'      => ['M12 22s8-4 8-10V5l-8-3-8 3v7c0 6 8 10 8 10z', '#EA580C'],
                    'certificate' => ['M12 15a7 7 0 100-14 7 7 0 000 14zm3.5-3.5L15 17l-3 2-3-2-0.5-5.5', '#16A34A'],
                    'default'     => ['M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9', '#16A34A'],
                ];
            @endphp
            @foreach($notifications as $notification)
            <div class="flex items-start gap-4 p-5 rounded-2xl border-2 transition-colors {{ $notification->is_read ? 'bg-white' : 'bg-primary/5 border-[#16A34A]/30' }} hover:bg-gray-50"
                 x-data>
                @php $n = $typeIcons[$notification->type] ?? $typeIcons['default']; @endphp
                <div class="w-10 h-10 rounded-xl grid place-items-center flex-shrink-0" style="background:{{ $n[1] }}15; color:{{ $n[1] }}">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="{{ $n[0] }}"/></svg>
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
