<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'icon', 'category', 'xp_reward'];

    public function children()
    {
        return $this->belongsToMany(ChildProfile::class, 'child_achievements')
            ->withPivot('earned_at')
            ->withTimestamps();
    }
}
