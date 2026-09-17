<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ProgrammeRegistration;
use Illuminate\Http\Request;

class ProgrammeRegistrationController extends Controller
{
    public function index(Request $request)
    {
        $query = ProgrammeRegistration::latest();

        if ($request->filled('status') && in_array($request->status, ['pending', 'paid', 'failed'])) {
            $query->where('status', $request->status);
        }

        if ($request->filled('q')) {
            $term = trim($request->q);
            $query->where(function ($each) use ($term) {
                $each->where('child_name', 'like', "%{$term}%")
                    ->orWhere('parent_name', 'like', "%{$term}%")
                    ->orWhere('email', 'like', "%{$term}%")
                    ->orWhere('phone', 'like', "%{$term}%")
                    ->orWhere('reference', 'like', "%{$term}%");
            });
        }

        $registrations = $query->paginate(20)->withQueryString();
        $totalRevenue = ProgrammeRegistration::where('status', 'paid')->sum('amount');
        $pendingCount = ProgrammeRegistration::where('status', 'pending')->count();
        $paidCount = ProgrammeRegistration::where('status', 'paid')->count();
        $failedCount = ProgrammeRegistration::where('status', 'failed')->count();
        $totalCount = ProgrammeRegistration::count();

        return view('admin.programme-registrations.index', compact(
            'registrations', 'totalRevenue', 'pendingCount', 'paidCount', 'failedCount', 'totalCount'
        ));
    }

    public function show(ProgrammeRegistration $programmeRegistration)
    {
        return view('admin.programme-registrations.show', compact('programmeRegistration'));
    }

    public function verify(ProgrammeRegistration $programmeRegistration)
    {
        if ($programmeRegistration->status === 'paid') {
            return back()->with('error', 'This registration has already been marked as paid.');
        }

        $programmeRegistration->update([
            'status' => 'paid',
            'paid_at' => now(),
        ]);

        return back()->with('success', 'Registration marked as paid.');
    }
}
