<?php

namespace App\Http\Controllers\School;

use App\Models\School;

trait ResolvesSchool
{
    protected function resolveSchool()
    {
        $user = auth()->user();

        $school = $user->isSuperAdmin()
            ? (request('school_id') ? School::findOrFail(request('school_id')) : null)
            : School::find($user->school_id);

        if (! $school) {
            return redirect()->route('school.dashboard')->with('error', 'No school is assigned to your account yet.');
        }

        return $school;
    }
}
