<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class ChildProfileController extends Controller
{
    public function index()
    {
        $children = auth()->user()->children()->latest()->get();

        return view('parent.children.index', compact('children'));
    }

    public function create()
    {
        return view('parent.children.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'nullable|string|max:50|unique:child_profiles,username',
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:male,female,prefer_not_to_say',
            'interests' => 'nullable|array',
            'skill_level' => 'nullable|in:beginner,intermediate,advanced',
            'pin' => 'nullable|digits:4',
            'pin_enabled' => 'nullable|boolean',
        ]);

        $child = auth()->user()->children()->create([
            'name' => $request->name,
            'username' => $request->username,
            'dob' => $request->dob,
            'gender' => $request->gender,
            'interests' => $request->interests ?? [],
            'skill_level' => $request->skill_level ?? 'beginner',
            'pin' => $request->pin ? Hash::make($request->pin) : null,
            'pin_enabled' => $request->boolean('pin_enabled'),
        ]);

        return redirect()->route('parent.dashboard')
            ->with('success', "🎉 {$child->name}'s profile has been created! Ready to explore TLab clubs.");
    }

    public function show(ChildProfile $child)
    {
        $this->authorizeChild($child);
        $xpLogs = $child->xpLogs()->latest()->take(10)->get();
        $enrollments = $child->enrollments()->with('course.club')->get();

        return view('parent.children.show', compact('child', 'xpLogs', 'enrollments'));
    }

    public function edit(ChildProfile $child)
    {
        $this->authorizeChild($child);

        return view('parent.children.edit', compact('child'));
    }

    public function update(Request $request, ChildProfile $child)
    {
        $this->authorizeChild($child);
        $request->validate([
            'name' => 'required|string|max:100',
            'username' => 'nullable|string|max:50|unique:child_profiles,username,'.$child->id,
            'dob' => 'required|date|before:today',
            'gender' => 'required|in:male,female,prefer_not_to_say',
            'interests' => 'nullable|array',
            'skill_level' => 'nullable|in:beginner,intermediate,advanced',
            'pin' => 'nullable|digits:4',
            'pin_enabled' => 'nullable|boolean',
        ]);

        $data = $request->only('name', 'username', 'dob', 'gender', 'interests', 'skill_level');
        if ($request->filled('pin')) {
            $data['pin'] = Hash::make($request->pin);
        }
        $child->update($data);
        $child->update(['pin_enabled' => $request->boolean('pin_enabled')]);

        return redirect()->route('parent.children.show', $child)
            ->with('success', 'Profile updated successfully.');
    }

    public function destroy(ChildProfile $child)
    {
        $this->authorizeChild($child);
        $name = $child->name;
        $child->delete();

        return redirect()->route('parent.dashboard')
            ->with('success', "{$name}'s profile has been removed.");
    }

    public function switchChild(ChildProfile $child)
    {
        $this->authorizeChild($child);
        session(['active_child_id' => $child->id]);

        return redirect()->route('child.dashboard');
    }

    protected function authorizeChild(ChildProfile $child)
    {
        if ($child->user_id !== auth()->id() && ! in_array(auth()->user()->role, ['admin', 'super_admin'])) {
            abort(403, 'Unauthorized action.');
        }
    }
}
