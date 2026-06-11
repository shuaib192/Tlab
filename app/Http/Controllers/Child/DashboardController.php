<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAttempt;
use App\Models\ChildProfile;

class DashboardController extends Controller
{
    public function index()
    {
        $childId = session('active_child_id');
        if (! $childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $child = ChildProfile::with([
            'enrollments.course.club',
            'enrollments.course.modules.lessons.assessment',
            'xpLogs' => fn ($q) => $q->latest()->take(5),
        ])->findOrFail($childId);

        // Security: if parent-authenticated, verify ownership (admins bypass)
        if (! session('child_authenticated') && $child->user_id !== auth()->id() && ! in_array(auth()->user()?->role, ['admin', 'super_admin'])) {
            abort(403);
        }

        $leaderboard = ChildProfile::orderByDesc('xp')
            ->take(10)
            ->get(['name', 'xp', 'rank', 'avatar']);

        $isChildAuth = session('child_authenticated', false);

        $completedAssessmentIds = AssessmentAttempt::where('child_profile_id', $child->id)
            ->where('status', 'passed')
            ->pluck('assessment_id')
            ->toArray();

        return view('child.dashboard', compact('child', 'leaderboard', 'isChildAuth', 'completedAssessmentIds'));
    }
}
