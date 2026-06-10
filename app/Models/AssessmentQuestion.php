<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AssessmentQuestion extends Model
{
    use HasFactory;

    protected $fillable = [
        'assessment_id', 'question', 'type', 'options', 'correct_answer', 'points', 'sort_order',
    ];

    protected $casts = ['options' => 'array'];

    public function assessment()
    {
        return $this->belongsTo(Assessment::class);
    }
}
