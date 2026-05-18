<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $childId = session('active_child_id');
        if (!$childId) {
            return redirect()->route('parent.dashboard')->with('info', 'Please select a child to view their dashboard.');
        }

        $child = ChildProfile::with(['enrollments.course.club', 'xpLogs' => fn($q) => $q->latest()->take(5)])->findOrFail($childId);

        // Security: only owner parent can see
        if ($child->user_id !== auth()->id()) {
            abort(403);
        }

        $leaderboard = ChildProfile::orderByDesc('xp')
            ->take(10)
            ->get(['name', 'xp', 'rank', 'avatar']);

        return view('child.dashboard', compact('child', 'leaderboard'));
    }
}
