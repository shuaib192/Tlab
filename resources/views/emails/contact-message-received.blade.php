@extends('emails.layout')

@section('subtitle', 'New website enquiry')

@section('content')
<h2>New enquiry from the website</h2>

<p>{{ $contactMessage->name }} ({{ $contactMessage->email }}) sent the following message:</p>

<div class="details">
    <dt>Name</dt>
    <dd>{{ $contactMessage->name }}</dd>
    <dt>Email</dt>
    <dd>{{ $contactMessage->email }}</dd>
    <dt>Subject</dt>
    <dd>{{ $contactMessage->subject }}</dd>
    <dt>Received</dt>
    <dd>{{ $contactMessage->created_at->format('j M Y, H:i') }}</dd>
</div>

<h2>Message</h2>
<p style="white-space: pre-line;">{{ $contactMessage->message }}</p>

<a href="mailto:{{ $contactMessage->email }}" class="btn">Reply to {{ $contactMessage->name }}</a>
@endsection