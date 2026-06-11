<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Http\Request;

class EnrollmentController extends Controller
{
    public function index(Request $request)
    {
        $query = Enrollment::with(['child', 'course.club']);

        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }

        if ($request->filled('payment_status')) {
            $query->where('payment_status', $request->payment_status);
        }

        $enrollments = $query->latest()->paginate(25)->withQueryString();

        return view('admin.enrollments.index', compact('enrollments'));
    }

    public function create()
    {
        $children = ChildProfile::with('parent')->orderBy('name')->get();
        $courses = Course::with('club')->orderBy('title')->get();

        return view('admin.enrollments.create', compact('children', 'courses'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'child_profile_id' => 'required|exists:child_profiles,id',
            'course_id' => 'required|exists:courses,id',
            'status' => 'required|in:active,completed,dropped',
            'payment_status' => 'required|in:pending,paid',
        ]);

        // Prevent duplicate enrollment
        $exists = Enrollment::where('child_profile_id', $data['child_profile_id'])
            ->where('course_id', $data['course_id'])
            ->exists();

        if ($exists) {
            return back()->with('error', 'This child is already enrolled in that course.');
        }

        Enrollment::create($data);

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment created successfully.');
    }

    public function update(Request $request, Enrollment $enrollment)
    {
        $data = $request->validate([
            'status' => 'required|in:active,completed,dropped',
            'payment_status' => 'required|in:pending,paid',
        ]);

        $enrollment->update($data);

        return back()->with('success', 'Enrollment updated.');
    }

    public function destroy(Enrollment $enrollment)
    {
        $enrollment->delete();

        return redirect()->route('admin.enrollments.index')
            ->with('success', 'Enrollment removed.');
    }
}
