@extends('layouts.admin')
@section('title', "Govern Program: {$program->name}")
@section('content')

<div class="flex items-center gap-3 mb-6">
    <a href="{{ route('admin.programs.index') }}" class="btn-secondary text-xs font-mono">
        &larr; All Protocols
    </a>
    <span class="text-cream/30">/</span>
    <span class="text-cream/60 font-mono text-xs uppercase">// Control Deck // {{ $program->name }}</span>
</div>

{{-- PROGRAM SPEC CARD --}}
<div class="card p-6 sm:p-8 border-2 rounded-2xl mb-10 shadow-[8px_8px_0px_rgba(0,0,0,0.6)]"
     style="border-color: {{ $program->color }}55;">
    <div class="flex items-start justify-between gap-4 mb-6">
        <div class="flex items-center gap-3">
            <div class="w-12 h-12 rounded-xl flex items-center justify-center font-display font-black text-2xl border-2"
                 style="background: {{ $program->color }}18; border-color: {{ $program->color }}; color: {{ $program->color }};">
                {{ strtoupper(substr($program->name, 0, 1)) }}
            </div>
            <div>
                <h1 class="font-display text-2xl sm:text-3xl font-black text-cream tracking-tight">{{ $program->name }}</h1>
                <span class="font-mono text-xs text-cream/40">DISCIPLINE: {{ strtoupper($program->discipline) }} &middot; /programs/{{ $program->slug }}</span>
            </div>
        </div>
        <a href="{{ route('programs.show', $program->slug) }}" target="_blank"
           class="btn-secondary text-xs font-mono flex-shrink-0">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 6H6a2 2 0 00-2 2v10a2 2 0 002 2h10a2 2 0 002-2v-4M14 4h6m0 0v6m0-6L10 14"/></svg>
            View Live Page
        </a>
    </div>

    <form method="POST" action="{{ route('admin.programs.update', $program) }}" class="space-y-6">
        @csrf @method('PUT')

        <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
            <div>
                <label class="label font-mono">Program Designation</label>
                <input type="text" name="name" value="{{ old('name', $program->name) }}" required class="input font-semibold">
            </div>
            <div>
                <label class="label font-mono">STEAM Core Discipline</label>
                <select name="discipline" class="input font-semibold">
                    @foreach(['science','technology','engineering','arts','mathematics'] as $d)
                        <option value="{{ $d }}" {{ old('discipline', $program->discipline) === $d ? 'selected' : '' }}>{{ ucfirst($d) }}</option>
                    @endforeach
                </select>
            </div>
        </div>

        <div>
            <label class="label font-mono">Tactical Slogan / Mission Hook</label>
            <input type="text" name="tagline" value="{{ old('tagline', $program->tagline) }}" class="input">
        </div>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
            <div>
                <label class="label font-mono">Primary Spectrum</label>
                <div class="flex items-center gap-3">
                    <input type="color" id="colorPicker" value="{{ old('color', $program->color) }}"
                           oninput="document.getElementById('colorInput').value = this.value"
                           class="w-10 h-10 rounded border-0 bg-transparent cursor-pointer">
                    <input type="text" name="color" id="colorInput" value="{{ old('color', $program->color) }}" required
                           oninput="document.getElementById('colorPicker').value = this.value"
                           class="input font-mono uppercase text-xs">
                </div>
            </div>
            <div>
                <label class="label font-mono">Target Age Span</label>
                <input type="text" name="ages" value="{{ old('ages', $program->ages) }}" required class="input font-mono text-xs">
            </div>
            <div>
                <label class="label font-mono">Sequence Order Weight</label>
                <input type="number" name="sort_order" value="{{ old('sort_order', $program->sort_order) }}" class="input font-mono text-xs">
            </div>
        </div>

        <div>
            <label class="label font-mono">Program Manifesto / Description</label>
            <textarea name="description" rows="4" class="input font-sans text-sm leading-relaxed">{{ old('description', $program->description) }}</textarea>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-white/5">
            <div>
                <label class="label font-mono text-xs">What They Learn (1 per line)</label>
                <textarea name="what_learn" rows="5" class="input font-mono text-xs">{{ old('what_learn', is_array($program->what_learn) ? implode("\n", $program->what_learn) : '') }}</textarea>
            </div>
            <div>
                <label class="label font-mono text-xs">Key Outcomes (1 per line)</label>
                <textarea name="outcomes" rows="5" class="input font-mono text-xs">{{ old('outcomes', is_array($program->outcomes) ? implode("\n", $program->outcomes) : '') }}</textarea>
            </div>
            <div>
                <label class="label font-mono text-xs">Career Trajectories (1 per line)</label>
                <textarea name="career_paths" rows="5" class="input font-mono text-xs">{{ old('career_paths', is_array($program->career_paths) ? implode("\n", $program->career_paths) : '') }}</textarea>
            </div>
        </div>

        <div class="flex items-center gap-3">
            <input type="checkbox" name="is_active" id="is_active" value="1" {{ $program->is_active ? 'checked' : '' }}
                   class="w-4 h-4 rounded border-white/20 bg-surface text-mint focus:ring-mint">
            <label for="is_active" class="font-mono text-xs text-cream/70 cursor-pointer">Broadcast Live to Public Registry</label>
        </div>

        <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/10">
            <button type="submit" class="btn-primary font-mono text-xs uppercase tracking-wider px-8 shadow-[3px_3px_0px_#000]">
                Save Program Specifications
            </button>
        </div>
    </form>
