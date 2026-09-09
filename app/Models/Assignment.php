<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assignment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id', 'title', 'instructions', 'type', 'due_date', 'max_score',
        'is_published', 'published_at',
    ];

    protected $casts = [
        'due_date' => 'date',
        'published_at' => 'datetime',
        'is_published' => 'boolean',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function submissions()
    {
        return $this->hasMany(AssignmentSubmission::class);
    }

    public function acceptsFiles(): bool
    {
        return in_array($this->type, ['file', 'both']);
    }

    public function acceptsLinks(): bool
    {
        return in_array($this->type, ['link', 'both']);
    }
}
