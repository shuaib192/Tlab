@extends('layouts.child')

@section('title', $assignment->title . ' — Project')

@section('content')
    {{-- Header --}}
    <div class="flex items-center justify-between gap-3 mb-6 reveal pop-in">
        <a href="{{ route('child.course', $enrollment) }}" class="inline-flex items-center gap-2 px-3.5 py-2 rounded-2xl bg-panel border-2 border-cream/15 shadow-[4px_4px_0_rgba(9,6,24,.92)] text-cream/85 hover:text-cream hover:border-cream/40 hover:bg-surface transition-colors text-xs font-black tracking-wide">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M15 19l-7-7 7-7"/></svg>
            BACK TO MISSION
        </a>
        <div class="flex items-center gap-2">
            @if($existingSubmission && $assignment->due_date && $existingSubmission->submitted_at && $existingSubmission->submitted_at->gt($assignment->due_date->endOfDay()))
                <span class="sticker px-3 py-1.5 bg-terra/20 text-terra">LATE</span>
            @endif
            <span class="sticker px-3 py-1.5 bg-cream/10 text-cream/75">
                DUE {{ $assignment->due_date?->format('M d, Y') ?? 'ANYTIME' }}
            </span>
        </div>
    </div>

    {{-- Assignment Info --}}
    <div class="candy-card hard-shadow p-6 sm:p-8 mb-6 reveal" data-delay="60">
        <h1 class="font-display font-extrabold text-2xl text-cream mb-4">{{ $assignment->title }}</h1>
        <div class="prose prose-sm max-w-none text-cream/70 font-semibold">
            {!! nl2br(e($assignment->instructions)) !!}
        </div>
        <div class="flex flex-wrap items-center gap-4 mt-6 pt-4 border-t-2 border-cream/10 text-sm text-cream/60 font-bold">
            <span>Max Score: {{ $assignment->max_score }}</span>
            <span class="w-1 h-1 rounded-full bg-cream/25"></span>
            <span>{{ $existingSubmission ? 'Already Submitted' : 'Not Submitted' }}</span>
            @if($existingSubmission)
                <span class="w-1 h-1 rounded-full bg-cream/25"></span>
                <span>Version {{ $existingSubmission->version }}</span>
            @endif
            <span class="w-1 h-1 rounded-full bg-cream/25"></span>
            <span class="sticker px-2.5 py-1 bg-cream/10 text-cream/75 text-xs">
                @if($assignment->type === 'both') File or Link
                @elseif($assignment->type === 'file') File Upload
                @elseif($assignment->type === 'link') Project Link
                @endif
            </span>
        </div>
    </div>

    {{-- Submission Form --}}
    <div class="candy-card hard-shadow p-6 sm:p-8 reveal" data-delay="100">
        <h2 class="font-display font-extrabold text-lg text-cream mb-6">{{ $existingSubmission ? 'Update Submission' : 'Submit Your Work' }}</h2>
        <form method="POST" action="{{ route('child.project.submit', [$enrollment, $assignment]) }}" enctype="multipart/form-data" id="submit-form">
            @csrf

            @if($assignment->acceptsLinks())
            <div class="mb-6">
                <label class="block font-black text-sm text-cream mb-2">Project Link</label>
                <input type="url" name="link_url" value="{{ old('link_url', $existingSubmission->link_url ?? '') }}"
                       class="input-candy"
                       placeholder="https://scratch.mit.edu/...">
                @error('link_url') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-cream/45 font-bold mt-2">Paste a link to your project (Scratch, Replit, GitHub, Google Drive, Figma, etc.)</p>

                <label class="block font-black text-sm text-cream mb-2 mt-4">Link Note (optional)</label>
                <textarea name="link_note" rows="2" class="input-candy" placeholder="Brief note about your project...">{{ old('link_note', $existingSubmission->link_note ?? '') }}</textarea>
                @error('link_note') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>
            @endif

            @if($assignment->acceptsFiles())
            <div class="mb-6">
                <label class="block font-black text-sm text-cream mb-2">Upload Files (max 3)</label>
                <input type="file" name="files[]" multiple
                       class="block w-full text-sm text-cream/70 file:mr-4 file:py-2.5 file:px-5 file:rounded-xl file:border-2 file:border-space file:text-sm file:font-black file:bg-gold file:text-space hover:file:bg-cream transition-all"
                       accept=".pdf,.docx,.pptx,.xlsx,.jpg,.jpeg,.png,.zip" id="file-input">
                @error('files') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
                @error('files.*') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
                <p class="text-xs text-cream/45 font-bold mt-2">Accepted: PDF, DOCX, PPTX, XLSX, JPG, PNG, ZIP — max 25MB each, 3 files max</p>
                <div id="file-list" class="mt-3 space-y-2"></div>
            </div>
            @endif

            @if($assignment->acceptsFiles())
            <div class="mb-6">
                <label class="block font-black text-sm text-cream mb-2">Notes (optional)</label>
                <textarea name="submission_text" rows="4" class="input-candy" placeholder="Add a note about your submission...">{{ old('submission_text', $existingSubmission->submission_text ?? '') }}</textarea>
                @error('submission_text') <p class="text-terra text-xs font-bold mt-1">{{ $message }}</p> @enderror
            </div>
            @endif

            <button type="submit" class="btn-candy bg-mint w-full justify-center">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 19V5m0 0l-7 7m7-7l7 7"/></svg>
                {{ $existingSubmission ? 'Update Submission' : 'Submit Project' }}
            </button>
        </form>
    </div>

    {{-- Previous Submission --}}
    @if($existingSubmission)
    <div class="candy-card hard-shadow p-6 sm:p-8 mt-6 reveal" data-delay="140">
        <h2 class="font-display font-extrabold text-lg text-cream mb-4">Your Submission</h2>

        @if($existingSubmission->link_url)
            <div class="p-4 rounded-2xl bg-sky/10 border-2 border-sky/20 mb-4">
                <div class="text-xs font-black text-cream/50 mb-1">PROJECT LINK</div>
                <a href="{{ $existingSubmission->link_url }}" target="_blank" class="text-sm text-mint hover:underline break-all font-black">{{ $existingSubmission->link_url }}</a>
                @if($existingSubmission->link_note)
                    <p class="text-xs text-cream/50 mt-2 font-bold">{{ $existingSubmission->link_note }}</p>
                @endif
            </div>
        @endif

        @if($existingSubmission->submission_text)
            <div class="p-4 rounded-2xl bg-surface/60 border-2 border-cream/10 mb-4">
                <p class="text-sm text-cream/70 whitespace-pre-wrap font-semibold">{{ $existingSubmission->submission_text }}</p>
            </div>
        @endif

        @if($existingSubmission->files && $existingSubmission->files->count())
            <div class="mb-4">
                <div class="text-xs font-black text-cream/50 mb-2">ATTACHED FILES</div>
                @foreach($existingSubmission->files as $file)
                    <a href="{{ Storage::url($file->file_path) }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-black text-mint hover:underline mr-4 mb-2">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        {{ $file->file_name }} <span class="text-cream/40 font-bold">({{ round($file->file_size / 1024) }}KB)</span>
                    </a>
                @endforeach
            </div>
        @elseif($existingSubmission->file_url)
            <div class="mb-4">
                <a href="{{ $existingSubmission->file_url }}" target="_blank" class="inline-flex items-center gap-2 text-sm font-black text-mint hover:underline">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        View Attached File
                </a>
            </div>
        @endif

        @if($existingSubmission->score !== null)
        <div class="mt-4 p-4 rounded-2xl bg-gold/10 border-2 border-gold/25">
            <div class="flex items-center gap-3">
                <span class="font-display font-extrabold text-xl text-gold">{{ $existingSubmission->score }}/{{ $assignment->max_score }}</span>
                <div class="flex-1 h-2 rounded-full bg-cream/10 overflow-hidden border border-cream/15">
                    <div class="h-full rounded-full bg-gold" style="width:{{ ($existingSubmission->score / $assignment->max_score) * 100 }}%"></div>
                </div>
            </div>
            @if($existingSubmission->feedback)
            <p class="text-sm text-cream/70 mt-3 font-bold">Feedback: {{ $existingSubmission->feedback }}</p>
            @endif
        </div>
        @endif
    </div>
    @endif

    {{-- Version History --}}
    @if($allVersions && $allVersions->count() > 1)
    <div class="candy-card hard-shadow p-6 sm:p-8 mt-6 reveal" data-delay="180">
        <h2 class="font-display font-extrabold text-lg text-cream mb-4">Submission History</h2>
        <div class="space-y-3">
            @foreach($allVersions as $v)
                <div class="flex items-center gap-4 p-3 rounded-2xl bg-surface/60 border-2 border-cream/10 text-sm font-bold">
                    <span class="font-black text-mint">v{{ $v->version }}</span>
                    <span class="text-cream/50">{{ $v->submitted_at->diffForHumans() }}</span>
                    @if($v->submitted_late)
                        <span class="px-2 py-0.5 rounded-lg bg-terra/15 text-terra text-xs font-black">LATE</span>
                    @endif
                    @if($v->score !== null)
                        <span class="font-black text-gold">{{ $v->score }}/{{ $assignment->max_score }}</span>
                    @endif
                    @if($v->files && $v->files->count())
                        <span class="text-cream/45 text-xs">{{ $v->files->count() }} file(s)</span>
                    @endif
                    @if($v->link_url)
                        <a href="{{ $v->link_url }}" target="_blank" class="text-mint text-xs">link</a>
                    @endif
                </div>
            @endforeach
        </div>
    </div>
    @endif

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
            div.className = 'flex items-center gap-2 text-xs text-cream/60 font-bold';
            div.innerHTML = `<svg class="w-3 h-3 text-mint" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg> ${f.name} <span class="text-cream/30">(${size}KB)</span>`;
            fileList.appendChild(div);
        });
        if (fileInput.files.length > 3) {
            const warn = document.createElement('div');
            warn.className = 'text-xs text-terra font-black';
            warn.textContent = 'Max 3 files allowed — extra files will be ignored.';
            fileList.appendChild(warn);
        }
    });
});
</script>
@endpush
@endsection