</div>

{{-- GROWTH LINE NODES CARD --}}
<div class="card p-6 sm:p-8 border-2 rounded-2xl shadow-[8px_8px_0px_rgba(0,0,0,0.6)]"
     style="border-color: {{ $program->color }}55;">
    <div class="flex flex-col sm:flex-row sm:items-center justify-between gap-4 mb-2">
        <div>
            <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md mb-3 font-mono text-xs font-bold uppercase tracking-widest"
                 style="background: {{ $program->color }}1a; border: 1px solid {{ $program->color }}66; color: {{ $program->color }};">
                <span class="w-2 h-2 rounded-full animate-pulse" style="background: {{ $program->color }};"></span>
                // GROWTH LINE //
            </div>
            <h2 class="font-display text-2xl font-black text-cream">Development Conduit — Ages {{ $program->ages }}</h2>
            <p class="text-cream/50 text-xs mt-1 font-mono">Each node calibrates a distinct evolutionary phase. Reorder via Sequence Weight.</p>
        </div>
        <span class="badge badge-green font-mono text-xs">
            {{ $program->growthStages->count() }} Nodes Active
        </span>
    </div>

    {{-- Stage Conduit Visual --}}
    @if($program->growthStages->count())
    <div class="flex items-center gap-1 mb-8 mt-6">
        @foreach($program->growthStages as $index => $stage)
            <div class="flex-1 flex flex-col items-center gap-2">
                <div class="w-full h-2 rounded-sm {{ $index > 0 ? 'ml-1' : '' }}"
                     style="background: linear-gradient(90deg, {{ $program->color }}88, {{ $program->color }});"></div>
                <span class="w-6 h-6 rounded-full flex items-center justify-center font-mono text-[10px] font-black text-ink border-2"
                      style="background: {{ $program->color }}; border-color: {{ $program->color }};">
                    {{ $index + 1 }}
                </span>
                <span class="font-mono text-[9px] uppercase tracking-wider text-cream/40 truncate w-full text-center">{{ $stage->age_band }}</span>
            </div>
        @endforeach
    </div>
    @endif

    {{-- Existing Stage Node Editors --}}
    <div class="space-y-5">
        @forelse($program->growthStages as $stage)
        <div class="rounded-xl border-2 overflow-hidden"
             style="border-color: {{ $program->color }}33; background: rgba(250,245,232,0.02);">
            <div class="px-6 py-4 flex items-center justify-between gap-4"
                 style="background: {{ $program->color }}14;">
                <div class="flex items-center gap-3">
                    <div class="w-9 h-9 rounded-lg flex items-center justify-center font-mono font-black text-sm text-ink"
                         style="background: {{ $program->color }};">
                        {{ $loop->iteration }}
                    </div>
                    <div>
                        <span class="font-display font-bold text-cream">{{ $stage->stage_name }}</span>
                        <span class="text-xs font-mono text-cream/40 ml-2">{{ $stage->age_band }}</span>
                    </div>
                </div>
                <form method="POST" action="{{ route('admin.programs.stages.destroy', $stage) }}"
                      onsubmit="return confirm('Decommission Growth Line node [{{ addslashes($stage->stage_name) }}]?')">
                    @csrf @method('DELETE')
                    <button class="btn-danger text-xs p-2 rounded-lg" title="Decommission node">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/></svg>
                    </button>
                </form>
            </div>

            <form method="POST" action="{{ route('admin.programs.stages.update', $stage) }}" class="px-6 py-6 space-y-5">
                @csrf @method('PUT')

                <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                    <div>
                        <label class="label font-mono text-xs">Node Designation (Stage Name)</label>
                        <input type="text" name="stage_name" value="{{ $stage->stage_name }}" required class="input">
                    </div>
                    <div>
                        <label class="label font-mono text-xs">Age Band Label</label>
                        <input type="text" name="age_band" value="{{ $stage->age_band }}" required class="input font-mono text-xs">
                    </div>
                    <div>
                        <label class="label font-mono text-xs">Focus Title / Theme</label>
                        <input type="text" name="focus_title" value="{{ $stage->focus_title }}" class="input">
                    </div>
                </div>

                <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                    <div>
                        <label class="label font-mono text-xs">Min Age</label>
                        <input type="number" name="min_age" value="{{ $stage->min_age }}" min="1" max="20" class="input font-mono text-xs">
                    </div>
                    <div>
                        <label class="label font-mono text-xs">Max Age</label>
                        <input type="number" name="max_age" value="{{ $stage->max_age }}" min="1" max="25" class="input font-mono text-xs">
                    </div>
                    <div>
                        <label class="label font-mono text-xs">Sequence Weight</label>
                        <input type="number" name="sort_order" value="{{ $stage->sort_order }}" class="input font-mono text-xs">
                    </div>
                </div>

                <div>
                    <label class="label font-mono text-xs">Node Description / Mission Brief</label>
                    <textarea name="description" rows="3" class="input font-sans text-sm leading-relaxed">{{ $stage->description }}</textarea>
                </div>

                <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                    <div>
                        <label class="label font-mono text-xs">Abilities Gained (1 per line)</label>
                        <textarea name="skills" rows="4" class="input font-mono text-xs">{{ is_array($stage->skills) ? implode("\n", $stage->skills) : '' }}</textarea>
                    </div>
                    <div>
                        <label class="label font-mono text-xs">Milestones (1 per line)</label>
                        <textarea name="milestones" rows="4" class="input font-mono text-xs">{{ is_array($stage->milestones) ? implode("\n", $stage->milestones) : '' }}</textarea>
                    </div>
                    <div>
                        <label class="label font-mono text-xs">Tools &amp; Instruments (1 per line)</label>
                        <textarea name="tools_used" rows="4" class="input font-mono text-xs">{{ is_array($stage->tools_used) ? implode("\n", $stage->tools_used) : '' }}</textarea>
                    </div>
                </div>

                <div>
                    <label class="label font-mono text-xs">Flagship Project (Showcase)</label>
                    <input type="text" name="featured_project" value="{{ $stage->featured_project }}" class="input">
                </div>

                <div class="flex justify-end pt-2 border-t border-white/5">
                    <button type="submit" class="btn-primary font-mono text-xs uppercase tracking-wider px-6 shadow-[3px_3px_0px_#000]"
                            style="background: linear-gradient(135deg, {{ $program->color }}, {{ $program->color }}99);">
                        Recalibrate Node
                    </button>
                </div>
            </form>
        </div>
        @empty
        <div class="text-center py-12 border-2 border-dashed rounded-2xl" style="border-color: {{ $program->color }}44;">
            <p class="text-cream/40 font-mono text-sm mb-4">// NO GROWTH NODES ENGINEERED YET //</p>
        </div>
        @endforelse
    </div>

    {{-- ENGINEER NEW STAGE FORM --}}
    <div class="mt-8 pt-8 border-t-2 border-dashed" style="border-color: {{ $program->color }}33;">
        <div class="inline-flex items-center gap-2 px-3 py-1 rounded-md mb-4 font-mono text-xs font-bold uppercase tracking-widest"
             style="background: {{ $program->color }}1a; border: 1px solid {{ $program->color }}66; color: {{ $program->color }};">
            <svg class="w-3 h-3" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/></svg>
            ENGINEER NEW GROWTH NODE
        </div>

        <form method="POST" action="{{ route('admin.programs.stages.store', $program) }}" class="space-y-5">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-4">
                <div>
                    <label class="label font-mono text-xs">Node Designation (Stage Name)</label>
                    <input type="text" name="stage_name" placeholder="e.g. Quantum Explorers" required class="input">
                </div>
                <div>
                    <label class="label font-mono text-xs">Age Band Label</label>
                    <input type="text" name="age_band" placeholder="Ages 9–11" required class="input font-mono text-xs">
                </div>
                <div>
                    <label class="label font-mono text-xs">Focus Title / Theme</label>
                    <input type="text" name="focus_title" placeholder="e.g. Neural Interfaces & Machine Logic" class="input">
                </div>
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-4">
                <div>
                    <label class="label font-mono text-xs">Min Age</label>
                    <input type="number" name="min_age" min="1" max="20" value="3" class="input font-mono text-xs">
                </div>
                <div>
                    <label class="label font-mono text-xs">Max Age</label>
                    <input type="number" name="max_age" min="1" max="25" value="5" class="input font-mono text-xs">
                </div>
                <div>
                    <label class="label font-mono text-xs">Sequence Weight</label>
                    <input type="number" name="sort_order" value="{{ $program->growthStages->count() + 1 }}" class="input font-mono text-xs">
                </div>
            </div>

            <div>
                <label class="label font-mono text-xs">Node Description / Mission Brief</label>
                <textarea name="description" rows="3" class="input font-sans text-sm leading-relaxed"></textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                <div>
                    <label class="label font-mono text-xs">Abilities Gained (1 per line)</label>
                    <textarea name="skills" rows="4" class="input font-mono text-xs"></textarea>
                </div>
                <div>
                    <label class="label font-mono text-xs">Milestones (1 per line)</label>
                    <textarea name="milestones" rows="4" class="input font-mono text-xs"></textarea>
                </div>
                <div>
                    <label class="label font-mono text-xs">Tools &amp; Instruments (1 per line)</label>
                    <textarea name="tools_used" rows="4" class="input font-mono text-xs"></textarea>
                </div>
            </div>

            <div>
                <label class="label font-mono text-xs">Flagship Project (Showcase)</label>
                <input type="text" name="featured_project" placeholder="e.g. 'Solar-powered Mars rover prototype'" class="input">
            </div>

            <div class="flex justify-end pt-2 border-t border-white/5">
                <button type="submit" class="btn-primary font-mono text-xs uppercase tracking-wider px-8 shadow-[3px_3px_0px_#000]"
                        style="background: linear-gradient(135deg, {{ $program->color }}, {{ $program->color }}99);">
                    Engineer Node &rarr;
                </button>
            </div>
        </form>
    </div>
</div>

@endsection