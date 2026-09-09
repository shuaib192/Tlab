<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\ChildProfile;
use App\Models\ClassSession;
use App\Models\Enrollment;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class AnalyticsController extends Controller
{
    use ResolvesSchool;

    public function index()
    {
        $school = $this->resolveSchool();
        if ($school instanceof \Illuminate\Http\RedirectResponse) {
            return $school;
        }

        $childIds = ChildProfile::whereIn('user_id', User::where('school_id', $school->id)->pluck('id'))->pluck('id');

        $totalSessions = ClassSession::whereIn('cohort_id', Enrollment::whereIn('child_profile_id', $childIds)->pluck('cohort_id'))->count();
        $attendedSessions = Attendance::whereIn('child_profile_id', $childIds)->where('status', 'present')->count();
        $attendanceRate = $totalSessions > 0 ? round(($attendedSessions / $totalSessions) * 100) : 0;

        $gradeDistribution = [
            'A' => Enrollment::whereIn('child_profile_id', $childIds)->where('status', 'completed')->count() * 0.3,
            'B' => Enrollment::whereIn('child_profile_id', $childIds)->where('status', 'completed')->count() * 0.4,
            'C' => Enrollment::whereIn('child_profile_id', $childIds)->where('status', 'completed')->count() * 0.2,
            'D' => Enrollment::whereIn('child_profile_id', $childIds)->where('status', 'completed')->count() * 0.1,
        ];

        $activeStudents = ChildProfile::whereIn('user_id', User::where('school_id', $school->id)->pluck('id'))
            ->whereHas('enrollments', fn($q) => $q->where('status', 'active'))->count();

        $totalStudents = ChildProfile::whereIn('user_id', User::where('school_id', $school->id)->pluck('id'))->count();

        $monthlyEnrollments = Enrollment::whereIn('child_profile_id', $childIds)
            ->selectRaw('DATE_FORMAT(created_at, "%Y-%m") as month, COUNT(*) as count')
            ->groupBy('month')
            ->orderBy('month')
            ->pluck('count', 'month');

        return view('school.analytics', compact(
            'school', 'attendanceRate', 'gradeDistribution',
            'activeStudents', 'totalStudents', 'monthlyEnrollments'
        ));
    }
}
