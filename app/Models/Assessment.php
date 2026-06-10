<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Assessment extends Model
{
    use HasFactory;

    protected $fillable = [
        'lesson_id', 'title', 'description', 'passing_score', 'time_limit', 'sort_order',
    ];

    public function lesson()
    {
        return $this->belongsTo(Lesson::class);
    }

    public function questions()
    {
        return $this->hasMany(AssessmentQuestion::class)->orderBy('sort_order');
    }

    public function attempts()
    {
        return $this->hasMany(AssessmentAttempt::class);
    }
}
