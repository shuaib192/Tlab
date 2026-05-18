<?php

namespace App\Http\Controllers\Parent;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        $user     = auth()->user();
        $children = $user->children()->withCount('enrollments')->get();

        return view('parent.dashboard', compact('user', 'children'));
    }
}
