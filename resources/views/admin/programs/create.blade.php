@extends('layouts.admin')
@section('title', 'Fabricate STEAM Program')
@section('content')

<div class="max-w-4xl mx-auto">
    <div class="flex items-center gap-3 mb-6">
        <a href="{{ route('admin.programs.index') }}" class="btn-secondary text-xs font-mono">
            &larr; Back to Protocols
        </a>
        <span class="text-cream/30">/</span>
        <span class="text-cream/60 font-mono text-xs uppercase">// FABRICATE NEW PROGRAM //</span>
    </div>

    <div class="card p-6 sm:p-8 border-2 border-white/10 rounded-2xl shadow-[6px_6px_0px_rgba(0,0,0,0.5)]">
        <h1 class="font-display text-2xl sm:text-3xl font-black text-cream mb-2">
            Fabricate STEAM Program
        </h1>
        <p class="text-cream/50 text-xs font-mono mb-8">
            Specify technical coordinates, chromatic spectrum, and overarching mission before building the Growth Line nodes.
        </p>

        <form method="POST" action="{{ route('admin.programs.store') }}" class="space-y-6">
            @csrf

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label class="label font-mono">Program Designation (e.g. Science, Robotics)</label>
                    <input type="text" name="name" value="{{ old('name') }}" required
                           class="input font-semibold" placeholder="e.g. Technology">
                </div>

                <div>
                    <label class="label font-mono">STEAM Core Discipline</label>
                    <select name="discipline" class="input font-semibold" required>
                        <option value="science" {{ old('discipline') === 'science' ? 'selected' : '' }}>Science</option>
                        <option value="technology" {{ old('discipline', 'technology') === 'technology' ? 'selected' : '' }}>Technology</option>
                        <option value="engineering" {{ old('discipline') === 'engineering' ? 'selected' : '' }}>Engineering</option>
                        <option value="arts" {{ old('discipline') === 'arts' ? 'selected' : '' }}>Arts</option>
                        <option value="mathematics" {{ old('discipline') === 'mathematics' ? 'selected' : '' }}>Mathematics</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="label font-mono">Tactical Slogan / Mission Hook</label>
                <input type="text" name="tagline" value="{{ old('tagline') }}"
                       class="input" placeholder="e.g. Bend Silicon to Your Will. Build Autonomous Minds.">
            </div>

            <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">
                <div>
                    <label class="label font-mono">Primary Spectrum (HEX Color)</label>
                    <div class="flex items-center gap-3">
                        <input type="color" id="colorPicker" value="{{ old('color', '#00E5FF') }}"
                               oninput="document.getElementById('colorInput').value = this.value"
                               class="w-10 h-10 rounded border-0 bg-transparent cursor-pointer">
                        <input type="text" name="color" id="colorInput" value="{{ old('color', '#00E5FF') }}" required
                               oninput="document.getElementById('colorPicker').value = this.value"
                               class="input font-mono uppercase text-xs" placeholder="#00E5FF">
                    </div>
                </div>

                <div>
                    <label class="label font-mono">Target Age Span</label>
                    <input type="text" name="ages" value="{{ old('ages', '3–18') }}" required
                           class="input font-mono text-xs" placeholder="3–18">
                </div>

                <div>
                    <label class="label font-mono">Sequence Order Weight</label>
                    <input type="number" name="sort_order" value="{{ old('sort_order', 1) }}"
                           class="input font-mono text-xs">
                </div>
            </div>

            <div>
                <label class="label font-mono">Program Manifesto / Description</label>
                <textarea name="description" rows="4" class="input font-sans text-sm leading-relaxed"
                          placeholder="Describe the philosophical and practical core of this learning pillar...">{{ old('description') }}</textarea>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6 pt-4 border-t border-white/5">
                <div>
                    <label class="label font-mono text-xs">What They Learn (1 per line)</label>
                    <textarea name="what_learn" rows="5" class="input font-mono text-xs"
                              placeholder="Algorithmic logic&#10;Python scripts&#10;Computer vision...">{{ old('what_learn') }}</textarea>
                </div>

                <div>
                    <label class="label font-mono text-xs">Key Outcomes (1 per line)</label>
                    <textarea name="outcomes" rows="5" class="input font-mono text-xs"
                              placeholder="Publish mobile app&#10;Win robotics derby&#10;Deploy neural network...">{{ old('outcomes') }}</textarea>
                </div>

                <div>
                    <label class="label font-mono text-xs">Career Trajectories (1 per line)</label>
                    <textarea name="career_paths" rows="5" class="input font-mono text-xs"
                              placeholder="AI Systems Engineer&#10;Quantum Cryptographer&#10;Robotics Architect...">{{ old('career_paths') }}</textarea>
                </div>
            </div>

            <div class="flex items-center gap-3 pt-4">
                <input type="checkbox" name="is_active" id="is_active" value="1" checked
                       class="w-4 h-4 rounded border-white/20 bg-surface text-mint focus:ring-mint">
                <label for="is_active" class="font-mono text-xs text-cream/70 cursor-pointer">
                    Broadcast Program Live to Public Registry
                </label>
            </div>

            <div class="flex items-center justify-end gap-3 pt-6 border-t border-white/10">
                <a href="{{ route('admin.programs.index') }}" class="btn-secondary font-mono text-xs">Cancel</a>
                <button type="submit" class="btn-primary font-mono text-xs uppercase tracking-wider px-8 shadow-[3px_3px_0px_#000]">
                    Save &amp; Build Growth Line &rarr;
                </button>
            </div>
        </form>
    </div>
</div>

@endsection
