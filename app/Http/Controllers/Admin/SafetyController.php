<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CommunicationLog;
use App\Models\ModeratedUpload;
use App\Models\Notification;
use App\Models\SafeLink;
use Illuminate\Http\Request;

class SafetyController extends Controller
{
    public function safeLinks()
    {
        $links = SafeLink::latest()->paginate(20);

        return view('admin.safe-links', compact('links'));
    }

    public function storeSafeLink(Request $request)
    {
        $validated = $request->validate([
            'domain' => 'required|string|max:255|unique:safe_links,domain',
            'is_allowed' => 'boolean',
            'category' => 'nullable|string|max:100',
            'description' => 'nullable|string|max:500',
        ]);

        SafeLink::create($validated);

        return redirect()->route('admin.safety.safe-links')->with('success', 'Safe link added.');
    }

    public function destroySafeLink(SafeLink $safeLink)
    {
        $safeLink->delete();

        return redirect()->route('admin.safety.safe-links')->with('success', 'Safe link removed.');
    }

    public function uploads()
    {
        $uploads = ModeratedUpload::with(['child', 'moderator'])->latest()->paginate(20);

        return view('admin.moderation-uploads', compact('uploads'));
    }

    public function approveUpload(ModeratedUpload $upload)
    {
        $upload->update(['status' => 'approved', 'moderated_by' => auth()->id(), 'moderated_at' => now()]);
        Notification::create([
            'user_id' => $upload->child->user_id,
            'type' => 'upload_approved',
            'title' => 'Upload Approved',
            'body' => "{$upload->file_name} was approved by admin.",
            'icon' => '✅',
            'link' => route('parent.children.show', $upload->child_profile_id),
        ]);

        return redirect()->back()->with('success', 'Upload approved.');
    }

    public function rejectUpload(Request $request, ModeratedUpload $upload)
    {
        $request->validate(['reason' => 'nullable|string|max:500']);
        $upload->update(['status' => 'rejected', 'moderated_by' => auth()->id(), 'moderated_at' => now(), 'reason' => $request->reason]);
        Notification::create([
            'user_id' => $upload->child->user_id,
            'type' => 'upload_rejected',
            'title' => 'Upload Rejected',
            'body' => $request->reason ? "{$upload->file_name} was rejected: {$request->reason}" : "{$upload->file_name} was rejected.",
            'icon' => '❌',
            'link' => route('parent.children.show', $upload->child_profile_id),
        ]);

        return redirect()->back()->with('success', 'Upload rejected.');
    }

    public function communications()
    {
        $logs = CommunicationLog::with(['teacher', 'parent', 'child'])->latest()->paginate(20);

        return view('admin.communications', compact('logs'));
    }
}
