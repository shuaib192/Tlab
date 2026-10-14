@extends('layouts.admin')
@section('title', 'Enquiry')

@section('content')

<div class="flex items-center gap-3 mb-8">
    <a href="{{ route('admin.contact-messages.index') }}" class="btn-secondary">&larr; Back</a>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
    <div class="lg:col-span-2 space-y-6">
        <div class="card p-7">
            <div class="flex items-center gap-2 mb-1">
                <span class="badge badge-green">Enquiry</span>
                <span class="text-xs text-cream/40 font-semibold">{{ $contactMessage->created_at->format('j M Y, H:i') }}</span>
            </div>
            <h1 class="font-display text-2xl font-bold mb-6">{{ $contactMessage->subject }}</h1>
            <p class="text-cream/70 leading-relaxed whitespace-pre-line">{{ $contactMessage->message }}</p>
        </div>
    </div>

    <div class="space-y-6">
        <div class="card p-6">
            <h2 class="font-display font-bold text-lg mb-4">Sender</h2>
            <dl class="space-y-4 text-sm">
                <div>
                    <dt class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Name</dt>
                    <dd class="font-semibold text-cream">{{ $contactMessage->name }}</dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">Email</dt>
                    <dd><a href="mailto:{{ $contactMessage->email }}" class="font-semibold text-teal hover:underline">{{ $contactMessage->email }}</a></dd>
                </div>
                <div>
                    <dt class="text-xs font-bold text-cream/40 uppercase tracking-wider mb-1">IP Address</dt>
                    <dd class="font-mono text-xs text-cream/60">{{ $contactMessage->ip_address ?? 'Not recorded' }}</dd>
                </div>
            </dl>
        </div>

        <a href="mailto:{{ $contactMessage->email }}?subject={{ rawurlencode('Re: '.$contactMessage->subject) }}"
           class="btn-primary w-full justify-center">Reply by Email</a>
    </div>
</div>

@endsection