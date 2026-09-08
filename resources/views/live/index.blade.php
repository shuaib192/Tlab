@extends('layouts.admin')
@section('title', 'Live Sessions — Control Tower')
@section('content')

@php
    $counts = [
        'total' => $sessions->count(),
        'live' => $sessions->where('status', 'live')->count(),
        'scheduled' => $sessions->where('status', 'scheduled')->count(),
        'ended' => $sessions->where('status', 'ended')->count(),
    ];
    $baseDomain = $jitsi->domain();
@endphp

<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8 border-b border-white/10 pb-6">
    <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-red-500/10 border border-red-500/30 text-red-400 text-xs font-mono font-bold uppercase tracking-widest mb-3">
            <span class="w-2 h-2 rounded-full bg-red-500 animate-pulse"></span>
            // LIVE PRODUCTION TOWER //
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-cream tracking-tight">
            Live Sessions
        </h1>
        <p class="text-cream/50 text-sm mt-1 max-w-2xl font-mono">
            Broadcast conduit. Rooms run on <span class="text-sky">{{ $baseDomain }}</span> — attendees are granted
            access via private room tokens. Lobby is enforced so the teacher admits each student.
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('admin.live.create') }}" class="btn-primary text-xs uppercase tracking-wider font-mono shadow-[4px_4px_0px_#000]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Schedule Session
        </a>
    </div>
</div>

{{-- Status strip --}}
<div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-8">
    <div class="card p-4 border-l-4" style="border-left-color:#00FF88">
        <div class="font-display text-2xl font-black text-mint">{{ $counts['live'] }}</div>
        <div class="text-xs font-mono text-cream/50 uppercase tracking-wider">ON AIR</div>
    </div>
    <div class="card p-4 border-l-4" style="border-left-color:#FFB800">
        <div class="font-display text-2xl font-black text-gold">{{ $counts['scheduled'] }}</div>
        <div class="text-xs font-mono text-cream/50 uppercase tracking-wider">STANDBY</div>
    </div>
    <div class="card p-4 border-l-4 border-white/15">
        <div class="font-display text-2xl font-black text-cream/70">{{ $counts['ended'] }}</div>
        <div class="text-xs font-mono text-cream/50 uppercase tracking-wider">SIGNED OFF</div>
    </div>
    <div class="card p-4 border-l-4 border-white/15">
        <div class="font-display text-2xl font-black text-cream">{{ $counts['total'] }}</div>
        <div class="text-xs font-mono text-cream/50 uppercase tracking-wider">TOTAL</div>
    </div>
</div>

<div class="card overflow-hidden">
    @if($sessions->count())
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                    <th class="text-left px-5 py-3">Status</th>
                    <th class="text-left px-5 py-3">Session</th>
                    <th class="text-left px-5 py-3">Course / Link</th>
                    <th class="text-center px-5 py-3">Schedule</th>
                    <th class="text-left px-5 py-3 hidden xl:table-cell">Room Token</th>
                    <th class="text-right px-5 py-3">Actions</th>
                </tr>
            </thead>
            <tbody>
                @foreach($sessions as $session)
                <tr class="table-row">
                    <td class="px-5 py-3">
                        @if($session->status === 'live')
                            <span class="badge badge-green font-mono text-[10px]"><span class="w-1.5 h-1.5 rounded-full bg-green-400 inline-block animate-pulse mr-1"></span>LIVE</span>
                        @elseif($session->status === 'ended')
                            <span class="badge badge-gray font-mono text-[10px]">ENDED</span>
                        @else
                            <span class="badge badge-gold font-mono text-[10px]">STANDBY</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 min-w-[180px]">
                        <div class="font-medium text-cream">{{ $session->title }}</div>
                        <div class="text-xs text-cream/40 mt-0.5">
                            {{ $session->classSession?->cohort?->name ?: ($session->course?->title ?: 'Standalone') }}
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        @if($session->course)
                            <span class="text-xs text-cream/60">{{ $session->course->title }}</span>
                        @else
                            <span class="text-xs text-cream/30">—</span>
                        @endif
                    </td>
                    <td class="px-5 py-3 text-center text-xs text-cream/60 whitespace-nowrap">
                        {{ $session->scheduled_at?->format('M j, ga') }}<br>
                        <span class="text-cream/30">{{ $session->duration_minutes }}min</span>
                    </td>
                    <td class="px-5 py-3 hidden xl:table-cell">
                        <div class="flex items-center gap-2">
                            <code class="text-[10px] font-mono text-sky/70 truncate max-w-[180px]">{{ $session->room_name }}</code>
                            <button type="button" onclick="copyRoom(event)"
                                    class="copy-btn text-cream/40 hover:text-mint transition-colors"
                                    data-link="{{ route('live.room', $session) }}"
                                    title="Copy join link">
                                <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z"/></svg>
                            </button>
                        </div>
                    </td>
                    <td class="px-5 py-3">
                        <div class="flex items-center justify-end gap-2">
                            @if($session->status !== 'ended')
                                <form method="POST" action="{{ route('admin.live.start', $session) }}">
                                    @csrf
                                    <button type="submit" class="btn-primary btn-sm text-xs font-mono no-underline">{{ $session->status === 'live' ? 'Open Studio' : 'Start' }}</button>
                                </form>
                            @endif
                            @if($session->status === 'live')
                                <form method="POST" action="{{ route('admin.live.end', $session) }}">
                                    @csrf
                                    <button type="submit" class="btn-danger btn-sm text-xs font-mono no-underline">Cut Feed</button>
                                </form>
                            @endif
                            <form method="POST" action="{{ route('admin.live.destroy', $session) }}"
                                  onsubmit="return confirm('Delete this live session permanently?')">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="text-cream/30 hover:text-red-400 transition-colors p-1" title="Delete">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                                </button>
                            </form>
                        </div>
                    </td>
                </tr>
                @endforeach
            </tbody>
        </table>
    </div>
    @else
    <div class="p-12 text-center">
        <div class="text-4xl mb-3">📡</div>
        <p class="text-cream/50 font-mono text-sm mb-1">No broadcast events scheduled.</p>
        <p class="text-cream/30 text-xs font-mono">Fabricate a session above to light up the tower.</p>
    </div>
    @endif
</div>

<div class="mt-6 grid grid-cols-1 md:grid-cols-3 gap-4">
    <div class="card p-4 border-2 border-red-500/20">
        <div class="text-xs font-mono font-bold text-red-400 uppercase tracking-widest mb-2">Lobby Protection</div>
        <p class="text-xs text-cream/50 leading-relaxed">Teachers admit each student from the waiting lobby. Nobody walks in unopposed.</p>
    </div>
    <div class="card p-4 border-2 border-sky-500/20">
        <div class="text-xs font-mono font-bold text-sky-400 uppercase tracking-widest mb-2">Transport Domain</div>
        <p class="text-xs text-cream/50 leading-relaxed break-all">https://{{ $baseDomain }} — flip <code class="text-sky">JITSI_DOMAIN</code> to self-hosted whenever ready.</p>
    </div>
    <div class="card p-4 border-2 border-mint/20">
        <div class="text-xs font-mono font-bold text-mint uppercase tracking-widest mb-2">Attendance Feeds</div>
        <p class="text-xs text-cream/50 leading-relaxed">Joined students are auto-verified present against their linked class session.</p>
    </div>
</div>

@push('scripts')
<script>
    function copyRoom(event) {
        const el = event.currentTarget;
        copyText(el.dataset.link, () => {
            el.closest('td').querySelector('code').classList.add('text-mint');
        });
    }
    function copyText(text, onDone) {
        function fallback() {
            const ta = document.createElement('textarea');
            ta.value = text;
            ta.style.position = 'fixed';
            ta.style.opacity = '0';
            document.body.appendChild(ta);
            ta.select();
            try { document.execCommand('copy'); } catch (e) {}
            document.body.removeChild(ta);
            if (onDone) onDone();
        }
        if (navigator.clipboard && navigator.clipboard.writeText) {
            navigator.clipboard.writeText(text).then(onDone || (() => {})).catch(fallback);
        } else {
            fallback();
        }
    }
</script>
@endpush
@endsection