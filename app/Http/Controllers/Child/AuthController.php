<?php

namespace App\Http\Controllers\Child;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function showLoginForm()
    {
        return view('child.login');
    }

    public function login(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'pin'      => 'required|digits:4',
        ]);

        $child = ChildProfile::where('username', $request->username)->first();

        if (!$child || !$child->pin_enabled || !$child->verifyPin($request->pin)) {
            return back()->withErrors(['pin' => 'Invalid username or PIN.'])->only('username');
        }

        session([
            'active_child_id'   => $child->id,
            'child_authenticated' => true,
        ]);

        return redirect()->route('child.dashboard');
    }

    public function logout(Request $request)
    {
        $request->session()->forget(['active_child_id', 'child_authenticated']);
        return redirect()->route('child.login')->with('success', 'Logged out. See you soon!');
    }
}
