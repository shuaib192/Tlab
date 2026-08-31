@extends('emails.layout')
@section('content')
<h2>New Message from Teacher 📝</h2>
<p>You have received a new message from your child's teacher:</p>
<div class="details">
<dl>
<dt>From</dt><dd>{{ $log->teacher->name }}</dd>
<dt>Child</dt><dd>{{ $log->child->name }}</dd>
<dt>Subject</dt><dd>{{ $log->subject }}</dd>
<dt>Type</dt><dd>{{ ucfirst($log->type) }}</dd>
</dl>
</div>
<p>{{ $log->message }}</p>
<a href="{{ route('communications.index') }}" class="btn">View Message</a>
@endsection
