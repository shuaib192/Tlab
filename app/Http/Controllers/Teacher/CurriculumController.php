<?php

namespace App\Http\Controllers\Teacher;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CurriculumController extends Controller
{
    private function authorizeTeach(Course $course): void
    {
        abort_unless($course->canBeManagedBy(auth()->user()), 403, 'You do not have permission to access this course.');
    }

    public function createCourse()
    {
        $clubs = Club::orderBy('name')->get();

        return view('teacher.courses-create', compact('clubs'));
    }

    public function storeCourse(Request $request)
    {
        $data = $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:5000',
            'level' => 'nullable|string|max:255',
            'grade_level' => 'nullable|string|max:255',
            'fee' => 'nullable|integer|min:0',
            'is_published' => 'nullable|boolean',
        ]);

        $course = Course::create([
            'club_id' => $data['club_id'],
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.now()->timestamp,
            'description' => $data['description'] ?? null,
            'level' => $data['level'] ?? null,
            'grade_level' => $data['grade_level'] ?? null,
            'teacher_id' => auth()->id(),
            'is_published' => (bool) ($data['is_published'] ?? false),
            'fee' => $data['fee'] ?? null,
        ]);

        return redirect()->route('teacher.course', $course)
            ->with('success', 'Course created. Now build your curriculum.');
    }

    public function curriculum(Course $course)
    {
        $this->authorizeTeach($course);

        $course->load(['modules.lessons' => function ($q) {
            $q->orderBy('sort_order');
        }]);

        return view('teacher.curriculum', compact('course'));
    }

    public function storeModule(Request $request, Course $course)
    {
        $this->authorizeTeach($course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Module::create([
            'course_id' => $course->id,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.Str::random(5),
            'description' => $data['description'] ?? null,
            'sort_order' => $data['sort_order'] ?? Module::where('course_id', $course->id)->count(),
        ]);

        return redirect()->route('teacher.curriculum', $course)
            ->with('success', 'Module created.');
    }

    public function updateModule(Request $request, Module $module)
    {
        $this->authorizeTeach($module->course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $module->update($data);

        return redirect()->route('teacher.curriculum', $module->course)
            ->with('success', 'Module updated.');
    }

    public function destroyModule(Module $module)
    {
        $this->authorizeTeach($module->course);

        $course = $module->course;
        $module->delete();

        return redirect()->route('teacher.curriculum', $course)
            ->with('success', 'Module deleted.');
    }

    public function storeLesson(Request $request, Module $module)
    {
        $this->authorizeTeach($module->course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:text,video',
            'video_url' => 'nullable|url|max:500',
            'duration' => 'nullable|integer|min:1|max:999',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        Lesson::create([
            'module_id' => $module->id,
            'title' => $data['title'],
            'slug' => Str::slug($data['title']).'-'.Str::random(5),
            'content' => $data['content'] ?? null,
            'type' => $data['type'],
            'video_url' => $data['video_url'] ?? null,
            'duration' => $data['duration'] ?? null,
            'sort_order' => $data['sort_order'] ?? Lesson::where('module_id', $module->id)->count(),
            'is_published' => true,
        ]);

        return redirect()->route('teacher.curriculum', $module->course)
            ->with('success', 'Lesson created.');
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $this->authorizeTeach($lesson->module->course);

        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:text,video',
            'video_url' => 'nullable|url|max:500',
            'duration' => 'nullable|integer|min:1|max:999',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $lesson->update($data);

        return redirect()->route('teacher.curriculum', $lesson->module->course)
            ->with('success', 'Lesson updated.');
    }

    public function destroyLesson(Lesson $lesson)
    {
        $this->authorizeTeach($lesson->module->course);

        $course = $lesson->module->course;
        $lesson->delete();

        return redirect()->route('teacher.curriculum', $course)
            ->with('success', 'Lesson deleted.');
    }

    public function storeCohort(Request $request, Course $course)
    {
        $this->authorizeTeach($course);

        $data = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'session_time' => ['nullable', 'string', 'max:100', 'regex:/^([01]?\d|2[0-3])(:[0-5]\d)?\s*([AaPp][Mm])?$/'],
            'session_days' => 'nullable|string|max:255',
            'status' => 'nullable|in:active,completed,archived',
        ]);

        Cohort::create([
            'course_id' => $course->id,
            'name' => $data['name'],
            'slug' => Str::slug($data['name']).'-'.Str::random(5),
            'description' => $data['description'] ?? null,
            'start_date' => $data['start_date'] ?? null,
            'end_date' => $data['end_date'] ?? null,
            'session_time' => ! empty($data['session_time']) ? \Carbon\Carbon::parse($data['session_time'])->format('H:i:s') : null,
            'session_days' => $data['session_days'] ?? null,
            'status' => $data['status'] ?? 'active',
        ]);

        return redirect()->route('teacher.course', $course)
            ->with('success', 'Cohort created.');
    }
}
