<?php

namespace App\Http\Controllers;

use App\Models\ChildProfile;
use App\Models\User;
use Illuminate\Http\Request;

class ComplianceController extends Controller
{
    public function privacy()
    {
        return view('pages.privacy');
    }

    public function consent()
    {
        return view('pages.consent');
    }

    public function recordConsent(Request $request)
    {
        $request->validate([
            'child_id' => 'required|exists:child_profiles,id',
            'consent_given' => 'required|boolean',
        ]);

        $child = ChildProfile::findOrFail($request->child_id);

        if ($child->user_id !== auth()->id()) {
            abort(403);
        }

        $metadata = $child->metadata ?? [];
        $metadata['parental_consent'] = $request->consent_given;
        $metadata['consent_date'] = now()->toDateTimeString();
        $metadata['consent_ip'] = $request->ip();
        $child->metadata = $metadata;
        $child->save();

        return back()->with('success', 'Parental consent ' . ($request->consent_given ? 'granted' : 'withdrawn') . '.');
    }

    public function requestDeletion(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
        ]);

        $user = User::findOrFail($request->user_id);

        if (!auth()->user()->isSuperAdmin()) {
            abort(403);
        }

        $user->children()->delete();
        $user->payments()->delete();
        $user->subscriptions()->delete();
        $user->notifications()->delete();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'User data deleted per GDPR/COPPA request.');
    }

    public function ageGate(Request $request)
    {
        $request->validate([
            'dob' => 'required|date',
        ]);

        $age = \Carbon\Carbon::parse($request->dob)->age;

        if ($age < 13) {
            return response()->json([
                'requires_consent' => true,
                'message' => 'Parental consent is required for children under 13.',
            ]);
        }

        return response()->json([
            'requires_consent' => false,
            'message' => 'Age verified.',
        ]);
    }
}
