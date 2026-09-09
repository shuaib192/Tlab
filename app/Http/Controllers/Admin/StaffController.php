<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'super_admin', 'teacher', 'facilitator']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $staff = $query->orderByRaw("FIELD(role, 'super_admin', 'admin', 'facilitator', 'teacher')")->latest()->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function suspend(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot suspend your own account.');
        }

        if (! auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can suspend staff.');
        }

        $request->validate(['reason' => 'required|string|max:500']);

        $wasActive = ! $user->isSuspended();

        $user->update([
            'is_active' => false,
            'suspended_at' => now(),
            'suspended_reason' => $request->reason,
        ]);

        $user->revokeAllSessions();

        if ($wasActive) {
            AuditLog::log(User::class, $user->id, 'updated', ['is_active' => true], ['is_active' => false], 'Suspended: '.$request->reason);
        }

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} suspended. All sessions revoked immediately.");
    }

    public function reactivate(Request $request, User $user)
    {
        if (! auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can reactivate staff.');
        }

        $wasSuspended = $user->isSuspended();

        $user->update([
            'is_active' => true,
            'suspended_at' => null,
            'suspended_reason' => null,
        ]);

        if ($wasSuspended) {
            AuditLog::log(User::class, $user->id, 'updated', ['is_active' => false], ['is_active' => true], 'Reactivated by Super Admin');
        }

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} reactivated.");
    }

    public function promote(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        if (! auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can manage staff roles.');
        }

        $target = $request->has('super') ? 'super_admin' : 'admin';

        $user->update(['role' => $target]);

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} is now a ".($target === 'super_admin' ? 'Super Admin' : 'Admin').'.');
    }

    public function demote(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
        }

        if (! auth()->user()->isSuperAdmin()) {
            return back()->with('error', 'Only Super Admins can manage staff roles.');
        }

        $role = $request->input('to', 'parent');

        $user->update(['role' => in_array($role, ['parent', 'teacher', 'facilitator', 'school_admin']) ? $role : 'parent']);

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} removed from the management team.");
    }
}
