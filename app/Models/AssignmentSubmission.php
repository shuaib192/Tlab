<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id', 'child_profile_id', 'submission_text',
        'file_url', 'score', 'feedback', 'status', 'submitted_at',
    ];

    protected $casts = ['submitted_at' => 'datetime'];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }
}
