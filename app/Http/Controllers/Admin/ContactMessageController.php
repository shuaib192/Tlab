<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use Illuminate\Http\Request;

class ContactMessageController extends Controller
{
    public function index(Request $request)
    {
        $query = ContactMessage::latest();

        if ($request->filled('filter')) {
            $query->where('is_read', $request->input('filter') === 'unread');
        }

        if ($request->filled('search')) {
            $search = $request->input('search');
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%")
                    ->orWhere('subject', 'like', "%{$search}%")
                    ->orWhere('message', 'like', "%{$search}%");
            });
        }

        return view('admin.contact-messages.index', [
            'messages' => $query->paginate(20)->withQueryString(),
            'unreadCount' => ContactMessage::unread()->count(),
        ]);
    }

    public function show(ContactMessage $contactMessage)
    {
        if (! $contactMessage->is_read) {
            $contactMessage->update(['is_read' => true, 'read_at' => now()]);
        }

        return view('admin.contact-messages.show', compact('contactMessage'));
    }
}
