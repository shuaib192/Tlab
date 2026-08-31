@extends('school.layouts.school')
@section('title', 'Analytics - School Portal')
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-black text-2xl text-ink">School Analytics</h1>
        <p class="text-muted text-sm font-semibold">{{ $school->name }}</p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Total Students</div>
        <div class="font-black text-3xl text-ink">{{ $totalStudents }}</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Active Students</div>
        <div class="font-black text-3xl text-primary">{{ $activeStudents }}</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Attendance Rate</div>
        <div class="font-black text-3xl text-amber">{{ $attendanceRate }}%</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Active Rate</div>
        <div class="font-black text-3xl text-accent">{{ $totalStudents > 0 ? round(($activeStudents/$totalStudents)*100) : 0 }}%</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-black text-base text-ink mb-4">Grade Distribution</h2>
        <div class="space-y-3">
            @foreach(['A' => '#16A34A', 'B' => '#2563EB', 'C' => '#D97706', 'D' => '#EF4444'] as $grade => $color)
            @php $pct = $gradeDistribution[$grade] ?? 0; @endphp
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-bold text-ink">Grade {{ $grade }}</span>
                    <span class="text-muted font-semibold">{{ round($pct) }}%</span>
                </div>
                <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full" style="width:{{ $pct }}%;background:{{ $color }}"></div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-black text-base text-ink mb-4">Monthly Enrollments</h2>
        @if($monthlyEnrollments->isNotEmpty())
        <div class="space-y-3">
            @foreach($monthlyEnrollments as $month => $count)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-bold text-ink">{{ \Carbon\Carbon::createFromFormat('Y-m', $month)->format('M Y') }}</span>
                    <span class="text-muted font-semibold">{{ $count }} enrollments</span>
                </div>
                <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full bg-gradient-to-r from-primary to-accent" style="width:{{ ($count / $monthlyEnrollments->max()) * 100 }}%"></div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <p class="text-center text-muted/50 text-sm font-semibold py-8">No enrollment data yet</p>
        @endif
    </div>
</div>
@endsection
