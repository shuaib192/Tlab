<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use App\Models\Enrollment;
use App\Models\ClassSession;
use App\Models\Attendance;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $children = $user->children()
            ->withCount(['enrollments' => fn($q) => $q->where('status', 'active')])
            ->with(['enrollments.course.club'])
            ->latest()
            ->get();

        // Aggregate stats
        $totalXp       = $children->sum('xp');
        $totalCourses  = $children->sum('enrollments_count');
        $childIds      = $children->pluck('id');

        // Attendance rate (last 30 days)
        $totalSessions = ClassSession::whereIn('cohort_id', function ($q) use ($childIds) {
            $q->select('cohort_id')->from('enrollments')->whereIn('child_profile_id', $childIds);
        })->where('date', '>=', now()->subDays(30))->count();

        $attended = Attendance::whereIn('child_profile_id', $childIds)
            ->where('status', 'present')
            ->where('created_at', '>=', now()->subDays(30))
            ->count();

        $attendanceRate = $totalSessions > 0 ? round(($attended / $totalSessions) * 100) : null;

        // Upcoming sessions (next 7 days)
        $upcomingSessions = ClassSession::with(['course.club', 'cohort'])
            ->whereIn('cohort_id', function ($q) use ($childIds) {
                $q->select('cohort_id')->from('enrollments')->whereIn('child_profile_id', $childIds);
            })
            ->where('date', '>=', now()->toDateString())
            ->where('date', '<=', now()->addDays(7)->toDateString())
            ->where('status', 'scheduled')
            ->orderBy('date')->orderBy('start_time')
            ->get()
            ->map(fn($s) => [
                'id'         => $s->id,
                'title'      => $s->title ?? $s->course?->title . ' Session',
                'date'       => $s->date,
                'start_time' => $s->start_time,
                'club_name'  => $s->course?->club?->name,
                'club_color' => $s->course?->club?->color_theme ?? '#16A34A',
                'course'     => $s->course?->title,
            ]);

        // Recent activity across all children
        $recentActivity = \App\Models\XpLog::with('child')
            ->whereIn('child_profile_id', $childIds)
            ->latest()
            ->take(10)
            ->get();

        return view('parent.dashboard', compact(
            'user', 'children', 'totalXp', 'totalCourses',
            'attendanceRate', 'upcomingSessions', 'recentActivity'
        ));
    }
}
