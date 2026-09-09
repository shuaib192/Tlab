@extends('school.layouts.school')
@section('title', 'Select School')
@section('content')
<div class="max-w-lg mx-auto py-20">
    <h1 class="font-black text-2xl text-cream text-center mb-8">Select a School</h1>
    <div class="space-y-3">
        @foreach($schools as $school)
        <a href="{{ route('school.dashboard', ['school_id' => $school->id]) }}" class="block bg-white rounded-2xl border border-gray-100 shadow-sm p-6 hover:shadow-lg hover:-translate-y-0.5 transition-all">
            <div class="font-bold text-lg text-ink">{{ $school->name }}</div>
            <div class="text-sm text-muted">{{ $school->city }}, {{ $school->state }}</div>
        </a>
        @endforeach
    </div>
</div>
@endsection
