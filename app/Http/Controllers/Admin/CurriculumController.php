<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\Module;
use App\Models\Lesson;
use App\Models\Assessment;
use App\Models\AssessmentQuestion;
use Illuminate\Http\Request;

class CurriculumController extends Controller
{
    public function modules(Course $course)
    {
        $course->load('modules.lessons');
        return view('admin.curriculum.modules', compact('course'));
    }

    public function storeModule(Request $request, Course $course)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? Module::where('course_id', $course->id)->count();

        Module::create(array_merge($data, ['course_id' => $course->id]));

        return redirect()->route('admin.curriculum.modules', $course)
            ->with('success', 'Module created successfully.');
    }

    public function updateModule(Request $request, Module $module)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string|max:2000',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $module->update($data);

        return redirect()->route('admin.curriculum.modules', $module->course_id)
            ->with('success', 'Module updated.');
    }

    public function destroyModule(Module $module)
    {
        $courseId = $module->course_id;
        $module->delete();

        return redirect()->route('admin.curriculum.modules', $courseId)
            ->with('success', 'Module deleted.');
    }

    public function lessons(Module $module)
    {
        $module->load('course', 'lessons.assessment');
        return view('admin.curriculum.lessons', compact('module'));
    }

    public function storeLesson(Request $request, Module $module)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:text,video,quiz,assignment',
            'video_url' => 'nullable|url|max:500',
            'duration' => 'nullable|integer|min:1|max:999',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['slug'] = str($data['title'])->slug();
        $data['sort_order'] = $data['sort_order'] ?? Lesson::where('module_id', $module->id)->count();

        Lesson::create(array_merge($data, ['module_id' => $module->id]));

        return redirect()->route('admin.curriculum.lessons', $module)
            ->with('success', 'Lesson created successfully.');
    }

    public function updateLesson(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'content' => 'nullable|string',
            'type' => 'required|in:text,video,quiz,assignment',
            'video_url' => 'nullable|url|max:500',
            'duration' => 'nullable|integer|min:1|max:999',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $lesson->update($data);

        return redirect()->route('admin.curriculum.lessons', $lesson->module_id)
            ->with('success', 'Lesson updated.');
    }

    public function destroyLesson(Lesson $lesson)
    {
        $moduleId = $lesson->module_id;
        $lesson->delete();

        return redirect()->route('admin.curriculum.lessons', $moduleId)
            ->with('success', 'Lesson deleted.');
    }

    public function assessments(Lesson $lesson)
    {
        $lesson->load('module.course', 'assessment.questions');
        return view('admin.curriculum.assessments', compact('lesson'));
    }

    public function storeAssessment(Request $request, Lesson $lesson)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'passing_score' => 'required|integer|min:1|max:9999',
            'max_attempts' => 'nullable|integer|min:1|max:99',
        ]);

        $data['lesson_id'] = $lesson->id;
        $data['max_attempts'] = $data['max_attempts'] ?? 3;

        Assessment::create($data);

        return redirect()->route('admin.curriculum.assessments', $lesson)
            ->with('success', 'Assessment created.');
    }

    public function storeQuestion(Request $request, Assessment $assessment)
    {
        $data = $request->validate([
            'question_text' => 'required|string|max:5000',
            'type' => 'required|in:multiple_choice,text',
            'options' => 'nullable|json',
            'correct_answer' => 'required|string|max:1000',
            'points' => 'required|integer|min:1|max:999',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        $data['sort_order'] = $data['sort_order'] ?? AssessmentQuestion::where('assessment_id', $assessment->id)->count();

        $assessment->questions()->create($data);

        return redirect()->route('admin.curriculum.assessments', $assessment->lesson_id)
            ->with('success', 'Question added.');
    }

    public function destroyQuestion(AssessmentQuestion $question)
    {
        $lessonId = $question->assessment->lesson_id;
        $question->delete();

        return redirect()->route('admin.curriculum.assessments', $lessonId)
            ->with('success', 'Question deleted.');
    }
}
