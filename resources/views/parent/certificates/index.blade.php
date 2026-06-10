@extends('layouts.parent')
@section('title', $child->name . ' — Certificates')

@section('parent-content')
<div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-8 sm:py-12">
    <div class="flex items-center justify-between mb-8">
        <div class="flex items-center gap-3">
            <div class="w-10 h-10 rounded-xl bg-gradient-to-br from-amber/10 to-primary/10 flex items-center justify-center">
                <svg class="w-5 h-5 text-amber" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
            </div>
            <div>
                <h1 class="font-black text-2xl text-ink">{{ $child->name }} — Certificates</h1>
                <p class="text-muted/70 text-sm">Download and verify course completion certificates</p>
            </div>
        </div>
        <a href="{{ route('parent.children.show', $child) }}" class="text-sm font-bold text-muted hover:text-ink transition-colors">← Back to Profile</a>
    </div>

    @if(session('success'))
        <div class="flex items-center gap-3 px-5 py-4 rounded-2xl bg-emerald-50 border border-emerald-200 text-emerald-700 font-bold text-sm mb-8">
            <svg class="w-5 h-5 flex-shrink-0" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/></svg>
            {{ session('success') }}
        </div>
    @endif

    @if($certificates->isEmpty())
    <div class="bg-white rounded-3xl border border-gray-100 shadow-sm p-12 text-center">
        <div class="w-20 h-20 rounded-3xl bg-gradient-to-br from-amber/10 to-primary/10 flex items-center justify-center mx-auto mb-5">
            <svg class="w-10 h-10 text-amber/60" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
        </div>
        <h2 class="font-black text-xl text-ink mb-2">No Certificates Yet</h2>
        <p class="text-muted text-sm mb-6 max-w-sm mx-auto">Certificates will appear here when {{ $child->name }} completes a course. You can also generate one manually from completed courses.</p>
    </div>
    @else
    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">
        @foreach($certificates as $cert)
        <div class="bg-white rounded-2xl border border-gray-100 shadow-sm overflow-hidden hover:shadow-lg transition-all duration-300 hover:-translate-y-1">
            <div class="h-2 bg-gradient-to-r from-primary to-accent"></div>
            <div class="p-6">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-primary/10 to-amber/10 flex items-center justify-center mb-4">
                    <svg class="w-6 h-6 text-primary" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4M7.835 4.697a3.42 3.42 0 001.946-.806 3.42 3.42 0 014.438 0 3.42 3.42 0 001.946.806 3.42 3.42 0 013.138 3.138 3.42 3.42 0 00.806 1.946 3.42 3.42 0 010 4.438 3.42 3.42 0 00-.806 1.946 3.42 3.42 0 01-3.138 3.138 3.42 3.42 0 00-1.946.806 3.42 3.42 0 01-4.438 0 3.42 3.42 0 00-1.946-.806 3.42 3.42 0 01-3.138-3.138 3.42 3.42 0 00-.806-1.946 3.42 3.42 0 010-4.438 3.42 3.42 0 00.806-1.946 3.42 3.42 0 013.138-3.138z"/></svg>
                </div>
                <h3 class="font-bold text-sm text-ink mb-1">{{ $cert->course->title ?? 'Course' }}</h3>
                <p class="text-xs text-muted mb-1">{{ $cert->type === 'completion' ? 'Completion Certificate' : $cert->type }}</p>
                <div class="flex items-center gap-2 text-xs text-muted mb-4">
                    <span>Grade: <strong class="text-ink">{{ $cert->grade ?? 'Pass' }}</strong></span>
                    <span class="w-1 h-1 rounded-full bg-gray-300"></span>
                    <span>{{ $cert->issued_at->format('M j, Y') }}</span>
                </div>
                <div class="flex gap-2">
                    <a href="{{ route('certificate.download', $cert) }}" class="flex-1 flex items-center justify-center gap-2 bg-primary text-white px-4 py-2.5 rounded-xl font-bold text-xs hover:bg-primary/90 transition-all">
                        <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
                        Download PDF
                    </a>
                    <a href="{{ route('certificate.verify', $cert->certificate_id) }}" target="_blank" class="px-4 py-2.5 rounded-xl border border-gray-200 text-muted text-xs font-bold hover:border-gray-300 transition-all">
                        Verify
                    </a>
                </div>
            </div>
        </div>
        @endforeach
    </div>
    @endif
</div>
@endsection
