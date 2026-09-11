<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Club;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Notification;
use App\Models\Payment;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

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

        $enrollment = Enrollment::where('child_profile_id', $child->id)
            ->where('course_id', $course->id)
            ->latest()
            ->first();

        return redirect()->route('parent.courses.payment', $enrollment);
    }

    public function payment(Enrollment $enrollment)
    {
        $parent = auth()->user();
        $parentChildIds = $parent->children()->pluck('child_profiles.id')->toArray();

        if (! in_array($enrollment->child_profile_id, $parentChildIds)) {
            abort(403);
        }

        $enrollment->load(['course.club', 'child']);
        $payment = Payment::where('metadata->enrollment_id', $enrollment->id)
            ->whereIn('status', ['pending', 'paid'])
            ->latest()
            ->first();

        return view('parent.courses.payment', compact('enrollment', 'payment'));
    }

    public function pay(Enrollment $enrollment, Request $request)
    {
        $parent = auth()->user();
        $parentChildIds = $parent->children()->pluck('child_profiles.id')->toArray();

        if (! in_array($enrollment->child_profile_id, $parentChildIds)) {
            abort(403);
        }

        if ($enrollment->payment_status === 'paid') {
            return redirect()->route('parent.enrollments.confirmation', $enrollment);
        }

        $enrollment->load(['course', 'child']);
        $fee = (int) $enrollment->course->fee;

        if ($fee <= 0) {
            $enrollment->update(['payment_status' => 'paid']);

            Notification::create([
                'user_id' => $parent->id,
                'type' => 'enrollment',
                'title' => 'Enrolment Confirmed!',
                'body' => "{$enrollment->child->name} is now enrolled in {$enrollment->course->title}.",
                'icon' => null,
                'link' => route('parent.enrollments.confirmation', $enrollment),
            ]);

            return redirect()->route('parent.enrollments.confirmation', $enrollment)
                ->with('success', 'Your enrolment is confirmed.');
        }

        $reference = 'TLAB-ENR-'.strtoupper(Str::random(10));

        $payment = Payment::create([
            'user_id' => $parent->id,
            'reference' => $reference,
            'amount' => $fee,
            'currency' => 'NGN',
            'status' => 'pending',
            'description' => "Enrolment fee for {$enrollment->course->title}",
            'metadata' => [
                'enrollment_id' => $enrollment->id,
                'course_id' => $enrollment->course_id,
                'course_title' => $enrollment->course->title,
                'child_profile_id' => $enrollment->child_profile_id,
                'child_name' => $enrollment->child->name,
            ],
        ]);

        try {
            $paystack = \Unicodeveloper\Paystack\Facades\Paystack::getAuthorizationUrl([
                'amount' => $fee * 100,
                'email' => $parent->email,
                'reference' => $reference,
                'currency' => 'NGN',
                'metadata' => json_encode($payment->metadata),
                'callback_url' => route('payment.callback'),
            ]);

            return redirect()->away($paystack->url);
        } catch (\Exception $e) {
            return back()->with('error', 'Unable to initialize payment. Please try again.');
        }
    }

    public function confirmation(Enrollment $enrollment)
    {
        $parent = auth()->user();
        $parentChildIds = $parent->children()->pluck('child_profiles.id')->toArray();

        if (! in_array($enrollment->child_profile_id, $parentChildIds)) {
            abort(403);
        }

        $enrollment->load(['course.club', 'child']);
        $payment = Payment::where('metadata->enrollment_id', $enrollment->id)
            ->where('status', 'paid')
            ->first();

        return view('parent.courses.confirmation', compact('enrollment', 'payment'));
    }
}
