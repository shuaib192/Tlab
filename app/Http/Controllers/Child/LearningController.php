<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\ChildProfile;
use Illuminate\Http\Request;

class LearningController extends Controller
{
    protected function verifyAccess(Enrollment $enrollment): void
    {
        $childId = session('active_child_id');
        if (!$childId) {
            redirect()->route('child.login')->with('info', 'Please log in to continue.')->send();
            exit;
        }

        $user = auth()->user();
        if ($user && in_array($user->role ?? '', ['admin', 'super_admin'])) {
            return;
        }

        if ($enrollment->child_profile_id !== $childId) {
            abort(403);
        }
    }

    protected function getChild(): ChildProfile
    {
        return ChildProfile::findOrFail(session('active_child_id'));
    }

    public function course(Enrollment $enrollment)
    {
        $this->verifyAccess($enrollment);

        $child = $this->getChild();

        $enrollment->load([
            'course.club',
            'course.modules.lessons.assessment',
        ]);

        $course = $enrollment->course;
        $completedLessonIds = AssessmentAttempt::where('child_profile_id', $child->id)
            ->where('status', 'passed')
            ->pluck('assessment_id')
            ->toArray();

        $lessonsWithCompletion = [];
        $totalLessons = 0;
        $completedLessons = 0;
        $moduleData = [];

        foreach ($course->modules as $module) {
            $moduleLessons = [];
            foreach ($module->lessons as $lesson) {
                $totalLessons++;
                $completed = false;
                if ($lesson->assessment) {
                    $completed = in_array($lesson->assessment->id, $completedLessonIds);
                }
                if ($completed) $completedLessons++;
                $moduleLessons[] = (object) [
                    'id' => $lesson->id,
                    'title' => $lesson->title,
                    'type' => $lesson->type ?? 'text',
                    'duration' => $lesson->duration,
                    'slug' => $lesson->slug,
                    'sort_order' => $lesson->sort_order,
                    'completed' => $completed,
                    'has_assessment' => (bool) $lesson->assessment,
                ];
            }
            $moduleData[] = (object) [
                'id' => $module->id,
                'title' => $module->title,
                'description' => $module->description,
                'sort_order' => $module->sort_order,
                'lessons' => $moduleLessons,
            ];
        }

        $progress = $totalLessons > 0 ? round(($completedLessons / $totalLessons) * 100) : 0;

        return view('child.course', compact('enrollment', 'course', 'child', 'moduleData', 'progress', 'completedLessons', 'totalLessons'));
    }

    public function lesson(Lesson $lesson)
    {
        $childId = session('active_child_id');
        if (!$childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $module = $lesson->module;
        $course = $module->course;

        $enrollment = Enrollment::where('child_profile_id', $childId)
            ->where('course_id', $course->id)
            ->first();

        $user = auth()->user();
        if (!$enrollment && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        if ($enrollment && $enrollment->child_profile_id !== $childId && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        $child = $this->getChild();

        $lesson->load('module.course.club', 'assessment');

        $allLessons = $module->lessons()->pluck('id');
        $lessonIds = $allLessons->toArray();
        $currentIndex = array_search($lesson->id, $lessonIds);
        $prevLesson = $currentIndex > 0 ? Lesson::find($lessonIds[$currentIndex - 1]) : null;
        $nextLesson = $currentIndex < count($lessonIds) - 1 ? Lesson::find($lessonIds[$currentIndex + 1]) : null;

        $completedLessonIds = AssessmentAttempt::where('child_profile_id', $child->id)
            ->where('status', 'passed')
            ->pluck('assessment_id')
            ->toArray();

        $isCompleted = $lesson->assessment && in_array($lesson->assessment->id, $completedLessonIds);

        $moduleLessonIds = [];
        $moduleCompleted = 0;
        foreach ($module->lessons as $modLesson) {
            $moduleLessonIds[] = $modLesson->id;
            if ($modLesson->assessment && in_array($modLesson->assessment->id, $completedLessonIds)) {
                $moduleCompleted++;
            }
        }

        return view('child.lesson', compact('lesson', 'module', 'course', 'enrollment', 'child', 'prevLesson', 'nextLesson', 'currentIndex', 'isCompleted', 'moduleLessonIds', 'moduleCompleted'));
    }

    public function assessment(Assessment $assessment)
    {
        $childId = session('active_child_id');
        if (!$childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $lesson = $assessment->lesson;
        $module = $lesson->module;
        $course = $module->course;

        $enrollment = Enrollment::where('child_profile_id', $childId)
            ->where('course_id', $course->id)
            ->first();

        $user = auth()->user();
        if (!$enrollment && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        if ($enrollment && $enrollment->child_profile_id !== $childId && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        $child = $this->getChild();

        $assessment->load('questions');
        $existingAttempt = AssessmentAttempt::where('assessment_id', $assessment->id)
            ->where('child_profile_id', $child->id)
            ->latest()
            ->first();

        return view('child.assessment', compact('assessment', 'lesson', 'course', 'child', 'existingAttempt'));
    }

    public function submitAssessment(Assessment $assessment, Request $request)
    {
        $childId = session('active_child_id');
        if (!$childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $lesson = $assessment->lesson;
        $course = $lesson->module->course;

        $enrollment = Enrollment::where('child_profile_id', $childId)
            ->where('course_id', $course->id)
            ->first();

        $user = auth()->user();
        if (!$enrollment && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        if ($enrollment && $enrollment->child_profile_id !== $childId && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        $child = $this->getChild();

        $assessment->load('questions');

        $answers = $request->input('answers', []);
        $score = 0;
        $total = 0;
        $results = [];

        foreach ($assessment->questions as $question) {
            $total += $question->points ?? 1;
            $userAnswer = $answers[$question->id] ?? '';
            $isCorrect = false;

            if ($question->type === 'multiple_choice') {
                $isCorrect = strcasecmp(trim($userAnswer), trim($question->correct_answer)) === 0;
            } elseif ($question->type === 'text') {
                $isCorrect = strcasecmp(trim($userAnswer), trim($question->correct_answer)) === 0;
            }

            if ($isCorrect) {
                $score += $question->points ?? 1;
            }

            $results[$question->id] = [
                'correct' => $isCorrect,
                'user_answer' => $userAnswer,
                'correct_answer' => $question->correct_answer,
            ];
        }

        $status = $score >= $assessment->passing_score ? 'passed' : 'failed';

        AssessmentAttempt::create([
            'assessment_id' => $assessment->id,
            'child_profile_id' => $child->id,
            'answers' => $results,
            'score' => $score,
            'total' => $total,
            'status' => $status,
            'completed_at' => now(),
        ]);

        if ($status === 'passed') {
            $child->awardXp($score * 10, "Passed assessment: {$assessment->title}");
        }

        return redirect()->route('child.lesson', $lesson)
            ->with('assessment_result', [
                'score' => $score,
                'total' => $total,
                'status' => $status,
                'passing_score' => $assessment->passing_score,
            ]);
    }
}
