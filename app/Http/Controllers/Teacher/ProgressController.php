<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\AssessmentAttempt;
use App\Models\AssignmentSubmission;
use App\Models\Attendance;
use App\Models\ChildProfile;
use App\Models\Course;
use App\Models\Enrollment;

class ProgressController extends Controller
{
    public function courseProgress(Course $course)
    {
        abort_unless($course->canBeManagedBy(auth()->user()), 403);

        $course->load(['modules.lessons.assessment', 'modules.lessons.assignments']);

        $enrollments = Enrollment::where('course_id', $course->id)
            ->with(['child' => function ($q) {
                $q->with(['assessmentAttempts', 'assignmentSubmissions', 'attendance']);
            }])
            ->get();

        $students = $enrollments->map(function ($enrollment) use ($course) {
            $child = $enrollment->child;
            $totalLessons = $course->modules->sum(fn ($m) => $m->lessons->count());
            $completedLessons = 0;

            foreach ($course->modules as $module) {
                foreach ($module->lessons as $lesson) {
                    if ($lesson->assessment) {
                        $passed = $child->assessmentAttempts
                            ->where('assessment_id', $lesson->assessment->id)
                            ->where('status', 'passed')
                            ->isNotEmpty();
                        if ($passed) {
                            $completedLessons++;
                        }
                    }
                }
            }

            $totalAssignments = $course->modules->sum(fn ($m) => $m->lessons->sum(fn ($l) => $l->assignments->count()));
            $gradedAssignments = $child->assignmentSubmissions
                ->whereIn('assignment_id', $course->modules->flatMap(fn ($m) => $m->lessons->flatMap(fn ($l) => $l->assignments->pluck('id'))))
                ->whereIn('status', ['graded', 'approved'])
                ->count();

            $avgScore = $child->assessmentAttempts
                ->whereIn('assessment_id', $course->modules->flatMap(fn ($m) => $m->lessons->flatMap(fn ($l) => $l->assessment?->id)))
                ->avg('score');

            $sessions = $course->cohorts()->with('sessions')->get()->flatMap->sessions;
            $totalSessions = $sessions->count();
            $attended = $child->attendance->whereIn('session_id', $sessions->pluck('id'))->where('status', 'present')->count();

            return [
                'child' => $child,
                'total_lessons' => $totalLessons,
                'completed_lessons' => $completedLessons,
                'progress_pct' => $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0,
                'total_assignments' => $totalAssignments,
                'graded_assignments' => $gradedAssignments,
                'avg_score' => $avgScore ? round($avgScore, 1) : '--',
                'attendance_pct' => $totalSessions > 0 ? round(($attended / $totalSessions) * 100) : 0,
            ];
        });

        $overallProgress = $students->avg('progress_pct');

        return view('teacher.progress', compact('course', 'students', 'overallProgress'));
    }

    public function studentProgress(Course $course, ChildProfile $child)
    {
        abort_unless($course->canBeManagedBy(auth()->user()), 403);

        $course->load(['modules.lessons.assessment', 'modules.lessons.assignments']);

        $moduleData = [];
        foreach ($course->modules as $module) {
            $lessonData = [];
            foreach ($module->lessons as $lesson) {
                $assessmentPassed = false;
                $assessmentScore = null;
                if ($lesson->assessment) {
                    $attempt = AssessmentAttempt::where('assessment_id', $lesson->assessment->id)
                        ->where('child_profile_id', $child->id)
                        ->latest()
                        ->first();
                    $assessmentPassed = $attempt && $attempt->status === 'passed';
                    $assessmentScore = $attempt ? "{$attempt->score}/{$attempt->total}" : null;
                }

                $submissions = AssignmentSubmission::whereIn('assignment_id', $lesson->assignments->pluck('id'))
                    ->where('child_profile_id', $child->id)
                    ->with('assignment')
                    ->get();

                $lessonData[] = [
                    'lesson' => $lesson,
                    'assessment_passed' => $assessmentPassed,
                    'assessment_score' => $assessmentScore,
                    'submissions' => $submissions,
                ];
            }

            $done = collect($lessonData)->filter(fn ($l) => $l['assessment_passed'])->count();
            $total = count($lessonData);

            $moduleData[] = [
                'module' => $module,
                'lessons' => $lessonData,
                'progress' => $total > 0 ? round(($done / $total) * 100) : 0,
            ];
        }

        $attendance = Attendance::where('child_profile_id', $child->id)
            ->whereIn('session_id', $course->cohorts()->with('sessions')->get()->flatMap->sessions->pluck('id'))
            ->with('session')
            ->get();

        return view('teacher.student-progress', compact('course', 'child', 'moduleData', 'attendance'));
    }
}
