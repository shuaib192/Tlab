@extends('layouts.admin')
@section('title', 'Audit Log — Immutable Change Trail')
@section('content')

<div class="mb-8">
    <h1 class="font-display text-3xl font-bold mb-1">Audit Log</h1>
    <p class="text-cream/50 text-sm">Immutable record of privileged changes. Old and new values are preserved for sensitive corrections.</p>
</div>

<form method="GET" class="flex flex-wrap gap-3 mb-6">
    <input type="text" name="q" value="{{ request('q') }}" class="input flex-1 min-w-[180px] max-w-xs" placeholder="Search reason or type...">
    <select name="user_id" class="input w-auto">
        <option value="">All users</option>
        @foreach($users as $u)
        <option value="{{ $u->id }}" {{ (string) request('user_id') === (string) $u->id ? 'selected' : '' }}>{{ $u->name }}</option>
        @endforeach
    </select>
    <select name="action" class="input w-auto">
        <option value="">All actions</option>
        @foreach($actions as $a)
        <option value="{{ $a }}" {{ request('action') === $a ? 'selected' : '' }}>{{ ucfirst($a) }}</option>
        @endforeach
    </select>
    <select name="auditable_type" class="input w-auto">
        <option value="">All record types</option>
        @foreach($auditableTypes as $t)
        <option value="{{ $t }}" {{ request('auditable_type') === $t ? 'selected' : '' }}>{{ $typeLabels[$t] ?? class_basename($t) }}</option>
        @endforeach
    </select>
    <button type="submit" class="btn-primary">Filter</button>
    @if(request()->anyFilled(['q','user_id','action','auditable_type']))
    <a href="{{ route('admin.audit-log.index') }}" class="btn-secondary">Clear</a>
    @endif
</form>

<div class="card overflow-hidden">
    <div class="px-6 py-4 border-b border-white/5 flex items-center justify-between">
        <h2 class="font-display font-bold">Change Trail</h2>
        <span class="badge badge-gold">{{ $logs->total() }} events</span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">When</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Who</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Action</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Record</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Change</th>
                    <th class="text-left px-6 py-3 text-xs font-bold uppercase tracking-wider text-cream/40">Reason</th>
                </tr>
            </thead>
            <tbody>
                @forelse($logs as $log)
                <tr class="table-row align-top">
                    <td class="px-6 py-4 text-cream/50 text-xs whitespace-nowrap">{{ $log->created_at->format('d M Y · H:i') }}</td>
                    <td class="px-6 py-4">
                        <div class="text-sm font-semibold">{{ $log->user->name ?? 'System' }}</div>
                        <div class="text-cream/30 text-xs">{{ $log->user->email ?? '' }}</div>
                    </td>
                    <td class="px-6 py-4">
                        <span class="badge {{ $log->action === 'created' ? 'badge-green' : ($log->action === 'updated' ? 'badge-gold' : 'badge-red') }}">
                            {{ $log->action }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="text-xs text-cream/60">{{ $typeLabels[$log->auditable_type] ?? class_basename($log->auditable_type) }}</div>
                        <div class="text-cream/30 text-[11px]">#{{ $log->auditable_id }}</div>
                    </td>
                    <td class="px-6 py-4">
                        @if($log->action === 'updated')
                            @foreach(($log->old_values ?? []) as $key => $old)
                                <div class="text-xs font-mono mb-0.5">
                                    <span class="text-cream/40">{{ $key }}:</span>
                                    <span class="text-terra line-through">{{ is_array($old) ? json_encode($old) : (string) $old }}</span>
                                    <span class="text-cream/25">→</span>
                                    <span class="text-mint">{{ is_array($log->new_values[$key] ?? null) ? json_encode($log->new_values[$key]) : ($log->new_values[$key] ?? '∅') }}</span>
                                </div>
                            @endforeach
                        @else
                            <span class="text-xs font-mono text-cream/40">{{ json_encode($log->new_values ?? $log->old_values ?? [], JSON_UNESCAPED_SLASHES) }}</span>
                        @endif
                    </td>
                    <td class="px-6 py-4 text-xs text-cream/60 max-w-[200px]">{{ $log->reason ?? '—' }}</td>
                </tr>
                @empty
                <tr><td colspan="6" class="px-6 py-12 text-center text-cream/30 text-sm">No audit events yet.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    <div class="px-6 py-4 border-t border-white/5">
        {{ $logs->links() }}
    </div>
</div>

@endsection