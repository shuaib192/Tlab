<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use Illuminate\Http\Request;

class AuditLogController extends Controller
{
    public function index(Request $request)
    {
        $query = AuditLog::with('user')->orderByDesc('created_at');

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->integer('user_id'));
        }

        if ($request->filled('action')) {
            $query->where('action', $request->string('action'));
        }

        if ($request->filled('auditable_type')) {
            $query->where('auditable_type', $request->string('auditable_type'));
        }

        if ($request->filled('q')) {
            $q = $request->string('q')->lower();
            $query->where(function ($query) use ($q) {
                $query->whereRaw('LOWER(reason) LIKE ?', ["%{$q}%"])
                    ->orWhereRaw('LOWER(auditable_type) LIKE ?', ["%{$q}%"]);
            });
        }

        $logs = $query->paginate(25)->withQueryString();

        $users = \App\Models\User::orderBy('name')->get(['id', 'name']);

        $actions = ['created', 'updated', 'deleted'];

        $auditableTypes = AuditLog::select('auditable_type')
            ->distinct()
            ->orderBy('auditable_type')
            ->pluck('auditable_type');

        $typeLabels = [
            \App\Models\Attendance::class => 'Attendance',
            \App\Models\Assignment::class => 'Assignment',
            \App\Models\AssignmentSubmission::class => 'Submission',
            \App\Models\User::class => 'User',
            \App\Models\ChildProfile::class => 'Child',
            \App\Models\Enrollment::class => 'Enrollment',
            \App\Models\Payment::class => 'Payment',
            \App\Models\Course::class => 'Course',
            \App\Models\Cohort::class => 'Cohort',
            \App\Models\ClassSession::class => 'Session',
        ];

        return view('admin.audit-logs.index', compact('logs', 'users', 'actions', 'auditableTypes', 'typeLabels'));
    }
}
