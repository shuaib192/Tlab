@extends('school.layouts.school')
@section('title', 'Students - School Portal')
@section('content')
<div class="flex items-center justify-between mb-8">
    <div>
        <h1 class="font-black text-2xl text-ink">Students</h1>
        <p class="text-muted text-sm font-semibold">{{ $school->name }}</p>
    </div>
    <div class="flex gap-3">
        <a href="{{ route('school.students.import', ['school_id' => $school->id]) }}" class="inline-flex items-center gap-2 bg-primary text-white px-5 py-2.5 rounded-xl font-bold text-sm hover:bg-primary/90 transition-all">CSV Import</a>
    </div>
</div>

<div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden">
    <div class="p-4 border-b border-gray-50">
        <form method="GET" class="flex gap-3">
            <input type="text" name="search" value="{{ request('search') }}" placeholder="Search students..." class="flex-1 px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
            <select name="course_id" class="px-4 py-2.5 rounded-xl border border-gray-200 text-sm focus:ring-2 focus:ring-primary/20 focus:border-primary outline-none">
                <option value="">All Courses</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ request('course_id') == $course->id ? 'selected' : '' }}>{{ $course->title }}</option>
                @endforeach
            </select>
            <button class="px-5 py-2.5 bg-gray-100 rounded-xl font-bold text-sm text-ink hover:bg-gray-200 transition-colors">Filter</button>
        </form>
    </div>
    <table class="w-full">
        <thead><tr class="border-b border-gray-50">
            <th class="text-left px-6 py-4 text-xs font-bold uppercase text-muted">Name</th>
            <th class="text-left px-6 py-4 text-xs font-bold uppercase text-muted">Parent</th>
            <th class="text-left px-6 py-4 text-xs font-bold uppercase text-muted">Courses</th>
            <th class="text-left px-6 py-4 text-xs font-bold uppercase text-muted">XP</th>
            <th class="text-left px-6 py-4 text-xs font-bold uppercase text-muted">Rank</th>
        </tr></thead>
        <tbody>
            @forelse($students as $student)
            <tr class="border-b border-gray-50 hover:bg-gray-50/50 transition-colors">
                <td class="px-6 py-4">
                    <div class="flex items-center gap-3">
                        <div class="w-9 h-9 rounded-xl bg-primary/10 flex items-center justify-center font-bold text-primary text-sm">{{ strtoupper(substr($student->name, 0, 1)) }}</div>
                        <span class="font-bold text-sm text-ink">{{ $student->name }}</span>
                    </div>
                </td>
                <td class="px-6 py-4 text-sm text-muted font-semibold">{{ $student->parent?->name ?? 'N/A' }}</td>
                <td class="px-6 py-4">
                    <div class="flex gap-1 flex-wrap">
                        @foreach($student->enrollments as $e)
                        <span class="text-xs font-bold px-2 py-1 rounded-full bg-primary/10 text-primary">{{ $e->course->title ?? 'N/A' }}</span>
                        @endforeach
                    </div>
                </td>
                <td class="px-6 py-4 text-sm font-bold text-ink">{{ number_format($student->xp) }}</td>
                <td class="px-6 py-4"><span class="text-xs font-bold px-3 py-1.5 rounded-full bg-amber-50 text-amber-600">{{ $student->rank ?? 'Explorer' }}</span></td>
            </tr>
            @empty
            <tr><td colspan="5" class="px-6 py-12 text-center text-muted/50 text-sm font-semibold">No students found.</td></tr>
            @endforelse
        </tbody>
    </table>
    @if($students->hasPages())
    <div class="px-6 py-4 border-t border-gray-50">{{ $students->links() }}</div>
    @endif
</div>
@endsection
