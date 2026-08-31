@extends('emails.layout')
@section('content')
<h2>Certificate Awarded! 📜</h2>
<p>Congratulations! <strong>{{ $certificate->child->name }}</strong> has earned a certificate for completing <strong>{{ $certificate->course->title }}</strong>!</p>
<div class="details">
<dl>
<dt>Certificate ID</dt><dd>{{ $certificate->certificate_id }}</dd>
<dt>Course</dt><dd>{{ $certificate->course->title }}</dd>
<dt>Grade</dt><dd>{{ $certificate->grade ?? 'Pass' }}</dd>
<dt>Date</dt><dd>{{ $certificate->issued_at->format('F j, Y') }}</dd>
</dl>
</div>
<p>You can download the certificate from your parent dashboard.</p>
<a href="{{ route('parent.certificates.index', $certificate->child) }}" class="btn">Download Certificate</a>
@endsection
