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
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $child = ChildProfile::with([
            'enrollments.course.club',
            'xpLogs' => fn($q) => $q->latest()->take(5),
        ])->findOrFail($childId);

        // Security: if parent-authenticated, verify ownership
        if (!session('child_authenticated') && $child->user_id !== auth()->id()) {
            abort(403);
        }

        $leaderboard = ChildProfile::orderByDesc('xp')
            ->take(10)
            ->get(['name', 'xp', 'rank', 'avatar']);

        $isChildAuth = session('child_authenticated', false);

        return view('child.dashboard', compact('child', 'leaderboard', 'isChildAuth'));
    }
}
