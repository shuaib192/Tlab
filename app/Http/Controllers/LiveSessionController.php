<?php

namespace App\Http\Controllers;

use App\Models\Attendance;
use App\Models\ChildProfile;
use App\Models\Enrollment;
use App\Models\LiveSession;
use App\Services\JitsiService;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LiveSessionController extends Controller
{
    public function index(JitsiService $jitsi)
    {
        $sessions = LiveSession::with(['course', 'classSession.cohort', 'host'])
            ->latest('scheduled_at')
            ->get();

        return view('live.index', compact('sessions', 'jitsi'));
    }

    public function create()
    {
        $classSessions = \App\Models\ClassSession::with(['course', 'cohort'])
            ->orderByDesc('date')
            ->limit(50)
            ->get();

        $courses = \App\Models\Course::orderBy('title')->get();

        return view('live.create', compact('classSessions', 'courses'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'class_session_id' => 'nullable|exists:class_sessions,id',
            'course_id' => 'nullable|exists:courses,id',
            'scheduled_at' => 'required|date',
            'duration_minutes' => 'required|integer|min:15|max:480',
            'status' => 'nullable|in:scheduled,live',
        ]);

        $courseId = $validated['course_id'] ?? (filled($validated['class_session_id'])
            ? \App\Models\ClassSession::findOrFail($validated['class_session_id'])->course_id
            : null);

        $session = new LiveSession;
        $session->class_session_id = $validated['class_session_id'] ?? null;
        $session->course_id = $courseId;
        $session->title = $validated['title'];
        $session->scheduled_at = $validated['scheduled_at'];
        $session->duration_minutes = $validated['duration_minutes'];
        $session->status = $validated['status'] ?? LiveSession::STATUS_SCHEDULED;
        $session->jitsi_domain = app(JitsiService::class)->domain();
        $session->room_name = Str::uuid()->toString().'-'.substr(bin2hex(random_bytes(8)), 0, 16);
        $session->host_id = auth()->id();
        $session->save();

        $session->room_name = app(JitsiService::class)->generateRoomName($session);
        $session->save();

        return redirect()->route('admin.live.index')->with('success', 'Live session created.');
    }

    public function start($liveSession)
    {
        $session = LiveSession::findOrFail($liveSession);
        $this->authorizeHardcode($session);

        if ($session->isEnded()) {
            return back()->with('error', 'This live session has ended.');
        }

        if (! $session->started_at) {
            $session->started_at = now();
            $session->status = LiveSession::STATUS_LIVE;
            $session->save();
        }

        return redirect()->route('live.room', $session);
    }

    public function end($liveSession)
    {
        $session = LiveSession::findOrFail($liveSession);
        $this->authorizeHardcode($session);

        $session->ended_at = now();
        $session->status = LiveSession::STATUS_ENDED;
        $session->save();

        return redirect()->route('admin.live.index')->with('success', 'Live session ended.');
    }

    public function destroy($liveSession)
    {
        $session = LiveSession::findOrFail($liveSession);
        $this->authorizeHardcode($session);

        $session->delete();

        return redirect()->route('admin.live.index')->with('success', 'Live session deleted.');
    }

    public function room($liveSession, JitsiService $jitsi)
    {
        $session = LiveSession::findOrFail($liveSession);
        if ($session->isEnded()) {
            abort(410, 'This live session has ended.');
        }

        $user = auth()->user();
        $childProfileId = session('active_child_id');
        $childName = null;

        if ($childProfileId) {
            $child = ChildProfile::find($childProfileId);
            $childName = $child?->name;
        }

        $moderator = $this->guardModerator($session, $user);
        $observer = $this->guardObserver($session, $user, $childProfileId, $moderator);

        if (! $session->started_at) {
            $session->started_at = now();
            $session->status = LiveSession::STATUS_LIVE;
            $session->save();
        }

        $identity = [
            'name' => $jitsi->displayNameFor($user, $childName),
            'email' => $user?->email,
        ];

        $jwt = $jitsi->buildJwt($session, $identity, $moderator);

        return view('live.room', compact('session', 'jitsi', 'moderator', 'observer', 'identity', 'jwt'));
    }

    public function attendance(Request $request, $liveSession)
    {
        $request->validate(['enrollment_id' => 'required|integer']);

        $session = LiveSession::findOrFail($liveSession);
        $enrollment = Enrollment::find($request->enrollment_id);
        if (! $enrollment) {
            return response()->json(['ok' => false, 'message' => 'Enrollment not found.'], 404);
        }

        $courseId = $session->course_id ?? $session->classSession?->course_id;
        if ($courseId && $enrollment->course_id !== $courseId) {
            return response()->json(['ok' => false, 'message' => 'Not enrolled in this course.'], 403);
        }

        $targetSessionId = $session->class_session_id;

        if ($targetSessionId) {
            $markedBy = auth()->id() ?? $enrollment->child?->parent?->id;

            Attendance::firstOrCreate(
                [
                    'session_id' => $targetSessionId,
                    'child_profile_id' => $enrollment->child_profile_id,
                ],
                [
                    'status' => 'present',
                    'notes' => 'Auto-verified via live classroom',
                    'marked_by' => $markedBy,
                ]
            );
        }

        return response()->json(['ok' => true]);
    }

    protected function authorizeHardcode(LiveSession $session): void
    {
        $user = auth()->user();
        if (! $user || ! in_array($user->role ?? '', ['admin', 'super_admin', 'teacher'])) {
            abort(403);
        }

        if ($user->role === 'teacher' && $session->course_id) {
            $ownsCourse = \App\Models\Course::where('id', $session->course_id)
                ->where('teacher_id', $user->id)
                ->exists();

            if (! $ownsCourse) {
                abort(403);
            }
        }
    }

    protected function guardModerator(LiveSession $session, ?\App\Models\User $user): bool
    {
        if (! $user) {
            return false;
        }

        if (in_array($user->role ?? '', ['admin', 'super_admin'])) {
            return true;
        }

        if ($user->role === 'teacher') {
            if (! $session->course_id) {
                return true;
            }

            return \App\Models\Course::where('id', $session->course_id)
                ->where('teacher_id', $user->id)
                ->exists();
        }

        return false;
    }

    protected function guardObserver(LiveSession $session, ?\App\Models\User $user, $childProfileId, bool $moderator): bool
    {
        if ($moderator) {
            return false;
        }

        if ($childProfileId) {
            return true;
        }

        if ($user && $user->isParent()) {
            return true;
        }

        return false;
    }
}
