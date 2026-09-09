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
                @if($existingSubmission && $assignment->due_date && $existingSubmission->submitted_at && $existingSubmission->submitted_at->gt($assignment->due_date->endOfDay()))
                    <span class="text-xs font-bold px-3 py-1.5 rounded-full bg-red-50 text-red-600">Late</span>
                @endif
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
            <div class="flex flex-wrap items-center gap-4 mt-6 pt-4 border-t border-gray-100 text-sm text-muted">
                <span class="font-semibold">Max Score: {{ $assignment->max_score }}</span>
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span class="font-semibold">{{ $existingSubmission ? 'Already Submitted' : 'Not Submitted' }}</span>
                @if($existingSubmission)
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span class="font-semibold">Version {{ $existingSubmission->version }}</span>
                @endif
                <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                <span class="text-xs px-2 py-0.5 rounded-full bg-gray-100">
                    @if($assignment->type === 'both') File or Link
                    @elseif($assignment->type === 'file') File Upload
                    @elseif($assignment->type === 'link') Project Link
                    @endif
                </span>
            </div>
        </div>

        {{-- Submission Form --}}
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8">
            <h2 class="font-black text-lg text-ink mb-6">{{ $existingSubmission ? 'Update Submission' : 'Submit Your Work' }}</h2>
            <form method="POST" action="{{ route('child.project.submit', [$enrollment, $assignment]) }}" enctype="multipart/form-data" id="submit-form">
                @csrf

                @if($assignment->acceptsLinks())
                <div class="mb-6">
                    <label class="block font-bold text-sm text-ink mb-2">Project Link</label>
                    <input type="url" name="link_url" value="{{ old('link_url', $existingSubmission->link_url ?? '') }}"
                           class="form-input w-full p-4 rounded-xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all font-semibold text-sm"
                           placeholder="https://scratch.mit.edu/...">
                    @error('link_url') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-muted mt-2">Paste a link to your project (Scratch, Replit, GitHub, Google Drive, Figma, etc.)</p>

                    <label class="block font-bold text-sm text-ink mb-2 mt-4">Link Note (optional)</label>
                    <textarea name="link_note" rows="2" class="form-input w-full p-4 rounded-xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all font-semibold text-sm" placeholder="Brief note about your project...">{{ old('link_note', $existingSubmission->link_note ?? '') }}</textarea>
                    @error('link_note') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                @endif

                @if($assignment->acceptsFiles())
                <div class="mb-6">
                    <label class="block font-bold text-sm text-ink mb-2">Upload Files (max 3)</label>
                    <input type="file" name="files[]" multiple
                           class="block w-full text-sm text-muted file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-0 file:text-sm file:font-bold file:bg-primary/10 file:text-primary hover:file:bg-primary/20 transition-all"
                           accept=".pdf,.docx,.pptx,.xlsx,.jpg,.jpeg,.png,.zip" id="file-input">
                    @error('files') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    @error('files.*') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                    <p class="text-xs text-muted mt-2">Accepted: PDF, DOCX, PPTX, XLSX, JPG, PNG, ZIP — max 25MB each, 3 files max</p>
                    <div id="file-list" class="mt-3 space-y-2"></div>
                </div>
                @endif

                @if($assignment->acceptsFiles())
                <div class="mb-6">
                    <label class="block font-bold text-sm text-ink mb-2">Notes (optional)</label>
                    <textarea name="submission_text" rows="4" class="form-input w-full p-4 rounded-xl border-2 border-gray-200 bg-gray-50 focus:bg-white focus:border-primary outline-none transition-all font-semibold text-sm" placeholder="Add a note about your submission...">{{ old('submission_text', $existingSubmission->submission_text ?? '') }}</textarea>
                    @error('submission_text') <p class="text-red-500 text-xs font-bold mt-1">{{ $message }}</p> @enderror
                </div>
                @endif

                <button type="submit" class="btn-cta w-full justify-center">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-7 7m7-7l7 7"/></svg>
                    {{ $existingSubmission ? 'Update Submission' : 'Submit Project' }}
                </button>
            </form>
        </div>

        {{-- Previous Submission --}}
        @if($existingSubmission)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 mt-6">
            <h2 class="font-black text-lg text-ink mb-4">Your Submission</h2>

            @if($existingSubmission->link_url)
                <div class="p-4 rounded-xl bg-sky/5 border border-sky/10 mb-4">
                    <div class="text-xs font-bold text-muted mb-1">Project Link</div>
                    <a href="{{ $existingSubmission->link_url }}" target="_blank" class="text-sm text-primary hover:underline break-all">{{ $existingSubmission->link_url }}</a>
                    @if($existingSubmission->link_note)
                        <p class="text-xs text-muted mt-2">{{ $existingSubmission->link_note }}</p>
                    @endif
                </div>
            @endif

            @if($existingSubmission->submission_text)
                <div class="p-4 rounded-xl bg-gray-50 mb-4">
                    <p class="text-sm text-muted whitespace-pre-wrap">{{ $existingSubmission->submission_text }}</p>
                </div>
            @endif

            @if($existingSubmission->files && $existingSubmission->files->count())
                <div class="mb-4">
                    <div class="text-xs font-bold text-muted mb-2">Attached Files</div>
                    @foreach($existingSubmission->files as $file)
                        <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:underline mr-4 mb-2">
                            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                            {{ $file->file_name }} <span class="text-muted font-normal">({{ round($file->file_size / 1024) }}KB)</span>
                        </a>
                    @endforeach
                </div>
            @elseif($existingSubmission->file_url)
                <div class="mb-4">
                    <a href="{{ $existingSubmission->file_url }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-bold text-primary hover:underline">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View Attached File
                    </a>
                </div>
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

        {{-- Version History --}}
        @if($allVersions && $allVersions->count() > 1)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm p-6 sm:p-8 mt-6">
            <h2 class="font-black text-lg text-ink mb-4">Submission History</h2>
            <div class="space-y-3">
                @foreach($allVersions as $v)
                    <div class="flex items-center gap-4 p-3 rounded-xl bg-gray-50 text-sm">
                        <span class="font-bold text-ink">v{{ $v->version }}</span>
                        <span class="text-muted">{{ $v->submitted_at->diffForHumans() }}</span>
                        @if($v->submitted_late)
                            <span class="px-2 py-0.5 rounded bg-red-50 text-red-600 text-xs font-bold">Late</span>
                        @endif
                        @if($v->score !== null)
                            <span class="font-bold text-amber-600">{{ $v->score }}/{{ $assignment->max_score }}</span>
                        @endif
                        @if($v->files && $v->files->count())
                            <span class="text-muted text-xs">{{ $v->files->count() }} file(s)</span>
                        @endif
                        @if($v->link_url)
                            <a href="{{ $v->link_url }}" target="_blank" class="text-primary text-xs">link</a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>
        @endif
    </div>
</div>

@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', () => {
    const fileInput = document.getElementById('file-input');
    const fileList = document.getElementById('file-list');
    if (!fileInput || !fileList) return;

    fileInput.addEventListener('change', () => {
        fileList.innerHTML = '';
        const files = Array.from(fileInput.files).slice(0, 3);
        files.forEach((f, i) => {
            const size = (f.size / 1024).toFixed(0);
            const div = document.createElement('div');
            div.className = 'flex items-center gap-2 text-xs text-muted';
            div.innerHTML = `<svg class="w-3 h-3 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> ${f.name} <span class="text-gray-400">(${size}KB)</span>`;
            fileList.appendChild(div);
        });
        if (fileInput.files.length > 3) {
            const warn = document.createElement('div');
            warn.className = 'text-xs text-red-500 font-bold';
            warn.textContent = 'Max 3 files allowed — extra files will be ignored.';
            fileList.appendChild(warn);
        }
    });
});
</script>
@endpush
@endsection
