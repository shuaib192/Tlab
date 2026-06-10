<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use App\Models\ChildProfile;
use App\Models\Notification;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Barryvdh\DomPDF\Facade\Pdf;
use SimpleSoftwareIO\QrCode\Facades\QrCode;

class CertificateController extends Controller
{
    public function index(ChildProfile $child)
    {
        $this->authorize('view', $child);
        $certificates = $child->certificates()->with('course')->latest('issued_at')->get();
        return view('parent.certificates.index', compact('child', 'certificates'));
    }

    public function generate(Request $request, ChildProfile $child)
    {
        $this->authorize('view', $child);

        $request->validate([
            'course_id' => 'required|exists:courses,id',
            'grade' => 'nullable|string|max:50',
        ]);

        $existing = Certificate::where('child_profile_id', $child->id)
            ->where('course_id', $request->course_id)
            ->where('type', 'completion')
            ->first();

        if ($existing) {
            return back()->with('info', 'Certificate already exists.');
        }

        $certId = 'TLAB-' . strtoupper(Str::random(10));
        $course = \App\Models\Course::findOrFail($request->course_id);

        $certificate = Certificate::create([
            'certificate_id' => $certId,
            'child_profile_id' => $child->id,
            'course_id' => $course->id,
            'type' => 'completion',
            'title' => "{$course->title} - Completion",
            'grade' => $request->grade ?? 'Pass',
            'metadata' => [
                'child_name' => $child->name,
                'course_title' => $course->title,
                'rank' => $child->rank,
                'xp' => $child->xp,
            ],
            'issued_at' => now(),
        ]);

        Notification::create([
            'user_id' => $child->user_id,
            'type' => 'achievement',
            'title' => '🎉 Certificate Awarded!',
            'body' => "{$child->name} earned a certificate for completing {$course->title}!",
            'icon' => '📜',
            'link' => route('parent.certificates.index', $child),
        ]);

        return redirect()->route('parent.certificates.index', $child)
            ->with('success', 'Certificate generated successfully!');
    }

    public function download(Certificate $certificate)
    {
        $certificate->load(['child', 'course']);
        
        $verifyUrl = route('certificate.verify', $certificate->certificate_id);
        $qrCode = base64_encode(
            \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')->size(120)->generate($verifyUrl)
        );

        $pdf = Pdf::loadView('certificates.template', [
            'certificate' => $certificate,
            'verifyUrl' => $verifyUrl,
            'qrCode' => $qrCode,
        ]);

        $filename = "{$certificate->child->name}-{$certificate->course->title}-Certificate.pdf";
        return $pdf->download($filename);
    }

    public function verify($certificateId)
    {
        $certificate = Certificate::where('certificate_id', $certificateId)
            ->with(['child', 'course'])
            ->firstOrFail();

        return view('certificates.verify', compact('certificate'));
    }
}
