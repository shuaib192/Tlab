<?php

namespace App\Http\Controllers\School;

use App\Http\Controllers\Controller;
use App\Models\ChildProfile;
use App\Models\School;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

class StudentController extends Controller
{
    public function importForm()
    {
        $user = auth()->user();
        $school = $user->isSuperAdmin()
            ? School::findOrFail(request('school_id'))
            : School::find($user->school_id);

        return view('school.students.import', compact('school'));
    }

    public function importCsv(Request $request)
    {
        $user = auth()->user();
        $school = $user->isSuperAdmin()
            ? School::findOrFail($request->school_id)
            : School::find($user->school_id);

        $request->validate([
            'csv_file' => 'required|file|mimes:csv,txt|max:2048',
        ]);

        $file = $request->file('csv_file');
        $handle = fopen($file->getPathname(), 'r');
        $header = fgetcsv($handle);

        $expectedHeaders = ['name', 'email', 'password', 'child_name', 'child_dob', 'child_gender'];
        $headerIndex = [];
        foreach ($expectedHeaders as $h) {
            $pos = array_search($h, $header);
            if ($pos === false) {
                return back()->with('error', "Missing column: {$h}. Required: " . implode(', ', $expectedHeaders));
            }
            $headerIndex[$h] = $pos;
        }

        $imported = 0;
        $errors = [];
        $rowNum = 1;

        while (($row = fgetcsv($handle)) !== false) {
            $rowNum++;
            try {
                $name = trim($row[$headerIndex['name']]);
                $email = trim($row[$headerIndex['email']]);
                $password = trim($row[$headerIndex['password']]);
                $childName = trim($row[$headerIndex['child_name']]);
                $childDob = trim($row[$headerIndex['child_dob']]);
                $childGender = trim($row[$headerIndex['child_gender']] ?? 'prefer_not_to_say');

                if (empty($name) || empty($email)) {
                    continue;
                }

                $parent = User::firstOrCreate(
                    ['email' => $email],
                    [
                        'name' => $name,
                        'password' => Hash::make($password ?: Str::random(12)),
                        'role' => 'parent',
                        'school_id' => $school->id,
                        'school_name' => $school->name,
                    ]
                );

                if (!empty($childName)) {
                    $child = ChildProfile::firstOrCreate(
                        ['user_id' => $parent->id, 'name' => $childName],
                        [
                            'username' => strtolower(Str::slug($childName)) . '_' . Str::random(4),
                            'dob' => $childDob ?: null,
                            'gender' => in_array($childGender, ['male', 'female', 'prefer_not_to_say']) ? $childGender : 'prefer_not_to_say',
                            'pin' => Hash::make(substr($childDob, -4) ?: '1234'),
                            'pin_enabled' => true,
                        ]
                    );
                }

                $imported++;
            } catch (\Exception $e) {
                $errors[] = "Row {$rowNum}: {$e->getMessage()}";
            }
        }

        fclose($handle);

        $message = "Imported {$imported} records successfully.";
        if (!empty($errors)) {
            $message .= ' Errors: ' . implode('; ', array_slice($errors, 0, 5));
        }

        return redirect()->route('school.students', ['school_id' => $school->id])
            ->with('success', $message);
    }

    public function provisioning()
    {
        $user = auth()->user();
        $school = $user->isSuperAdmin()
            ? School::findOrFail(request('school_id'))
            : School::find($user->school_id);

        return view('school.students.provisioning', compact('school'));
    }

    public function provisionTeachers(Request $request)
    {
        $user = auth()->user();
        $school = $user->isSuperAdmin()
            ? School::findOrFail($request->school_id)
            : School::find($user->school_id);

        $request->validate([
            'teachers' => 'required|array',
            'teachers.*.name' => 'required|string|max:255',
            'teachers.*.email' => 'required|email|max:255',
        ]);

        $created = 0;
        foreach ($request->teachers as $t) {
            $teacher = User::firstOrCreate(
                ['email' => $t['email']],
                [
                    'name' => $t['name'],
                    'password' => Hash::make(Str::random(16)),
                    'role' => 'teacher',
                    'school_id' => $school->id,
                    'school_name' => $school->name,
                ]
            );
            if ($teacher->wasRecentlyCreated) {
                $teacher->update(['role' => 'teacher', 'school_id' => $school->id]);
                $created++;
            }
        }

        return redirect()->route('school.students', ['school_id' => $school->id])
            ->with('success', "{$created} teacher accounts provisioned.");
    }
}
