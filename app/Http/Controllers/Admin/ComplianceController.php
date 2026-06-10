<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use App\Models\Enrollment;
use App\Models\XpLog;
use App\Models\Attendance;
use App\Models\CommunicationLog;
use App\Models\ModeratedUpload;
use Illuminate\Support\Str;
use Illuminate\Http\Request;

class ComplianceController extends Controller
{
    public function index(Request $request)
    {
        $query = collect();

        $filters = $request->only(['user_type', 'action', 'from', 'to', 'user_id']);

        // XP Logs
        $xpLogs = XpLog::with('child')
            ->when($request->user_id, fn($q) => $q->whereHas('child', fn($q) => $q->where('user_id', $request->user_id)))
            ->when($request->from, fn($q) => $q->whereDate('created_at', '>=', $request->from))
            ->when($request->to, fn($q) => $q->whereDate('created_at', '<=', $request->to))
            ->latest()->take(200)->get()->map(fn($l) => [
                'id' => $l->id, 'type' => 'xp_award',
                'description' => "{$l->amount} XP awarded to {$l->child?->name} for \"{$l->activity}\"",
                'user_name' => $l->child?->name ?? 'N/A',
                'created_at' => $l->created_at,
            ]);

        // Enrollments
        $enrollments = Enrollment::with(['child', 'course'])
            ->when($request->user_id, fn($q) => $q->whereHas('child', fn($q) => $q->where('user_id', $request->user_id)))
            ->latest()->take(200)->get()->map(fn($e) => [
                'id' => $e->id, 'type' => 'enrollment',
                'description' => "{$e->child?->name} enrolled in {$e->course?->title} ({$e->status})",
                'user_name' => $e->child?->name ?? 'N/A',
                'created_at' => $e->created_at,
            ]);

        // Communication Logs
        $commLogs = CommunicationLog::with(['teacher', 'child'])
            ->when($request->user_id, fn($q) => $q->where('teacher_id', $request->user_id)->orWhere('parent_id', $request->user_id))
            ->latest()->take(200)->get()->map(fn($c) => [
                'id' => $c->id, 'type' => 'communication',
                'description' => "Message from {$c->teacher?->name} about {$c->child?->name}: {$c->subject}",
                'user_name' => $c->teacher?->name ?? 'N/A',
                'created_at' => $c->created_at,
            ]);

        // Moderated Uploads
        $uploads = ModeratedUpload::with('child')
            ->when($request->user_id, fn($q) => $q->whereHas('child', fn($q) => $q->where('user_id', $request->user_id)))
            ->latest()->take(200)->get()->map(fn($u) => [
                'id' => $u->id, 'type' => 'upload_' . $u->status,
                'description' => "{$u->file_name} ({$u->status}) by {$u->child?->name}",
                'user_name' => $u->child?->name ?? 'N/A',
                'created_at' => $u->created_at,
            ]);

        $activities = collect()
            ->merge($xpLogs)
            ->merge($enrollments)
            ->merge($commLogs)
            ->merge($uploads)
            ->sortByDesc('created_at')
            ->take(200)
            ->values();

        return view('admin.compliance', compact('activities', 'filters'));
    }
}
