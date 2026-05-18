<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use Illuminate\Http\Request;

class ChildController extends Controller
{
    public function index(Request $request)
    {
        $query = ChildProfile::with('parent');

        if ($request->filled('search')) {
            $query->where('name', 'like', "%{$request->search}%");
        }

        if ($request->filled('rank')) {
            $query->where('rank', $request->rank);
        }

        $children = $query->orderByDesc('xp')->paginate(25)->withQueryString();

        return view('admin.children.index', compact('children'));
    }

    public function show(ChildProfile $child)
    {
        $child->load(['parent', 'enrollments.course.club', 'xpLogs' => fn($q) => $q->latest()->take(20)]);
        return view('admin.children.show', compact('child'));
    }

    public function awardXp(Request $request, ChildProfile $child)
    {
        $data = $request->validate([
            'amount'   => 'required|integer|min:1|max:500',
            'activity' => 'required|string|max:100',
        ]);

        $child->awardXp($data['amount'], $data['activity']);

        return back()->with('success', "{$data['amount']} XP awarded to {$child->name} for \"{$data['activity']}\".");
    }

    public function destroy(ChildProfile $child)
    {
        $name = $child->name;
        $child->delete();
        return redirect()->route('admin.children.index')
            ->with('success', "Profile \"{$name}\" removed.");
    }
}
