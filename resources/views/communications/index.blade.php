@extends(auth()->user()->isTeacher() ? 'layouts.teacher' : 'layouts.parent')

@section('title', 'Communications')

@section(auth()->user()->isTeacher() ? 'content' : 'parent-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">

    {{-- Header --}}
    <div class="flex items-center justify-between mb-8">
        <div>
            <h1 class="font-black text-2xl sm:text-3xl text-ink">Communications</h1>
            <p class="text-muted font-semibold text-sm mt-1">Messages between teachers and parents</p>
        </div>
        <span class="text-xs font-bold bg-gray-100 text-muted px-3 py-1.5 rounded-full">{{ $logs->total() }} total</span>
    </div>

    {{-- List --}}
    @if($logs->isEmpty())
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-12 text-center">
        <div class="w-16 h-16 rounded-2xl bg-gray-100 flex items-center justify-center mx-auto mb-4">
            <svg class="w-7 h-7 text-muted/50" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 10h.01M12 10h.01M16 10h.01M9 16H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-5l-5 5v-5z"/></svg>
        </div>
        <h2 class="font-black text-lg text-ink mb-2">No Messages Yet</h2>
        <p class="text-muted text-sm">Messages from your child's teachers will appear here.</p>
    </div>
    @else
    <div class="space-y-3">
        @foreach($logs as $log)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-5 hover:shadow-lg transition-all {{ !$log->is_read ? 'border-l-4 border-l-primary' : '' }}">
            <div class="flex items-start justify-between gap-4">
                <div class="flex-1 min-w-0">
                    <div class="flex items-center gap-2 mb-1">
                        @if(!$log->is_read)
                        <span class="w-2 h-2 rounded-full bg-primary flex-shrink-0"></span>
                        @endif
                        <h3 class="font-bold text-ink {{ !$log->is_read ? 'text-base' : 'text-sm' }}">{{ $log->subject }}</h3>
                        <span class="badge badge-sm {{ $log->type === 'concern' ? 'badge-red' : ($log->type === 'feedback' ? 'badge-gold' : 'badge-gray') }} text-xs px-2 py-0.5 rounded-full font-bold"
                              style="background:{{ $log->type === 'concern' ? '#FEF2F2' : ($log->type === 'feedback' ? '#FFFBEB' : '#F9FAFB') }};color:{{ $log->type === 'concern' ? '#DC2626' : ($log->type === 'feedback' ? '#D97706' : '#64748B') }};border:1px solid {{ $log->type === 'concern' ? '#FCA5A5' : ($log->type === 'feedback' ? '#FCD34D' : '#E5E7EB') }}">
                            {{ ucfirst($log->type) }}
                        </span>
                    </div>
                    <p class="text-muted text-sm mb-3 line-clamp-2">{{ $log->message }}</p>
                    <div class="flex items-center gap-3 text-xs text-muted">
                        @if(auth()->user()->isTeacher())
                        <span class="font-semibold">To: {{ $log->parent?->name ?? 'Parent' }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>Child: {{ $log->child?->name ?? 'N/A' }}</span>
                        @else
                        <span class="font-semibold">From: {{ $log->teacher?->name ?? 'Teacher' }}</span>
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>Child: {{ $log->child?->name ?? 'N/A' }}</span>
                        @endif
                        <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                        <span>{{ $log->created_at->diffForHumans() }}</span>
                    </div>
                </div>
                @if(!$log->is_read)
                <button onclick="markRead({{ $log->id }})" class="flex-shrink-0 px-3 py-1.5 rounded-lg bg-primary/10 text-primary text-xs font-bold hover:bg-primary/20 transition-all">
                    Mark Read
                </button>
                @endif
            </div>
        </div>
        @endforeach
    </div>

    <div class="mt-6">
        {{ $logs->links() }}
    </div>
    @endif
</div>

<script>
function markRead(id) {
    fetch('/communications/' + id + '/read', { method: 'POST', headers: { 'X-CSRF-TOKEN': '{{ csrf_token() }}' } })
        .then(r => r.json())
        .then(d => { if(d.ok) location.reload(); });
}
</script>
@endSection
