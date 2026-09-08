@extends('layouts.admin')
@section('title', 'STEAM Programs & Growth Lines')
@section('content')

{{-- Tactical Header --}}
<div class="flex flex-col lg:flex-row lg:items-center justify-between gap-6 mb-8 border-b border-white/10 pb-6">
    <div>
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md bg-mint/10 border border-mint/30 text-mint text-xs font-mono font-bold uppercase tracking-widest mb-3">
            <span class="w-2 h-2 rounded-full bg-mint animate-pulse"></span>
            // CURRICULUM ARCHITECTURE //
        </div>
        <h1 class="font-display text-3xl sm:text-4xl font-extrabold text-cream tracking-tight">
            STEAM Programs &amp; Growth Lines
        </h1>
        <p class="text-cream/50 text-sm mt-1 max-w-2xl font-mono">
            Directly governs all 5 foundational pillars [Science, Tech, Engineering, Arts, Math] and their calibrated 3–18 age progression conduits.
        </p>
    </div>
    <div class="flex items-center gap-3">
        <a href="{{ route('programs') }}" target="_blank" class="btn-secondary text-xs uppercase tracking-wider font-mono">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            Live Conduit
        </a>
        <a href="{{ route('admin.programs.create') }}" class="btn-primary text-xs uppercase tracking-wider font-mono shadow-[4px_4px_0px_#000]">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            Fabricate Program
        </a>
    </div>
</div>

{{-- STEAM Programs Grid: Bold, Weird, Lab-Specimen Style --}}
<div class="grid grid-cols-1 md:grid-cols-2 xl:grid-cols-3 gap-6">
    @forelse($programs as $program)
    <div class="relative bg-panel border-2 rounded-2xl p-6 transition-all duration-300 hover:-translate-y-1 hover:shadow-[6px_6px_0px_rgba(0,0,0,0.9)] flex flex-col justify-between"
         style="border-color: {{ $program->color }}; box-shadow: 4px 4px 0px {{ $program->color }}33;">

        {{-- Top specimen tape --}}
        <div class="absolute -top-3 right-6 px-3 py-0.5 rounded text-[10px] font-mono font-black uppercase tracking-widest text-ink shadow-sm"
             style="background: {{ $program->color }};">
            DISCIPLINE: {{ strtoupper($program->discipline) }}
        </div>

        <div>
            {{-- Program Title & Emblem --}}
            <div class="flex items-start justify-between gap-4 mb-4">
                <div class="flex items-center gap-3">
                    <div class="w-12 h-12 rounded-xl flex items-center justify-center font-display font-black text-xl flex-shrink-0 border-2"
                         style="background: {{ $program->color }}18; border-color: {{ $program->color }}; color: {{ $program->color }};">
                        {{ strtoupper(substr($program->name, 0, 1)) }}
                    </div>
                    <div>
                        <h2 class="font-display text-2xl font-black text-cream tracking-tight">{{ $program->name }}</h2>
                        <span class="text-xs font-mono text-cream/40">slug: /programs/{{ $program->slug }}</span>
                    </div>
                </div>
                <span class="badge {{ $program->is_active ? 'badge-green' : 'badge-red' }} font-mono text-[10px]">
                    {{ $program->is_active ? 'LIVE' : 'OFFLINE' }}
                </span>
            </div>

            {{-- Tagline --}}
            <div class="text-xs font-bold text-cream/80 italic mb-4 pb-3 border-b border-white/5" style="color: {{ $program->color }}">
                "{{ $program->tagline ?? 'No protocol slogan recorded.' }}"
            </div>

            {{-- Description Snippet --}}
            <p class="text-xs text-cream/60 leading-relaxed mb-6 font-sans">
                {{ Str::limit($program->description, 130) }}
            </p>

            {{-- Growth Line Telemetry --}}
            <div class="bg-surface rounded-xl p-4 border border-white/5 mb-6">
                <div class="flex items-center justify-between text-xs font-mono mb-2">
                    <span class="text-cream/40 uppercase tracking-wider">Growth Line Stages</span>
                    <span class="font-bold px-2 py-0.5 rounded text-ink" style="background: {{ $program->color }};">
                        {{ $program->growth_stages_count }} Stages (Ages {{ $program->ages }})
                    </span>
                </div>

                {{-- Visual stage conduit pips --}}
                <div class="flex items-center gap-1.5 mt-3">
                    @for($i = 1; $i <= max(5, $program->growth_stages_count); $i++)
                        <div class="flex-1 h-2 rounded-sm {{ $i <= $program->growth_stages_count ? '' : 'bg-white/5' }}"
                             style="{{ $i <= $program->growth_stages_count ? 'background:' . $program->color . ';' : '' }}"></div>
                    @endfor
                </div>
            </div>
        </div>

        {{-- Actions --}}
        <div class="pt-4 border-t border-white/5 flex items-center justify-between gap-3">
            <a href="{{ route('admin.programs.edit', $program) }}"
               class="btn-primary w-full justify-center text-xs font-mono font-bold tracking-wider uppercase py-2.5 shadow-[2px_2px_0px_#000]"
               style="background: {{ $program->color }}; color: #000;">
                Configure Growth Line &rarr;
            </a>

            <form method="POST" action="{{ route('admin.programs.destroy', $program) }}"
                  onsubmit="return confirm('WARNING: Decommission STEAM Program [{{ addslashes($program->name) }}] and all attached Growth Stages?')">
                @csrf @method('DELETE')
                <button type="submit" class="btn-danger p-2.5 rounded-lg text-xs" title="Decommission">
                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                </button>
            </form>
        </div>

    </div>
    @empty
    <div class="col-span-full py-16 text-center border-2 border-dashed border-white/10 rounded-2xl">
        <p class="text-cream/40 font-mono text-sm mb-4">// NO STEAM PROGRAM PROTOCOLS INITIALIZED //</p>
        <a href="{{ route('admin.programs.create') }}" class="btn-primary font-mono text-xs">Initialize First Program</a>
    </div>
    @endforelse
</div>

@endsection
