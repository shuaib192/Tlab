<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class CourseController extends Controller
{
    public function index()
    {
        $courses = Course::with('club')->latest()->paginate(25);

        return view('admin.courses.index', compact('courses'));
    }

    public function create()
    {
        $clubs = Club::orderBy('name')->get();

        return view('admin.courses.create', compact('clubs'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);

        $data['slug'] = Str::slug($data['title']).'-'.now()->timestamp;

        Course::create($data);

        return redirect()->route('admin.courses.index')
            ->with('success', "Course \"{$data['title']}\" created successfully.");
    }

    public function edit(Course $course)
    {
        $clubs = Club::orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'clubs'));
    }

    public function update(Request $request, Course $course)
    {
        $data = $request->validate([
            'club_id' => 'required|exists:clubs,id',
            'title' => 'required|string|max:150',
            'description' => 'nullable|string',
            'level' => 'required|in:beginner,intermediate,advanced',
        ]);

        $course->update($data);

        return redirect()->route('admin.courses.index')
            ->with('success', "Course \"{$course->title}\" updated.");
    }

    public function destroy(Course $course)
    {
        $title = $course->title;
        $course->delete();

        return redirect()->route('admin.courses.index')
            ->with('success', "Course \"{$title}\" deleted.");
    }
}
