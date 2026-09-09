@extends('school.layouts.school')
@section('title', 'School Dashboard')
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-black text-2xl text-cream">{{ $school->name }}</h1>
        <p class="text-muted text-sm font-semibold">{{ $school->city }}, {{ $school->state }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('school.students.import', ['school_id' => $school->id]) }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">Import Students</a>
        <a href="{{ route('school.analytics', ['school_id' => $school->id]) }}" class="inline-flex items-center gap-2 bg-white border border-gray-200 text-ink px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-gray-50 transition-all">View Analytics</a>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-5 mb-10">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Active Students</div>
        <div class="font-black text-3xl text-ink">{{ $activeStudents }}</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Teachers</div>
        <div class="font-black text-3xl text-ink">{{ $teachers }}</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Total Enrollments</div>
        <div class="font-black text-3xl text-ink">{{ $enrollments }}</div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <div class="text-muted text-xs font-bold uppercase tracking-wider mb-1">Completion Rate</div>
        <div class="font-black text-3xl text-primary">{{ $completionRate }}%</div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-10">
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-black text-base text-ink mb-4">Course Completion Rates</h2>
        <div class="space-y-4">
            @forelse($completionsByCourse as $c)
            <div>
                <div class="flex justify-between text-sm mb-1">
                    <span class="font-bold text-ink">{{ $c->title }}</span>
                    <span class="text-muted font-semibold">{{ $c->completed }}/{{ $c->total }}</span>
                </div>
                <div class="h-2.5 rounded-full bg-gray-100 overflow-hidden">
                    <div class="h-full rounded-full bg-primary" style="width:{{ $c->total > 0 ? ($c->completed/$c->total)*100 : 0 }}%"></div>
                </div>
            </div>
            @empty
            <p class="text-muted/50 text-sm font-semibold text-center py-8">No course data yet</p>
            @endforelse
        </div>
    </div>
    <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6">
        <h2 class="font-black text-base text-ink mb-4">Quick Actions</h2>
        <div class="grid grid-cols-2 gap-3">
            <a href="{{ route('school.students', ['school_id' => $school->id]) }}" class="p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                <div class="font-bold text-sm text-ink">View Students</div>
                <div class="text-xs text-muted mt-1">Manage all enrolled students</div>
            </a>
            <a href="{{ route('school.students.import', ['school_id' => $school->id]) }}" class="p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                <div class="font-bold text-sm text-ink">CSV Import</div>
                <div class="text-xs text-muted mt-1">Bulk onboard students</div>
            </a>
            <a href="{{ route('school.students.provisioning', ['school_id' => $school->id]) }}" class="p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                <div class="font-bold text-sm text-ink">Add Teachers</div>
                <div class="text-xs text-muted mt-1">Provision teacher accounts</div>
            </a>
            <a href="{{ route('school.analytics', ['school_id' => $school->id]) }}" class="p-4 rounded-xl bg-gray-50 hover:bg-gray-100 transition-colors">
                <div class="font-bold text-sm text-ink">Analytics</div>
                <div class="text-xs text-muted mt-1">School-wide reports</div>
            </a>
        </div>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="px-6 py-5 border-b border-gray-50 flex items-center justify-between">
        <h2 class="font-black text-base text-ink">Recent Enrollments</h2>
        <span class="text-xs font-bold text-muted bg-gray-100 px-3 py-1.5 rounded-full">{{ $recentEnrollments->count() }} records</span>
    </div>
    <div class="p-2">
        @forelse($recentEnrollments as $enrollment)
        <div class="flex items-center justify-between py-3 px-4 rounded-xl hover:bg-gray-50 transition-colors">
            <div class="flex items-center gap-3">
                <div class="w-10 h-10 rounded-xl bg-primary/10 flex items-center justify-center font-bold text-primary">
                    {{ strtoupper(substr($enrollment->child->name ?? '?', 0, 1)) }}
                </div>
                <div>
                    <div class="font-bold text-sm text-ink">{{ $enrollment->child->name ?? 'Unknown' }}</div>
                    <div class="text-xs text-muted">{{ $enrollment->course->title ?? 'N/A' }}</div>
                </div>
            </div>
            <span class="text-xs font-bold px-3 py-1.5 rounded-full {{ $enrollment->status === 'active' ? 'bg-green-50 text-green-600' : 'bg-gray-100 text-muted' }}">{{ ucfirst($enrollment->status) }}</span>
        </div>
        @empty
        <p class="text-center text-muted/50 text-sm font-semibold py-8">No enrollments yet</p>
        @endforelse
    </div>
</div>
@endsection
