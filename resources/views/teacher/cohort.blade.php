@extends('layouts.teacher')

@section('title', $cohort->name)

@section('content')
    <div class="card p-6 mb-6">
        <div class="flex flex-col sm:flex-row sm:items-center sm:justify-between gap-4">
            <div>
                <div class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">
                    <a href="{{ route('teacher.course', $cohort->course) }}" class="hover:text-mint transition-colors">{{ $cohort->course->title }}</a>
                    &nbsp;/&nbsp; Cohort
                </div>
                <h1 class="text-2xl font-bold">{{ $cohort->name }}</h1>
                @if($cohort->description)
                    <p class="text-sm text-cream/60 mt-1">{{ $cohort->description }}</p>
                @endif
            </div>
            <div class="flex items-center gap-3">
                <span class="badge {{ $cohort->status === 'active' ? 'badge-green' : 'badge-gray' }}">
                    {{ $cohort->status ?? 'active' }}
                </span>
                <a href="{{ route('teacher.course', $cohort->course) }}" class="btn-secondary btn-sm no-underline">Back to Course</a>
            </div>
        </div>
    </div>

    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        {{-- Student Roster --}}
        <div class="lg:col-span-2">
            <h2 class="text-lg font-bold mb-4">Student Roster ({{ $cohort->children->count() }})</h2>
            <div class="card overflow-hidden">
                @if($cohort->children->count())
                    <div class="overflow-x-auto">
                        <table class="w-full text-sm">
                            <thead>
                                <tr class="border-b border-white/5 text-xs font-bold text-cream/40 uppercase tracking-wider">
                                    <th class="text-left px-5 py-3">Student</th>
                                    <th class="text-center px-5 py-3">XP</th>
                                    <th class="text-center px-5 py-3">Rank</th>
                                    <th class="text-center px-5 py-3">Attendance</th>
                                    <th class="text-right px-5 py-3">Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($cohort->children as $child)
                                    <tr class="table-row">
                                        <td class="px-5 py-3">
                                            <div class="flex items-center gap-3">
                                                <div class="w-8 h-8 rounded-full bg-mint/10 border border-mint/20 flex items-center justify-center text-xs font-bold text-mint flex-shrink-0">
                                                    {{ strtoupper(substr($child->name, 0, 1)) }}
                                                </div>
                                                <div>
                                                    <div class="font-medium">{{ $child->name }}</div>
                                                    <div class="text-xs text-cream/40">@if($child->username){{ '@'.$child->username }}@else &mdash; @endif</div>
                                                </div>
                                            </div>
                                        </td>
                                        <td class="px-5 py-3 text-center font-bold text-gold">{{ number_format($child->xp) }}</td>
                                        <td class="px-5 py-3 text-center">
                                            <span class="badge badge-sky">{{ $child->rank ?? 'Explorer' }}</span>
                                        </td>
                                        <td class="px-5 py-3 text-center">
                                            @if(isset($attendanceSummary[$child->id]))
                                                <span class="badge {{ $attendanceSummary[$child->id] >= 75 ? 'badge-green' : ($attendanceSummary[$child->id] >= 50 ? 'badge-gold' : 'badge-red') }}">
                                                    {{ $attendanceSummary[$child->id] }}%
                                                </span>
                                            @else
                                                <span class="badge badge-gray">—</span>
                                            @endif
                                        </td>
                                        <td class="px-5 py-3 text-right">
                                            <form method="POST" action="{{ route('teacher.award-xp', $child) }}" class="inline-flex items-center gap-1">
                                                @csrf
                                                <input type="number" name="amount" placeholder="XP" class="input w-16 text-xs py-1 px-2" min="1" max="1000" required>
                                                <input type="text" name="activity" placeholder="Reason" class="input w-28 text-xs py-1 px-2" maxlength="255" required>
                                                <button type="submit" class="btn-primary btn-sm text-xs">Award</button>
                                            </form>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @else
                    <div class="p-8 text-center text-cream/40">
                        <p>No students enrolled in this cohort.</p>
                    </div>
                @endif
            </div>
        </div>

        {{-- Sessions List --}}
        <div>
            <h2 class="text-lg font-bold mb-4">Sessions ({{ $sessions->count() }})</h2>
            <div class="space-y-3">
                @forelse($sessions as $session)
                    <a href="{{ route('teacher.session', $session) }}" class="card p-4 block hover:border-mint/30 transition-all group">
                        <div class="flex items-center justify-between mb-1">
                            <span class="font-semibold text-sm group-hover:text-mint transition-colors">{{ $session->title }}</span>
                            <span class="text-xs text-cream/40">{{ $session->date->format('M d') }}</span>
                        </div>
                        <div class="text-xs text-cream/50">
                            {{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }}
                            @if($session->status)
                                &middot; <span class="badge badge-gray">{{ $session->status }}</span>
                            @endif
                        </div>
                    </a>
                @empty
                    <div class="card p-6 text-center text-cream/40">
                        <p>No sessions created yet.</p>
                    </div>
                @endforelse
            </div>
        </div>
    </div>
@endsection
