<?php

namespace App\Http\Controllers;

use App\Models\CommunicationLog;

class CommunicationController extends Controller
{
    public function index()
    {
        $user = auth()->user();
        if ($user->isTeacher()) {
            $logs = CommunicationLog::where('teacher_id', $user->id)->with(['child', 'parent'])->latest()->paginate(20);
        } else {
            $childIds = $user->children()->pluck('id');
            $logs = CommunicationLog::whereIn('child_profile_id', $childIds)->with(['child', 'teacher'])->latest()->paginate(20);
        }

        return view('communications.index', compact('logs'));
    }

    public function markRead(CommunicationLog $log)
    {
        $log->update(['is_read' => true]);

        return response()->json(['ok' => true]);
    }
}
