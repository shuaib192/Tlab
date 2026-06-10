@extends('layouts.app')

@section('title', 'Verify Certificate')

@section('content')
<div class="min-h-screen bg-gradient-to-br from-emerald-50 to-blue-50 flex items-center justify-center px-4 py-16">
    <div class="w-full max-w-2xl">
        <div class="bg-white rounded-3xl border-2 border-emerald-200 shadow-xl p-8 sm:p-12 text-center">
            <div class="w-16 h-16 rounded-full bg-emerald-100 flex items-center justify-center mx-auto mb-6">
                <svg class="w-8 h-8 text-emerald-600" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m6 2a9 9 0 11-18 0 9 9 0 0118 0z"/></svg>
            </div>
            <h1 class="font-black text-3xl text-emerald-700 mb-2">✓ Valid Certificate</h1>
            <p class="text-muted/70 mb-8">This certificate has been verified as authentic.</p>

            <div class="border-t border-gray-100 pt-8 space-y-4 text-left max-w-sm mx-auto">
                <div class="flex justify-between">
                    <span class="text-muted text-sm font-semibold">Certificate ID</span>
                    <span class="font-bold text-ink text-sm">{{ $certificate->certificate_id }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted text-sm font-semibold">Student</span>
                    <span class="font-bold text-ink text-sm">{{ $certificate->child->name }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted text-sm font-semibold">Course</span>
                    <span class="font-bold text-ink text-sm">{{ $certificate->course->title }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted text-sm font-semibold">Grade</span>
                    <span class="font-bold text-ink text-sm">{{ $certificate->grade ?? 'Pass' }}</span>
                </div>
                <div class="flex justify-between">
                    <span class="text-muted text-sm font-semibold">Issued</span>
                    <span class="font-bold text-ink text-sm">{{ $certificate->issued_at->format('F j, Y') }}</span>
                </div>
            </div>

            <div class="mt-8 pt-6 border-t border-gray-100">
                <p class="text-xs text-muted/50">Verified via TLab Certificate Verification System</p>
            </div>
        </div>
    </div>
</div>
@endsection
