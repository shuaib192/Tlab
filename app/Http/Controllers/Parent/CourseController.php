<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class CourseController extends Controller
{
    public function index()
    {
        $clubs = Club::with(['courses' => function ($q) {
            $q->where('is_published', true);
        }])->get();

        return view('parent.courses.index', compact('clubs'));
    }

    public function show(Club $club)
    {
        $courses = $club->courses()->where('is_published', true)->get();

        return view('parent.courses.show', compact('club', 'courses'));
    }

    public function enrollForm(Course $course)
    {
        if (! $course->is_published) {
            abort(404);
        }

        $children = auth()->user()->children()->latest()->get();

        $enrolledChildIds = Enrollment::where('course_id', $course->id)
            ->whereIn('child_profile_id', $children->pluck('id'))
            ->where('status', 'active')
            ->pluck('child_profile_id')
            ->toArray();

        return view('parent.courses.enroll', compact('course', 'children', 'enrolledChildIds'));
    }

    public function enroll(Course $course, Request $request)
    {
        if (! $course->is_published) {
            abort(404);
        }

        $request->validate([
            'child_profile_id' => 'required|exists:child_profiles,id',
        ]);

        $child = auth()->user()->children()->findOrFail($request->child_profile_id);

        $exists = Enrollment::where('child_profile_id', $child->id)
            ->where('course_id', $course->id)
            ->where('status', 'active')
            ->exists();

        if ($exists) {
            return back()->with('error', "{$child->name} is already enrolled in {$course->title}.");
        }

        Enrollment::create([
            'child_profile_id' => $child->id,
            'course_id' => $course->id,
            'status' => 'active',
            'payment_status' => 'pending',
            'started_at' => now(),
        ]);

        return redirect()->route('parent.courses.show', $course->club)
            ->with('success', "{$child->name} has been enrolled in {$course->title}!");
    }
}
