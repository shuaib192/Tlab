<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use App\Models\ChildProfile;
use App\Models\ClassSession;
use App\Models\Cohort;
use App\Models\CommunicationLog;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

    public function createAssignment(Course $course)
    {
        $this->authorizeTeach($course);
        $course->load('modules.lessons');

        return view('teacher.assignments-create', compact('course'));
    }

    public function storeAssignment(Request $request, Course $course)
    {
        $this->authorizeTeach($course);

        $data = $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'title' => 'required|string|max:255',
            'instructions' => 'nullable|string',
            'type' => 'required|in:text,file,both',
            'max_score' => 'required|integer|min:1|max:9999',
            'due_date' => 'nullable|date',
        ]);

        // Verify lesson belongs to this course
        $lesson = \App\Models\Lesson::findOrFail($data['lesson_id']);
        if ($lesson->module->course_id !== $course->id) {
            return back()->withErrors(['lesson_id' => 'Lesson does not belong to this course.']);
        }

        Assignment::create([
            'lesson_id' => $data['lesson_id'],
            'title' => $data['title'],
            'instructions' => $data['instructions'],
            'type' => $data['type'],
            'max_score' => $data['max_score'],
            'due_date' => $data['due_date'],
        ]);

        return redirect()->route('teacher.assignments', $course)
            ->with('success', 'Assignment created successfully.');
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
            'score' => 'required|numeric|min:0|max:'.$submission->assignment->max_score,
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

        if (! $enrolled) {
            return redirect()->back()->with('error', 'You can only award XP to students in your courses.');
        }

        $validated = $request->validate([
            'amount' => 'required|integer|min:1|max:1000',
            'activity' => 'required|string|max:255',
        ]);

        $child->awardXp($validated['amount'], $validated['activity']);

        return redirect()->back()->with('success', "Awarded {$validated['amount']} XP to {$child->name} for \"{$validated['activity']}\".");
    }

    public function communications()
    {
        $logs = CommunicationLog::where('teacher_id', auth()->id())
            ->with(['child', 'parent'])
            ->latest()
            ->paginate(20);

        return view('teacher.communications', compact('logs'));
    }

    public function sendCommunication(Request $request)
    {
        $validated = $request->validate([
            'child_profile_id' => 'required|exists:child_profiles,id',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
            'type' => 'required|in:general,feedback,concern',
        ]);

        $child = ChildProfile::findOrFail($validated['child_profile_id']);

        $log = CommunicationLog::create([
            'teacher_id' => auth()->id(),
            'parent_id' => $child->user_id,
            'child_profile_id' => $child->id,
            'subject' => $validated['subject'],
            'message' => $validated['message'],
            'type' => $validated['type'],
        ]);

        \App\Models\Notification::create([
            'user_id' => $child->user_id,
            'type' => 'teacher_communication',
            'title' => "Message from Teacher: {$validated['subject']}",
            'body' => Str::limit($validated['message'], 100),
            'icon' => '📝',
            'link' => route('communications.index'),
        ]);

        return redirect()->back()->with('success', 'Message sent to parent.');
    }

    private function authorizeTeach(Course $course)
    {
        if ($course->teacher_id !== auth()->id()) {
            abort(403, 'You do not have permission to access this course.');
        }
    }
}
