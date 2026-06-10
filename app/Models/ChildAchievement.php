<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Relations\Pivot;

class ChildAchievement extends Pivot
{
    protected $table = 'child_achievements';

    protected $fillable = ['child_profile_id', 'achievement_id', 'earned_at'];

    protected $casts = ['earned_at' => 'datetime'];
}
