<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\School;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class SchoolController extends Controller
{
    public function index()
    {
        $schools = School::withCount('licenses')->latest()->paginate(20);

        return view('admin.schools.index', compact('schools'));
    }

    public function create()
    {
        return view('admin.schools.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'nullable|email|max:255',
            'phone' => 'nullable|string|max:50',
            'address' => 'nullable|string|max:500',
            'city' => 'nullable|string|max:100',
            'state' => 'nullable|string|max:100',
            'country' => 'nullable|string|max:100',
            'max_students' => 'nullable|integer|min:1',
            'subscription_tier' => 'nullable|string|in:basic,premium,enterprise',
        ]);

        $validated['slug'] = Str::slug($validated['name']).'-'.Str::random(4);

        School::create($validated);

        return redirect()->route('admin.schools.index')->with('success', 'School created successfully.');
    }

    public function show(School $school)
    {
        $school->load('licenses');

        return view('admin.schools.show', compact('school'));
    }

    public function createLicense(Request $request, School $school)
    {
        $validated = $request->validate([
            'type' => 'required|string|in:annual,semester,quarterly',
            'seats' => 'required|integer|min:1',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after:start_date',
        ]);

        $school->licenses()->create($validated);

        return redirect()->route('admin.schools.show', $school)->with('success', 'License added.');
    }
}
