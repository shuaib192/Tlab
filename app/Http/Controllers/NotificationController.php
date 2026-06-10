<?php

namespace App\Http\Controllers;

use App\Models\Notification;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    public function index()
    {
        $notifications = auth()->user()->notifications()->latest()->paginate(20);
        $unreadCount = auth()->user()->unreadNotifications()->count();
        return view('notifications.index', compact('notifications', 'unreadCount'));
    }

    public function markRead(Notification $notification)
    {
        if ($notification->user_id !== auth()->id()) abort(403);
        $notification->update(['is_read' => true, 'read_at' => now()]);
        return response()->json(['status' => 'ok']);
    }

    public function markAllRead()
    {
        auth()->user()->unreadNotifications()->update(['is_read' => true, 'read_at' => now()]);
        return redirect()->back()->with('success', 'All notifications marked as read.');
    }

    public function unreadCount()
    {
        $count = auth()->user()->unreadNotifications()->count();
        return response()->json(['count' => $count]);
    }
}
