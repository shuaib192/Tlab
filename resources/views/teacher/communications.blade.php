@extends('layouts.teacher')
@section('title', 'Communications')

@section('content')
<div class="flex items-center justify-between mb-6">
    <div>
        <h1 class="font-display text-2xl font-bold">Communications</h1>
        <p class="text-cream/50 text-sm mt-1">Messages sent to parents.</p>
    </div>
</div>

{{-- Send New Message --}}
<div class="card p-6 mb-8">
    <h2 class="font-display font-bold text-lg mb-4">Send Message to Parent</h2>
    <form method="POST" action="{{ route('teacher.communications.send') }}" class="grid grid-cols-1 gap-4">
        @csrf
        <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
            <div>
                <label class="label">Child</label>
                <select name="child_profile_id" class="input" required>
                    <option value="">Select child...</option>
                    @foreach(\App\Models\ChildProfile::whereHas('enrollments.course', fn($q) => $q->where('teacher_id', auth()->id()))->orderBy('name')->get() as $child)
                    <option value="{{ $child->id }}">{{ $child->name }} ({{ $child->parent?->name ?? 'No parent' }})</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="label">Type</label>
                <select name="type" class="input" required>
                    <option value="general">General</option>
                    <option value="feedback">Feedback</option>
                    <option value="concern">Concern</option>
                </select>
            </div>
            <div>
                <label class="label">Subject</label>
                <input type="text" name="subject" class="input" placeholder="Message subject" required>
            </div>
        </div>
        <div>
            <label class="label">Message</label>
            <textarea name="message" rows="4" class="input" placeholder="Write your message to the parent..." required></textarea>
        </div>
        <div class="flex justify-end">
            <button type="submit" class="btn-primary">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-7 7m7-7l7 7"/></svg>
                Send Message
            </button>
        </div>
    </form>
</div>

{{-- Message History --}}
<div class="card overflow-hidden">
    <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
        <h2 class="font-display font-bold text-lg">Message History</h2>
        <span class="badge badge-gray">{{ $logs->total() }} total</span>
    </div>
    @if($logs->isEmpty())
    <div class="p-12 text-center text-cream/40">
        <p>No messages sent yet.</p>
    </div>
    @else
    <div class="divide-y divide-white/5">
        @foreach($logs as $log)
        <div class="px-6 py-4 hover:bg-white/5 transition-colors {{ !$log->is_read ? 'bg-mint/5' : '' }}">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        @if(!$log->is_read)
                        <span class="w-2 h-2 rounded-full bg-mint flex-shrink-0"></span>
                        @endif
                        <h3 class="font-bold text-sm {{ !$log->is_read ? 'text-cream' : 'text-cream/70' }}">{{ $log->subject }}</h3>
                        <span class="badge {{ $log->type === 'concern' ? 'badge-red' : ($log->type === 'feedback' ? 'badge-gold' : 'badge-gray') }} text-xs">
                            {{ $log->type }}
                        </span>
                    </div>
                    <p class="text-sm text-cream/50 mb-2 line-clamp-2">{{ $log->message }}</p>
                    <div class="flex items-center gap-3 text-xs text-cream/40">
                        <span class="font-semibold">To: {{ $log->parent?->name ?? 'Parent' }}</span>
                        <span>&middot;</span>
                        <span>Child: {{ $log->child?->name ?? 'N/A' }}</span>
                        <span>&middot;</span>
                        <span>{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                <span class="badge {{ $log->is_read ? 'badge-gray' : 'badge-green' }} flex-shrink-0">
                    {{ $log->is_read ? 'Read' : 'Unread' }}
                </span>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>

@if($logs->hasPages())
<div class="mt-6">{{ $logs->links() }}</div>
@endif
@endsection
