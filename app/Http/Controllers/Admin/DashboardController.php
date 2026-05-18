<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ChildProfile;
use App\Models\Club;
use App\Models\Course;
use App\Models\Enrollment;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'parents'     => User::where('role', 'parent')->count(),
            'children'    => ChildProfile::count(),
            'clubs'       => Club::count(),
            'courses'     => Course::count(),
            'enrollments' => Enrollment::count(),
            'paid'        => Enrollment::where('payment_status', 'paid')->count(),
        ];

        $recentUsers    = User::latest()->take(5)->get();
        $recentChildren = ChildProfile::with('parent')->latest()->take(5)->get();

        return view('admin.dashboard', compact('stats', 'recentUsers', 'recentChildren'));
    }
}
