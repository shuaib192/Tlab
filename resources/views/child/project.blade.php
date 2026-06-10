@extends('layouts.app')

@section('title', $assignment->title . ' — Project')

@section('content')
<div class="min-h-screen bg-gray-50">
    {{-- Top Bar --}}
    <div class="sticky top-0 z-30 bg-white/90 backdrop-blur-xl border-b border-gray-100 px-4 sm:px-6">
        <div class="flex items-center justify-between h-14 max-w-4xl mx-auto">
            <div class="flex items-center gap-2 min-w-0">
                <a href="{{ route('child.course', $enrollment) }}" class="p-2 -ml-2 rounded-xl hover:bg-gray-100 text-muted transition-all">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 19l-7-7 7-7"/></svg>
                </a>
                <img src="/images/tlab-logo-color.png" alt="TLab" class="h-6 w-auto flex-shrink-0">
                <span class="font-bold text-sm text-ink truncate">{{ $assignment->title }}</span>
            </div>
            <div class="flex items-center gap-2">
                <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-amber-50 text-amber-600">
                    Due {{ $assignment->due_date?->format('M d, Y') ?? 'No due date' }}
                </span>
            </div>
        </div>
    </div>

    {{-- Content --}}
    <div class="max-w-4xl mx-auto px-4 sm:px-6 py-8">
        {{-- Assignment Info --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 mb-6">
            <h1 class="font-black text-2xl text-ink mb-4">{{ $assignment->title }}</h1>
            <div class="prose prose-sm max-w-none text-muted">
                {!! nl2br(e($assignment->instructions)) !!}
            </div>
            <div class="flex items-center gap-4 mt-6 pt-4 border-t border-gray-100 text-sm text-muted">
                <span class="font-semibold">Max Score: {{ $assignment->max_score }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span class="font-semibold">{{ $assignment->submissions()->where('child_profile_id', $child->id)->exists() ? 'Already Submitted' : 'Not Submitted' }}</span>
            </div>
        </div>

        {{-- Submission Form --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="font-black text-lg text-ink mb-6">Submit Your Work</h2>
            <form method="POST" action="{{ route('child.project.submit', [$enrollment, $assignment]) }}" enctype="multipart/form-data">
                @csrf

                <div class="mb-6">
                    <label class="block font-bold text-sm text-ink mb-2">Your Response</label>
                    <textarea name="content" rows="8" class="form-input w-full p-4 rounded-xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all font-semibold text-sm" placeholder="Write your answer here...">{{ old('content') }}</textarea>
                    @error('content') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>

                <div class="mb-6">
                    <label class="block font-bold text-sm text-ink mb-2">Upload File (optional)</label>
                    <input type="file" name="file" class="block w-full text-sm text-muted file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all">
                    @error('file') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-muted mt-2">Accepted: images, PDFs, documents (max 10MB)</p>
                </div>

                <button type="submit" class="btn-cta w-full justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-7 7m7-7l7 7"/></svg>
                    Submit Project
                </button>
            </form>
        </div>

        {{-- Previous Submission --}}
        @if($existingSubmission ?? false)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 mt-6">
            <h2 class="font-black text-lg text-ink mb-4">Your Previous Submission</h2>
            <div class="p-4 rounded-xl bg-gray-50 mb-4">
                <p class="text-sm text-muted whitespace-pre-wrap">{{ $existingSubmission->content }}</p>
            </div>
            @if($existingSubmission->file_url)
            <a href="{{ $existingSubmission->file_url }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:underline">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                View Attached File
            </a>
            @endif
            @if($existingSubmission->score !== null)
            <div class="mt-4 p-4 rounded-xl bg-amber-50 border border-amber-100">
                <div class="flex items-center gap-3">
                    <span class="font-black text-xl text-amber-600">{{ $existingSubmission->score }}/{{ $assignment->max_score }}</span>
                    <div class="flex-1 h-2 rounded-full bg-amber-100 overflow-hidden">
                        <div class="h-full rounded-full bg-amber-500" style="width:{{ ($existingSubmission->score / $assignment->max_score) * 100 }}%"></div>
                    </div>
                </div>
                @if($existingSubmission->feedback)
                <p class="text-sm text-muted mt-3 font-semibold">Feedback: {{ $existingSubmission->feedback }}</p>
                @endif
            </div>
            @endif
        </div>
        @endif
    </div>
</div>
@endSection
