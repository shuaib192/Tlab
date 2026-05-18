@extends('layouts.admin')
@section('title', 'Courses')
@section('content')

<div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-8">
    <div>
        <h1 class="font-display text-3xl font-bold mb-1">Courses</h1>
        <p class="text-cream/50 text-sm">All courses across every club. Manage content, levels, and assignments.</p>
    </div>
    <a href="{{ route('admin.courses.create') }}" class="btn-primary self-start sm:self-auto">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
        New Course
    </a>
</div>

<div class="card overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full">
            <thead>
                <tr class="border-b border-white/5">
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Course</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden sm:table-cell">Club</th>
                    <th class="text-left px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40 hidden md:table-cell">Level</th>
                    <th class="text-right px-6 py-4 text-xs font-bold uppercase tracking-wider text-cream/40">Actions</th>
                </tr>
            </thead>
            <tbody>
                @forelse($courses as $course)
                <tr class="table-row">
                    <td class="px-6 py-4">
                        <div class="font-semibold text-sm">{{ $course->title }}</div>
                        <div class="text-cream/40 text-xs mt-0.5 hidden sm:block">{{ Str::limit($course->description, 60) }}</div>
                    </td>
                    <td class="px-6 py-4 hidden sm:table-cell">
                        <span class="badge" style="background:{{ $course->club->color_theme ?? '#4E9966' }}15; color:{{ $course->club->color_theme ?? '#4E9966' }}; border:1px solid {{ $course->club->color_theme ?? '#4E9966' }}30">
                            {{ $course->club->name ?? 'Unassigned' }}
                        </span>
                    </td>
                    <td class="px-6 py-4 hidden md:table-cell">
                        <span class="badge {{ $course->level === 'beginner' ? 'badge-green' : ($course->level === 'intermediate' ? 'badge-gold' : 'badge-red') }}">
                            {{ ucfirst($course->level) }}
                        </span>
                    </td>
                    <td class="px-6 py-4">
                        <div class="flex items-center justify-end gap-2">
                            <a href="{{ route('admin.courses.edit', $course) }}" class="btn-secondary text-xs px-3 py-2">Edit</a>
                            <form method="POST" action="{{ route('admin.courses.destroy', $course) }}"
                                  onsubmit="return confirm('Delete course {{ addslashes($course->title) }}?')">
                                @csrf @method('DELETE')
                                <button class="btn-danger text-xs">Delete</button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="4" class="px-6 py-12 text-center text-cream/30 text-sm">No courses yet. <a href="{{ route('admin.courses.create') }}" class="text-mint hover:underline">Create one.</a></td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @if($courses->hasPages())
    <div class="px-6 py-4 border-t border-white/5">{{ $courses->links() }}</div>
    @endif
</div>
@endsection
