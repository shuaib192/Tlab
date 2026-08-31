<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ClassSession;
use App\Models\Cohort;
use Illuminate\Http\Request;

class UpcomingClassController extends Controller
{
    public function index()
    {
        $upcoming = ClassSession::with(['course', 'cohort'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) {
                $q->where('date', '>', now()->toDateString())
                    ->orWhere(function ($q2) {
                        $q2->where('date', '=', now()->toDateString())
                            ->where('start_time', '>=', now()->format('H:i'));
                    });
            })
            ->orderBy('date')
            ->orderBy('start_time')
            ->get();

        $past = ClassSession::with(['course', 'cohort'])
            ->where('status', '!=', 'cancelled')
            ->where(function ($q) {
                $q->where('date', '<', now()->toDateString())
                    ->orWhere(function ($q2) {
                        $q2->where('date', '=', now()->toDateString())
                            ->where('start_time', '<', now()->format('H:i'));
                    });
            })
            ->orderByDesc('date')
            ->latest()
            ->take(10)
            ->get();

        $cohorts = Cohort::with('course')->where('status', '!=', 'archived')->orderBy('name')->get();

        return view('admin.upcoming.index', compact('upcoming', 'past', 'cohorts'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'cohort_id' => 'required|exists:cohorts,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date|after_or_equal:today',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'meeting_url' => 'nullable|url',
            'notes' => 'nullable|string',
        ]);

        $cohort = Cohort::findOrFail($data['cohort_id']);

        $session = ClassSession::create([
            'cohort_id' => $cohort->id,
            'course_id' => $cohort->course_id,
            'title' => $data['title'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'meeting_url' => $data['meeting_url'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => 'scheduled',
        ]);

        return redirect()->route('admin.upcoming.index')
            ->with('success', "Upcoming class '{$session->title}' scheduled for {$session->date} at {$session->start_time}.");
    }

    public function show(ClassSession $session)
    {
        $session->load(['course', 'cohort.children.parent']);

        $cohorts = Cohort::with('course')->where('status', '!=', 'archived')->orderBy('name')->get();

        return view('admin.upcoming.show', compact('session', 'cohorts'));
    }

    public function update(Request $request, ClassSession $session)
    {
        $data = $request->validate([
            'cohort_id' => 'required|exists:cohorts,id',
            'title' => 'required|string|max:255',
            'date' => 'required|date',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i',
            'meeting_url' => 'nullable|url',
            'notes' => 'nullable|string',
            'status' => 'required|in:scheduled,completed,cancelled',
        ]);

        $cohort = Cohort::findOrFail($data['cohort_id']);

        $session->update([
            'cohort_id' => $data['cohort_id'],
            'course_id' => $cohort->course_id,
            'title' => $data['title'],
            'date' => $data['date'],
            'start_time' => $data['start_time'],
            'end_time' => $data['end_time'],
            'meeting_url' => $data['meeting_url'] ?? null,
            'notes' => $data['notes'] ?? null,
            'status' => $data['status'],
        ]);

        return redirect()->route('admin.upcoming.show', $session)
            ->with('success', 'Upcoming class updated.');
    }
}
