<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProgramGrowthStage extends Model
{
    use HasFactory;

    protected $fillable = [
        'program_id',
        'stage_name',
        'age_band',
        'min_age',
        'max_age',
        'focus_title',
        'description',
        'skills',
        'milestones',
        'tools_used',
        'featured_project',
        'sort_order',
    ];

    protected $casts = [
        'skills' => 'array',
        'milestones' => 'array',
        'tools_used' => 'array',
        'min_age' => 'integer',
        'max_age' => 'integer',
        'sort_order' => 'integer',
    ];

    public function program(): BelongsTo
    {
        return $this->belongsTo(Program::class);
    }
}
