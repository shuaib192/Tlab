<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();

        if ($user->isSuperAdmin()) {
            $schoolId = request('school_id');
            $school = $schoolId ? School::findOrFail($schoolId) : null;
        } else {
            $school = School::find($user->school_id);
        }

        if (!$school) {
            $schools = School::active()->get();
            return view('school.select', compact('schools'));
        }

        $activeStudents = ChildProfile::whereIn('user_id', User::where('school_id', $school->id)->pluck('id'))->count();
        $teachers = User::where('school_id', $school->id)->where('role', 'teacher')->count();
        $enrollments = Enrollment::whereIn('child_profile_id', ChildProfile::whereIn('user_id', User::where('school_id', $school->id)->pluck('id'))->pluck('id'))->count();
        $completions = Enrollment::whereIn('child_profile_id', ChildProfile::whereIn('user_id', User::where('school_id', $school->id)->pluck('id'))->pluck('id'))->where('status', 'completed')->count();
        $completionRate = $enrollments > 0 ? round(($completions / $enrollments) * 100) : 0;

        $completionsByCourse = Course::select('courses.id', 'courses.title')
            ->selectRaw('COUNT(enrollments.id) as total')
            ->selectRaw('SUM(CASE WHEN enrollments.status = "completed" THEN 1 ELSE 0 END) as completed')
            ->leftJoin('enrollments', 'courses.id', '=', 'enrollments.course_id')
            ->whereIn('enrollments.child_profile_id', function ($q) use ($school) {
                $q->select('id')->from('child_profiles')
                    ->whereIn('user_id', User::where('school_id', $school->id)->pluck('id'));
            })
            ->groupBy('courses.id', 'courses.title')
            ->get();

        $recentEnrollments = Enrollment::with(['child', 'course'])
            ->whereIn('child_profile_id', function ($q) use ($school) {
                $q->select('id')->from('child_profiles')
                    ->whereIn('user_id', User::where('school_id', $school->id)->pluck('id'));
            })
            ->latest()->take(10)->get();

        return view('school.dashboard', compact(
            'school', 'activeStudents', 'teachers', 'enrollments',
            'completionRate', 'completionsByCourse', 'recentEnrollments'
        ));
    }

    public function students(Request $request)
    {
        $user = auth()->user();
        $school = $user->isSuperAdmin()
            ? School::findOrFail($request->school_id)
            : School::find($user->school_id);

        $students = ChildProfile::whereIn('user_id', User::where('school_id', $school->id)->pluck('id'))
            ->with(['parent', 'enrollments.course', 'attendance'])
            ->when($request->search, fn($q, $s) => $q->where('name', 'like', "%{$s}%"))
            ->when($request->course_id, fn($q, $id) => $q->whereHas('enrollments', fn($e) => $e->where('course_id', $id)))
            ->latest()->paginate(20);

        $courses = Course::whereIn('id', Cohort::whereHas('enrollments.child', function ($q) use ($school) {
            $q->whereIn('user_id', User::where('school_id', $school->id)->pluck('id'));
        })->pluck('course_id'))->get();

        return view('school.students.index', compact('school', 'students', 'courses'));
    }
}
