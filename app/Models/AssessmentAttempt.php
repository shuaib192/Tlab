<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentAttempt extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id', 'child_profile_id', 'answers', 'score', 'total', 'status',
        'started_at', 'completed_at',
    ];

    protected $casts = [
        'answers' => 'array',
        'started_at' => 'datetime',
        'completed_at' => 'datetime',
    ];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }
}
