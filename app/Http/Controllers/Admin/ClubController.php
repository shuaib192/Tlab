<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ClubController extends Controller
{
    public function index()
    {
        $clubs = Club::withCount('courses')->latest()->paginate(20);
        return view('admin.clubs.index', compact('clubs'));
    }

    public function create()
    {
        return view('admin.clubs.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'color_theme' => 'required|string|max:7',
            'icon'        => 'nullable|string|max:50',
            'min_age'     => 'nullable|integer|min:1|max:18',
            'max_age'     => 'nullable|integer|min:1|max:18',
        ]);

        $data['slug'] = Str::slug($data['name']);

        Club::create($data);

        return redirect()->route('admin.clubs.index')
            ->with('success', "Club \"{$data['name']}\" created successfully.");
    }

    public function edit(Club $club)
    {
        return view('admin.clubs.edit', compact('club'));
    }

    public function update(Request $request, Club $club)
    {
        $data = $request->validate([
            'name'        => 'required|string|max:100',
            'description' => 'nullable|string',
            'color_theme' => 'required|string|max:7',
            'icon'        => 'nullable|string|max:50',
            'min_age'     => 'nullable|integer|min:1|max:18',
            'max_age'     => 'nullable|integer|min:1|max:18',
        ]);

        $data['slug'] = Str::slug($data['name']);

        $club->update($data);

        return redirect()->route('admin.clubs.index')
            ->with('success', "Club \"{$club->name}\" updated.");
    }

    public function destroy(Club $club)
    {
        $name = $club->name;
        $club->delete();
        return redirect()->route('admin.clubs.index')
            ->with('success', "Club \"{$name}\" deleted.");
    }
}
