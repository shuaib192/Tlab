@extends('emails.layout')
@section('content')
<h2>Achievement Unlocked</h2>
<p>Great news! <strong>{{ $child->name }}</strong> has unlocked a new achievement:</p>
<div class="details">
<dl>
<dt>Achievement</dt><dd>{{ $achievement->name }}</dd>
<dt>Description</dt><dd>{{ $achievement->description ?? 'Completed a major milestone!' }}</dd>
@if($achievement->xp_reward > 0)<dt>XP Reward</dt><dd>+{{ $achievement->xp_reward }} XP</dd>@endif
</dl>
</div>
<p>Keep up the amazing work!</p>
<a href="{{ route('child.achievements', $child) }}" class="btn">View Achievements</a>
@endsection
