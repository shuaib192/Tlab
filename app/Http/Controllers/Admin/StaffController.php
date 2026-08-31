<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class StaffController extends Controller
{
    public function index(Request $request)
    {
        $query = User::whereIn('role', ['admin', 'super_admin']);

        if ($request->filled('search')) {
            $query->where(function ($q) use ($request) {
                $q->where('name', 'like', "%{$request->search}%")
                    ->orWhere('email', 'like', "%{$request->search}%");
            });
        }

        $staff = $query->orderByRaw("FIELD(role, 'super_admin', 'admin')")->latest()->get();

        return view('admin.staff.index', compact('staff'));
    }

    public function promote(Request $request, User $user)
    {
        if ($user->id === auth()->id()) {
            return back()->with('error', 'You cannot change your own role.');
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

        $role = $request->input('to', 'parent');

        $user->update(['role' => in_array($role, ['parent', 'teacher', 'school_admin']) ? $role : 'parent']);

        return redirect()->route('admin.staff.index')
            ->with('success', "{$user->name} removed from the management team.");
    }
}
