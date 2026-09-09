@extends('emails.layout')
@section('content')
<h2>Assignment Graded</h2>
<p>Your child's assignment has been graded by the teacher:</p>
<div class="details">
<dl>
    <dt>Child</dt><dd>{{ $submission->child->name }}</dd>
    <dt>Assignment</dt><dd>{{ $submission->assignment->title }}</dd>
    <dt>Score</dt><dd>{{ $submission->score }} / {{ $submission->assignment->max_score }}</dd>
    <dt>Status</dt><dd>{{ ucfirst(str_replace('_', ' ', $submission->status)) }}</dd>
    @if($submission->feedback)
        <dt>Feedback</dt><dd>{{ $submission->feedback }}</dd>
    @endif
</dl>
</div>
<p>Keep up the great learning journey!</p>
<a href="{{ route('communications.index') }}" class="btn">View Messages</a>
@endsection