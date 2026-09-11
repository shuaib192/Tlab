<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class AssignmentSubmission extends Model
{
    use HasFactory;

    protected $fillable = [
        'assignment_id', 'child_profile_id', 'version', 'submission_text',
        'file_url', 'files_json', 'link_url', 'link_note', 'canvas_path', 'canvas_bg',
        'score', 'feedback', 'status', 'submitted_at', 'submitted_late',
    ];

    protected $casts = [
        'submitted_at' => 'datetime',
        'submitted_late' => 'boolean',
        'files_json' => 'array',
    ];

    public function assignment()
    {
        return $this->belongsTo(Assignment::class);
    }

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function files(): HasMany
    {
        return $this->hasMany(SubmissionFile::class, 'submission_id');
    }

    public function isLate(): bool
    {
        if (! $this->assignment->due_date || ! $this->submitted_at) {
            return false;
        }

        return $this->submitted_at->gt($this->assignment->due_date->endOfDay());
    }
}
