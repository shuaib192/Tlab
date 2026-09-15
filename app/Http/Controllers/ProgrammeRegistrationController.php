<?php

namespace App\Http\Controllers;

use App\Models\ProgrammeRegistration;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Unicodeveloper\Paystack\Facades\Paystack;

class ProgrammeRegistrationController extends Controller
{
    public const PAYMENT_OPTIONS = [
        'monthly' => ['label' => '₦10,000 monthly', 'amount' => 10000, 'note' => 'Three monthly payments for three months'],
        'full' => ['label' => '₦30,000 full payment', 'amount' => 30000, 'note' => 'One-time payment for the full programme'],
    ];

    public static function programmes(): array
    {
        return [
            ['key' => 'code-scratchjr', 'name' => 'Coding Foundations with ScratchJr', 'band' => '5–7', 'min' => 5, 'max' => 7],
            ['key' => 'digital-creativity', 'name' => 'Digital Creativity', 'band' => '5–7', 'min' => 5, 'max' => 7],
            ['key' => 'reading-foundations', 'name' => 'Reading Foundations', 'band' => '5–7', 'min' => 5, 'max' => 7],
            ['key' => 'scratch', 'name' => 'Scratch Programming', 'band' => '8–11', 'min' => 8, 'max' => 11],
            ['key' => 'python-foundations', 'name' => 'Python Foundations', 'band' => '8–11', 'min' => 8, 'max' => 11],
            ['key' => 'canva-design', 'name' => 'Digital Design with Canva', 'band' => '8–11', 'min' => 8, 'max' => 11],
            ['key' => 'creative-writing', 'name' => 'Creative Writing', 'band' => '8–11', 'min' => 8, 'max' => 11],
            ['key' => 'reading-dev-8', 'name' => 'Reading Development', 'band' => '8–11', 'min' => 8, 'max' => 11],
            ['key' => 'python', 'name' => 'Python Programming', 'band' => '12–17', 'min' => 12, 'max' => 17],
            ['key' => 'digital-design', 'name' => 'Digital Design', 'band' => '12–17', 'min' => 12, 'max' => 17],
            ['key' => 'writing-authoring', 'name' => 'Writing and Authoring', 'band' => '12–17', 'min' => 12, 'max' => 17],
            ['key' => 'reading-dev-12', 'name' => 'Reading Development', 'band' => '12–17', 'min' => 12, 'max' => 17],
        ];
    }

    public function landing()
    {
        return view('programme-landing');
    }

    public function enrol()
    {
        return view('enrol');
    }

    public function store(Request $request)
    {
        $programmes = collect(self::programmes());

        $validated = $request->validate([
            'parent_name' => 'required|string|max:120',
            'phone' => 'required|string|max:30',
            'email' => 'required|email|max:150',
            'child_name' => 'required|string|max:120',
            'child_age' => 'required|integer|min:5|max:17',
            'programme' => 'required|string|max:80',
            'device' => 'required|in:laptop,tablet,smartphone',
            'payment_option' => 'required|in:monthly,full',
            'consent' => 'required|accepted',
        ]);

        $programme = $programmes->firstWhere('key', $validated['programme']);

        if (! $programme || $validated['child_age'] < $programme['min'] || $validated['child_age'] > $programme['max']) {
            return back()->withErrors(['programme' => 'Please select a programme that matches your child\'s age.'])
                ->withInput();
        }

        $option = self::PAYMENT_OPTIONS[$validated['payment_option']];
        $reference = 'TLAB-PRG-'.strtoupper(Str::random(10));

        $registration = ProgrammeRegistration::create([
            'parent_name' => $validated['parent_name'],
            'phone' => $validated['phone'],
            'email' => $validated['email'],
            'child_name' => $validated['child_name'],
            'child_age' => $validated['child_age'],
            'programme' => $programme['name'],
            'device' => $validated['device'],
            'payment_option' => $validated['payment_option'],
            'amount' => $option['amount'],
            'status' => 'pending',
            'reference' => $reference,
        ]);

        try {
            $paystack = Paystack::getAuthorizationUrl([
                'amount' => $option['amount'] * 100,
                'email' => $validated['email'],
                'reference' => $reference,
                'currency' => 'NGN',
                'metadata' => json_encode([
                    'programme_registration_id' => $registration->id,
                    'programme' => $programme['name'],
                    'child_name' => $validated['child_name'],
                    'parent_email' => $validated['email'],
                ]),
                'callback_url' => route('payment.callback'),
            ]);

            return redirect()->away($paystack->url);
        } catch (\Exception $e) {
            $registration->update(['status' => 'failed']);

            return back()->with('error', 'Unable to initialize payment. Please try again.');
        }
    }

    public function success(Request $request)
    {
        $registration = null;

        if ($request->filled('reference')) {
            $registration = ProgrammeRegistration::where('reference', $request->reference)->first();
        }

        return view('enrol-success', compact('registration'));
    }
}
