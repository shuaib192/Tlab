@extends('emails.layout')
@section('content')
<h2>Class Reminder! ⏰</h2>
<p>Hi there! This is a reminder that <strong>{{ $childName }}</strong> has a class coming up:</p>
<div class="details">
<dl>
<dt>Session</dt><dd>{{ $session->title }}</dd>
<dt>Date</dt><dd>{{ $session->date->format('l, F j, Y') }}</dd>
<dt>Time</dt><dd>{{ \Carbon\Carbon::parse($session->start_time)->format('g:i A') }} - {{ \Carbon\Carbon::parse($session->end_time)->format('g:i A') }}</dd>
@if($session->meeting_url)<dt>Meeting Link</dt><dd><a href="{{ $session->meeting_url }}" style="color:#16A34A">{{ $session->meeting_url }}</a></dd>@endif
</dl>
</div>
<p>Please make sure {{ $childName }} is ready and logged in on time!</p>
<a href="{{ route('parent.dashboard') }}" class="btn">View Dashboard</a>
@endsection
