<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ClassSession;
use App\Models\Streak;
use App\Models\XpLog;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $children = $user->children()
            ->withCount(['enrollments' => fn ($q) => $q->where('status', 'active')])
            ->with(['enrollments.course.club'])
            ->latest()
            ->get();

        $totalXp = $children->sum('xp');
        $totalCourses = $children->sum('enrollments_count');
        $childIds = $children->pluck('id');

        // Streaks
        $streaks = Streak::whereIn('child_profile_id', $childIds)->get()->keyBy('child_profile_id');

        // XP trend (last 7 days per child)
        $xpTrend = [];
        foreach ($children as $child) {
            $dailyXp = XpLog::where('child_profile_id', $child->id)
                ->where('created_at', '>=', now()->subDays(7))
                ->selectRaw('DATE(created_at) as date, SUM(amount) as total')
                ->groupBy('date')
                ->orderBy('date')
                ->pluck('total', 'date');
            $xpTrend[$child->id] = $dailyXp;
        }

        // Attendance rate (last 30 days)
        $totalSessions = ClassSession::whereIn('cohort_id', function ($q) use ($childIds) {
            $q->select('cohort_id')->from('enrollments')->whereIn('child_profile_id', $childIds);
        })->where('date', '>=', now()->subDays(30))->count();

        $attended = Attendance::whereIn('child_profile_id', $childIds)
            ->where('status', 'present')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $attendanceRate = $totalSessions > 0 ? round(($attended / $totalSessions) * 100) : null;

        // Course completion stats
        $courseCompletions = [];
        foreach ($children as $child) {
            $total = $child->enrollments()->count();
            $completed = $child->enrollments()->where('status', 'completed')->count();
            $courseCompletions[$child->id] = ['total' => $total, 'completed' => $completed, 'rate' => $total > 0 ? round(($completed / $total) * 100) : 0];
        }

        // Upcoming sessions
        $upcomingSessions = ClassSession::with(['course.club', 'cohort'])
            ->whereIn('cohort_id', function ($q) use ($childIds) {
                $q->select('cohort_id')->from('enrollments')->whereIn('child_profile_id', $childIds);
            })
            ->where('date', '>=', now()->toDateString())
            ->where('date', '<=', now()->addDays(7)->toDateString())
            ->where('status', 'scheduled')
            ->orderBy('date')->orderBy('start_time')
            ->get()
            ->map(fn ($s) => [
                'id' => $s->id, 'title' => $s->title ?? $s->course?->title.' Session',
                'date' => $s->date, 'start_time' => $s->start_time,
                'club_name' => $s->course?->club?->name,
                'club_color' => $s->course?->club?->color_theme ?? '#16A34A',
                'course' => $s->course?->title,
            ]);

        // Recent activity
        $recentActivity = XpLog::with('child')
            ->whereIn('child_profile_id', $childIds)
            ->latest()->take(10)->get();

        return view('parent.dashboard', compact(
            'user', 'children', 'totalXp', 'totalCourses',
            'attendanceRate', 'upcomingSessions', 'recentActivity',
            'streaks', 'xpTrend', 'courseCompletions'
        ));
    }
}
