<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use App\Models\Enrollment;
use App\Models\ModeratedUpload;
use Illuminate\Http\Request;

class ApprovalController extends Controller
{
    public function approveEnrollment(Enrollment $enrollment)
    {
        if ($enrollment->child->user_id !== auth()->id()) {
            abort(403);
        }
        $enrollment->update(['status' => 'active', 'payment_status' => 'approved']);

        return redirect()->back()->with('success', 'Enrollment approved.');
    }

    public function approveUpload(ModeratedUpload $upload)
    {
        if ($upload->child->user_id !== auth()->id()) {
            abort(403);
        }
        $upload->update(['status' => 'approved', 'moderated_by' => auth()->id(), 'moderated_at' => now()]);
        \App\Models\Notification::create([
            'user_id' => auth()->id(), 'type' => 'upload_approved',
            'title' => 'Upload Approved', 'body' => "{$upload->file_name} was approved.",
            'icon' => '✅', 'link' => route('parent.children.show', $upload->child_profile_id),
        ]);

        return redirect()->back()->with('success', 'Upload approved.');
    }

    public function rejectUpload(Request $request, ModeratedUpload $upload)
    {
        if ($upload->child->user_id !== auth()->id()) {
            abort(403);
        }
        $upload->update(['status' => 'rejected', 'moderated_by' => auth()->id(), 'moderated_at' => now(), 'reason' => $request->reason]);

        return redirect()->back()->with('success', 'Upload rejected.');
    }
}
