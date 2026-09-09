<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Models\Assessment;
use App\Models\AssessmentAttempt;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ChildProfile;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\LiveSession;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LearningController extends Controller
{
    protected function verifyAccess(Enrollment $enrollment): void
    {
        $childId = session('active_child_id');
        if (! $childId) {
            redirect()->route('child.login')->with('info', 'Please log in to continue.')->send();
            exit;
        }

        $user = auth()->user();
        if ($user && in_array($user->role ?? '', ['admin', 'super_admin'])) {
            return;
        }

        if ((int) $enrollment->child_profile_id !== (int) $childId) {
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
            'course.modules.lessons.assignments',
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
                if ($completed) {
                    $completedLessons++;
                }
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

        $assignments = collect();
        $submissionMap = collect();
        if ($course->relationLoaded('modules')) {
            foreach ($course->modules as $module) {
                foreach ($module->lessons as $lesson) {
                    foreach ($lesson->assignments as $a) {
                        $assignments->push($a);
                    }
                }
            }
            if ($child) {
                $submissionMap = AssignmentSubmission::where('child_profile_id', $child->id)
                    ->whereIn('assignment_id', $assignments->pluck('id'))
                    ->get()
                    ->keyBy('assignment_id');
            }
        }

        $liveSessions = LiveSession::where(function ($q) use ($course) {
            $q->where('course_id', $course->id)
                ->orWhereHas('classSession', fn ($q) => $q->where('course_id', $course->id));
        })->orderByDesc('scheduled_at')->get();

        return view('child.course', compact('enrollment', 'course', 'child', 'moduleData', 'progress', 'completedLessons', 'totalLessons', 'liveSessions', 'assignments', 'submissionMap'));
    }

    public function lesson(Lesson $lesson)
    {
        $childId = session('active_child_id');
        if (! $childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $module = $lesson->module;
        $course = $module->course;

        $enrollment = Enrollment::where('child_profile_id', $childId)
            ->where('course_id', $course->id)
            ->first();

        $user = auth()->user();
        if (! $enrollment && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        if ($enrollment && (int) $enrollment->child_profile_id !== (int) $childId && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
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
        if (! $childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $lesson = $assessment->lesson;
        $module = $lesson->module;
        $course = $module->course;

        $enrollment = Enrollment::where('child_profile_id', $childId)
            ->where('course_id', $course->id)
            ->first();

        $user = auth()->user();
        if (! $enrollment && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        if ($enrollment && (int) $enrollment->child_profile_id !== (int) $childId && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        $child = $this->getChild();

        $assessment->load('questions');
        $existingAttempt = AssessmentAttempt::where('assessment_id', $assessment->id)
            ->where('child_profile_id', $child->id)
            ->latest()
            ->first();

        return view('child.assessment', compact('assessment', 'lesson', 'course', 'child', 'existingAttempt', 'enrollment'));
    }

    public function submitAssessment(Assessment $assessment, Request $request)
    {
        $childId = session('active_child_id');
        if (! $childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $lesson = $assessment->lesson;
        $course = $lesson->module->course;

        $enrollment = Enrollment::where('child_profile_id', $childId)
            ->where('course_id', $course->id)
            ->first();

        $user = auth()->user();
        if (! $enrollment && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        if ($enrollment && (int) $enrollment->child_profile_id !== (int) $childId && (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin']))) {
            abort(403);
        }

        $child = $this->getChild();

        $assessment->load('questions');

        $answersJson = $request->input('answers_json', '[]');
        $answers = json_decode($answersJson, true) ?? [];
        $score = 0;
        $total = 0;
        $results = [];

        foreach ($assessment->questions as $index => $question) {
            $total += $question->points ?? 1;
            $userAnswer = $answers[$index] ?? '';
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

    public function createProject(Enrollment $enrollment, Assignment $assignment)
    {
        $childId = session('active_child_id');
        if (! $childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $assignment->load('lesson.module.course');

        $user = auth()->user();
        $isStaff = $user && in_array($user->role ?? '', ['admin', 'super_admin']);
        $valid = (int) $enrollment->child_profile_id === (int) $childId
            && (int) $enrollment->course_id === (int) $assignment->lesson?->module?->course?->id;
        if (! $valid && ! $isStaff) {
            abort(403);
        }

        $child = $this->getChild();

        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('child_profile_id', $child->id)
            ->with('files')
            ->first();

        $allVersions = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('child_profile_id', $child->id)
            ->orderByDesc('version')
            ->with('files')
            ->get();

        return view('child.project', compact('assignment', 'child', 'enrollment', 'existingSubmission', 'allVersions'));
    }

    public function submitProject(Enrollment $enrollment, Assignment $assignment, Request $request)
    {
        $childId = session('active_child_id');
        if (! $childId) {
            return redirect()->route('child.login')->with('info', 'Please log in to continue.');
        }

        $assignment->load('lesson.module.course');
        $course = $assignment->lesson->module->course;

        $user = auth()->user();
        $isStaff = $user && in_array($user->role ?? '', ['admin', 'super_admin']);
        $valid = (int) $enrollment->child_profile_id === (int) $childId
            && (int) $enrollment->course_id === (int) $course->id;
        if (! $valid && ! $isStaff) {
            abort(403);
        }

        $child = $this->getChild();

        $rules = [
            'submission_text' => 'nullable|string|max:50000',
            'link_url' => ['nullable', 'url', 'max:500', new \App\Rules\AllowlistedUrl],
            'link_note' => 'nullable|string|max:500',
        ];

        if ($assignment->acceptsFiles()) {
            $rules['files'] = 'nullable|array|max:3';
            $rules['files.*'] = 'file|mimes:pdf,docx,pptx,xlsx,jpg,jpeg,png,zip|max:25600';
        }

        if ($assignment->acceptsCanvas()) {
            $rules['canvas_data'] = 'nullable|string|max:6000000';
            $rules['canvas_bg'] = 'nullable|in:white,dark';
        }

        $data = $request->validate($rules);

        if ($assignment->acceptsLinks() && ! empty($data['link_url'])) {
            // link_url is already validated as URL by Laravel
        }

        $existingSubmission = AssignmentSubmission::where('assignment_id', $assignment->id)
            ->where('child_profile_id', $child->id)
            ->first();

        $nextVersion = $existingSubmission ? $existingSubmission->version + 1 : 1;

        $canvasPath = null;
        if ($assignment->acceptsCanvas() && is_string($data['canvas_data'] ?? null) && $data['canvas_data'] !== '') {
            $canvasPath = $this->persistCanvasData($data['canvas_data'], $childId, $assignment->id, $nextVersion);
        }

        $filePaths = [];
        if ($assignment->acceptsFiles() && $request->hasFile('files')) {
            foreach ($request->file('files') as $file) {
                $path = $file->store('submissions/'.$childId, 'public');
                $filePaths[] = [
                    'path' => $path,
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                    'mime' => $file->getMimeType(),
                ];

                \App\Models\ModeratedUpload::create([
                    'child_profile_id' => $child->id,
                    'file_url' => Storage::url($path),
                    'file_name' => $file->getClientOriginalName(),
                    'file_type' => $file->getMimeType(),
                    'file_size' => $file->getSize(),
                    'status' => 'pending',
                ]);
            }
        }

        $submittedLate = false;
        if ($assignment->due_date) {
            $submittedLate = now()->gt($assignment->due_date->endOfDay());
        }

        $submission = AssignmentSubmission::updateOrCreate(
            [
                'assignment_id' => $assignment->id,
                'child_profile_id' => $child->id,
            ],
            [
                'version' => $nextVersion,
                'submission_text' => $data['submission_text'] ?? null,
                'file_url' => ! empty($filePaths) ? Storage::url($filePaths[0]['path']) : ($existingSubmission?->file_url),
                'files_json' => ! empty($filePaths) ? $filePaths : ($existingSubmission?->files_json),
                'link_url' => $data['link_url'] ?? null,
                'link_note' => $data['link_note'] ?? null,
                'canvas_path' => $canvasPath ?? ($existingSubmission?->canvas_path),
                'canvas_bg' => $data['canvas_bg'] ?? ($existingSubmission?->canvas_bg ?? 'white'),
                'status' => 'submitted',
                'submitted_at' => now(),
                'submitted_late' => $submittedLate,
            ]
        );

        if (! empty($filePaths)) {
            foreach ($filePaths as $fp) {
                \App\Models\SubmissionFile::create([
                    'submission_id' => $submission->id,
                    'file_path' => $fp['path'],
                    'file_name' => $fp['name'],
                    'file_size' => $fp['size'],
                    'file_mime' => $fp['mime'],
                ]);
            }
        }

        $child->awardXp(15, "Submitted project: {$assignment->title}");

        $msg = $submittedLate
            ? 'Project submitted (late). +15 XP earned.'
            : 'Project submitted successfully! +15 XP earned.';

        return redirect()->route('child.course', $enrollment)
            ->with('success', $msg);
    }

    private function persistCanvasData(string $dataUrl, int $childId, int $assignmentId, int $version): ?string
    {
        if (preg_match('/^data:image\/png;base64,/', $dataUrl) !== 1) {
            return null;
        }

        $raw = base64_decode(substr($dataUrl, strpos($dataUrl, ',') + 1), true);
        if ($raw === false || $raw === '') {
            return null;
        }

        $magic = "\x89PNG\r\n\x1a\n";
        if (strlen($raw) < 24 || ! str_starts_with($raw, $magic) || strlen($raw) > 5000000) {
            return null;
        }

        $path = 'submissions/'.$childId.'/canvas_a'.$assignmentId.'_v'.$version.'.png';
        Storage::disk('public')->put($path, $raw, 'public');

        return $path;
    }
}
