<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Models\ChildProfile;
use App\Models\Club;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\XpLog;
use App\Models\AssessmentAttempt;

class DashboardController extends Controller
{
    public function index()
    {
        // Basic counts
        $stats = [
            'parents'     => User::where('role', 'parent')->count(),
            'children'    => ChildProfile::count(),
            'clubs'       => Club::count(),
            'courses'     => Course::count(),
            'enrollments' => Enrollment::count(),
            'paid'        => Enrollment::where('payment_status', 'paid')->count(),
            'teachers'    => User::where('role', 'teacher')->count(),
        ];

        // Revenue stats
        $revenue = [
            'total'    => Payment::where('status', 'success')->sum('amount'),
            'monthly'  => Payment::where('status', 'success')
                ->where('created_at', '>=', now()->startOfMonth())->sum('amount'),
            'count'    => Payment::where('status', 'success')->count(),
        ];

        // Growth (new users this month)
        $growth = [
            'new_parents'  => User::where('role', 'parent')->where('created_at', '>=', now()->startOfMonth())->count(),
            'new_children' => ChildProfile::where('created_at', '>=', now()->startOfMonth())->count(),
            'new_enrollments' => Enrollment::where('created_at', '>=', now()->startOfMonth())->count(),
        ];

        // XP stats
        $xpStats = [
            'total'    => XpLog::sum('amount'),
            'avg'      => round(XpLog::avg('amount') ?? 0),
            'top_child'=> ChildProfile::orderBy('xp', 'desc')->first(),
        ];

        // Assessment pass rate
        $totalAttempts = AssessmentAttempt::count();
        $passedAttempts = AssessmentAttempt::where('status', 'passed')->count();
        $passRate = $totalAttempts > 0 ? round(($passedAttempts / $totalAttempts) * 100) : 0;

        // Recent users and children
        $recentUsers    = User::latest()->take(5)->get();
        $recentChildren = ChildProfile::with('parent')->latest()->take(5)->get();

        // Recent payments
        $recentPayments = Payment::where('status', 'success')->with('user')->latest()->take(5)->get();

        // Monthly revenue chart data (last 6 months)
        $monthlyRevenue = [];
        for ($i = 5; $i >= 0; $i--) {
            $month = now()->subMonths($i);
            $revenue_amount = Payment::where('status', 'success')
                ->whereYear('created_at', $month->year)
                ->whereMonth('created_at', $month->month)
                ->sum('amount');
            $monthlyRevenue[] = [
                'month' => $month->format('M'),
                'amount' => $revenue_amount,
            ];
        }

        return view('admin.dashboard', compact(
            'stats', 'revenue', 'growth', 'xpStats', 'passRate',
            'recentUsers', 'recentChildren', 'recentPayments', 'monthlyRevenue'
        ));
    }
}
