@extends('layouts.admin')
@section('title', 'Enroll a Child')
@section('content')

<div class="mb-8">
    <a href="{{ route('admin.enrollments.index') }}" class="inline-flex items-center gap-2 text-cream/50 hover:text-mint mb-4 transition-colors text-sm font-medium">
        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
        Back to Enrollments
    </a>
    <h1 class="font-display text-3xl font-bold">Enroll a Child</h1>
    <p class="text-cream/50 text-sm mt-1">Manually enroll a child into a course.</p>
</div>

<div class="max-w-xl">
    @if(session('error')) <div class="flash-error mb-6">{{ session('error') }}</div> @endif
    @if($errors->any()) <div class="flash-error mb-6">@foreach($errors->all() as $e)<p>{{ $e }}</p>@endforeach</div> @endif

    <form method="POST" action="{{ route('admin.enrollments.store') }}" class="card p-6 space-y-5">
        @csrf

        <div>
            <label class="label">Child</label>
            <select name="child_profile_id" required class="input appearance-none">
                <option value="">Select a child...</option>
                @foreach($children as $child)
                <option value="{{ $child->id }}" {{ old('child_profile_id') == $child->id ? 'selected' : '' }}>
                    {{ $child->name }} ({{ $child->parent->name ?? 'Unknown parent' }})
                </option>
                @endforeach
            </select>
        </div>

        <div>
            <label class="label">Course</label>
            <select name="course_id" required class="input appearance-none">
                <option value="">Select a course...</option>
                @foreach($courses as $course)
                <option value="{{ $course->id }}" {{ old('course_id') == $course->id ? 'selected' : '' }}>
                    {{ $course->club->name }} — {{ $course->title }}
                </option>
                @endforeach
            </select>
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="label">Enrollment Status</label>
                <select name="status" class="input appearance-none">
                    <option value="active">Active</option>
                    <option value="completed">Completed</option>
                    <option value="dropped">Dropped</option>
                </select>
            </div>
            <div>
                <label class="label">Payment Status</label>
                <select name="payment_status" class="input appearance-none">
                    <option value="pending">Pending</option>
                    <option value="paid">Paid</option>
                </select>
            </div>
        </div>

        <div class="flex gap-3 pt-2">
            <button type="submit" class="btn-primary">Create Enrollment</button>
            <a href="{{ route('admin.enrollments.index') }}" class="btn-secondary">Cancel</a>
        </div>
    </form>
</div>
@endsection
