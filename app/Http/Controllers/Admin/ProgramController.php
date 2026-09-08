<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Program;
use App\Models\ProgramGrowthStage;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProgramController extends Controller
{
    public function index()
    {
        $programs = Program::withCount('growthStages')
            ->orderBy('sort_order')
            ->get();

        return view('admin.programs.index', compact('programs'));
    }

    public function create()
    {
        return view('admin.programs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'discipline' => 'required|string|in:science,technology,engineering,arts,mathematics',
            'tagline' => 'nullable|string|max:255',
            'ages' => 'required|string|max:30',
            'color' => 'required|string|max:30',
            'accent_color' => 'nullable|string|max:30',
            'gradient' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'what_learn' => 'nullable|string',
            'outcomes' => 'nullable|string',
            'career_paths' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['slug'] = Str::slug($data['name']);
        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        // Parse multiline text to clean arrays
        $data['what_learn'] = $this->parseLines($request->input('what_learn'));
        $data['outcomes'] = $this->parseLines($request->input('outcomes'));
        $data['career_paths'] = $this->parseLines($request->input('career_paths'));

        $program = Program::create($data);

        return redirect()->route('admin.programs.edit', $program)
            ->with('success', "Program \"{$program->name}\" materialized! Now configure its Growth Line stages.");
    }

    public function edit(Program $program)
    {
        $program->load(['growthStages' => function ($q) {
            $q->orderBy('sort_order')->orderBy('min_age');
        }]);

        return view('admin.programs.edit', compact('program'));
    }

    public function update(Request $request, Program $program)
    {
        $data = $request->validate([
            'name' => 'required|string|max:100',
            'discipline' => 'required|string|in:science,technology,engineering,arts,mathematics',
            'tagline' => 'nullable|string|max:255',
            'ages' => 'required|string|max:30',
            'color' => 'required|string|max:30',
            'accent_color' => 'nullable|string|max:30',
            'gradient' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'what_learn' => 'nullable|string',
            'outcomes' => 'nullable|string',
            'career_paths' => 'nullable|string',
            'sort_order' => 'nullable|integer',
            'is_active' => 'nullable|boolean',
        ]);

        $data['is_active'] = $request->has('is_active');
        $data['sort_order'] = $data['sort_order'] ?? 0;

        $data['what_learn'] = $this->parseLines($request->input('what_learn'));
        $data['outcomes'] = $this->parseLines($request->input('outcomes'));
        $data['career_paths'] = $this->parseLines($request->input('career_paths'));

        $program->update($data);

        return back()->with('success', "STEAM Program \"{$program->name}\" specifications updated.");
    }

    public function destroy(Program $program)
    {
        $name = $program->name;
        $program->delete();

        return redirect()->route('admin.programs.index')
            ->with('success', "Program \"{$name}\" removed from active curriculum.");
    }

    /**
     * Store new Growth Line stage for a Program
     */
    public function storeStage(Request $request, Program $program)
    {
        $data = $request->validate([
            'stage_name' => 'required|string|max:100',
            'age_band' => 'required|string|max:50',
            'min_age' => 'required|integer|min:1|max:20',
            'max_age' => 'required|integer|min:1|max:25',
            'focus_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'skills' => 'nullable|string',
            'milestones' => 'nullable|string',
            'tools_used' => 'nullable|string',
            'featured_project' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $data['program_id'] = $program->id;
        $data['sort_order'] = $data['sort_order'] ?? ($program->growthStages()->count() + 1);

        $data['skills'] = $this->parseLines($request->input('skills'));
        $data['milestones'] = $this->parseLines($request->input('milestones'));
        $data['tools_used'] = $this->parseLines($request->input('tools_used'));

        ProgramGrowthStage::create($data);

        return back()->with('success', "Growth Line node [{$data['stage_name']}] successfully engineered.");
    }

    /**
     * Update an existing Growth Line stage
     */
    public function updateStage(Request $request, ProgramGrowthStage $stage)
    {
        $data = $request->validate([
            'stage_name' => 'required|string|max:100',
            'age_band' => 'required|string|max:50',
            'min_age' => 'required|integer|min:1|max:20',
            'max_age' => 'required|integer|min:1|max:25',
            'focus_title' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'skills' => 'nullable|string',
            'milestones' => 'nullable|string',
            'tools_used' => 'nullable|string',
            'featured_project' => 'nullable|string|max:255',
            'sort_order' => 'nullable|integer',
        ]);

        $data['skills'] = $this->parseLines($request->input('skills'));
        $data['milestones'] = $this->parseLines($request->input('milestones'));
        $data['tools_used'] = $this->parseLines($request->input('tools_used'));

        $stage->update($data);

        return back()->with('success', "Growth stage [{$stage->stage_name}] calibrated.");
    }

    /**
     * Delete a Growth Line stage
     */
    public function destroyStage(ProgramGrowthStage $stage)
    {
        $name = $stage->stage_name;
        $stage->delete();

        return back()->with('success', "Growth Line node [{$name}] decommissioned.");
    }

    private function parseLines(?string $input): array
    {
        if (! $input) {
            return [];
        }

        return array_values(array_filter(
            array_map('trim', preg_split('/\r\n|\r|\n|,/', $input)),
            fn ($line) => $line !== ''
        ));
    }
}
