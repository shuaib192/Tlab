<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use App\Models\ChildProfile;
use App\Models\ClassSession;
use App\Models\Cohort;
use App\Models\Course;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        $courses = $user->taughtCourses()->withCount(['cohorts', 'enrollments'])->get();
        $courseIds = $courses->pluck('id');

        $upcomingSessions = ClassSession::whereIn('course_id', $courseIds)
            ->whereDate('date', '>=', now())
            ->with(['course', 'cohort'])
            ->orderBy('date')
            ->orderBy('start_time')
            ->take(10)
            ->get();

        $totalStudents = 0;
        $activeCohorts = 0;
        foreach ($courses as $course) {
            $totalStudents += $course->enrollments_count;
            $activeCohorts += $course->cohorts_count;
        }

        $todaySessions = ClassSession::whereIn('course_id', $courseIds)
            ->whereDate('date', now())
            ->with(['course', 'cohort'])
            ->orderBy('start_time')
            ->get();

        return view('teacher.dashboard', compact(
            'courses', 'upcomingSessions', 'totalStudents', 'activeCohorts', 'todaySessions'
        ));
    }

    public function course(Course $course)
    {
        $this->authorizeTeach($course);

        $course->loadCount(['cohorts', 'enrollments']);
        $cohorts = $course->cohorts()->withCount(['children', 'sessions'])->get();

        $assignments = Assignment::whereHas('lesson.module', function ($q) use ($course) {
            $q->where('course_id', $course->id);
        })->withCount('submissions')->get();

        return view('teacher.course', compact('course', 'cohorts', 'assignments'));
    }

    public function cohort(Cohort $cohort)
    {
        $this->authorizeTeach($cohort->course);

        $cohort->load(['course', 'children' => function ($q) {
            $q->with(['enrollments' => function ($q) use ($cohort) {
                $q->where('cohort_id', $cohort->id);
            }]);
        }]);

        $sessions = $cohort->sessions()->orderBy('date')->get();

        $attendanceSummary = [];
        foreach ($cohort->children as $child) {
            $present = $child->attendance()->whereIn('session_id', $sessions->pluck('id'))->where('status', 'present')->count();
            $total = $sessions->count();
            $attendanceSummary[$child->id] = $total > 0 ? round(($present / $total) * 100) : 0;
        }

        return view('teacher.cohort', compact('cohort', 'sessions', 'attendanceSummary'));
    }

    public function session(ClassSession $session)
    {
        $this->authorizeTeach($session->course);

        $session->load(['course', 'cohort', 'attendance.child']);

        $students = $session->cohort->children()->orderBy('name')->get();

        $attendanceMap = $session->attendance->keyBy('child_profile_id');

        return view('teacher.session', compact('session', 'students', 'attendanceMap'));
    }

    public function markAttendance(Request $request, ClassSession $session)
    {
        $this->authorizeTeach($session->course);

        $validated = $request->validate([
            'attendance' => 'required|array',
            'attendance.*.status' => 'required|in:present,absent,late,excused',
            'attendance.*.notes' => 'nullable|string|max:255',
        ]);

        foreach ($validated['attendance'] as $childId => $data) {
            Attendance::updateOrCreate(
                [
                    'session_id' => $session->id,
                    'child_profile_id' => $childId,
                ],
                [
                    'status' => $data['status'],
                    'notes' => $data['notes'] ?? null,
                    'marked_by' => auth()->id(),
                ]
            );
        }

        return redirect()->route('teacher.session', $session)
            ->with('success', 'Attendance saved successfully.');
    }

    public function assignments(Course $course)
    {
        $this->authorizeTeach($course);

        $course->load(['modules.lessons.assignments' => function ($q) {
            $q->withCount('submissions');
        }]);

        $assignments = collect();
        foreach ($course->modules as $module) {
            foreach ($module->lessons as $lesson) {
                foreach ($lesson->assignments as $a) {
                    $assignments->push($a);
                }
            }
        }

        return view('teacher.assignments', compact('course', 'assignments'));
    }

    public function grade(Assignment $assignment)
    {
        $course = $assignment->lesson->module->course;
        $this->authorizeTeach($course);

        $submissions = $assignment->submissions()->with('child')->get();

        return view('teacher.grade', compact('assignment', 'submissions'));
    }

    public function submitGrade(Request $request, AssignmentSubmission $submission)
    {
        $course = $submission->assignment->lesson->module->course;
        $this->authorizeTeach($course);

        $validated = $request->validate([
            'score' => 'required|numeric|min:0|max:' . $submission->assignment->max_score,
            'feedback' => 'nullable|string|max:2000',
            'status' => 'required|in:graded,approved,rejected',
        ]);

        $submission->update([
            'score' => $validated['score'],
            'feedback' => $validated['feedback'] ?? null,
            'status' => $validated['status'],
        ]);

        return redirect()->route('teacher.grade', $submission->assignment_id)
            ->with('success', 'Grade submitted successfully.');
    }

    public function awardXp(Request $request, ChildProfile $child)
    {
        // Verify the child is enrolled in at least one course taught by this teacher
        $taughtCourseIds = auth()->user()->taughtCourses()->pluck('id');
        $enrolled = $child->enrollments()->whereIn('course_id', $taughtCourseIds)->exists();

        if (!$enrolled) {
            return redirect()->back()->with('error', 'You can only award XP to students in your courses.');
        }

        $validated = $request->validate([
            'amount' => 'required|integer|min:1|max:1000',
            'activity' => 'required|string|max:255',
        ]);

        $child->awardXp($validated['amount'], $validated['activity']);

        return redirect()->back()->with('success', "Awarded {$validated['amount']} XP to {$child->name} for \"{$validated['activity']}\".");
    }

    private function authorizeTeach(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You do not have permission to access this course.');
        }
    }
}
