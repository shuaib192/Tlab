<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ChildProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'dob',
        'gender',
        'interests',
        'skill_level',
        'xp',
        'rank',
        'pin',
        'avatar',
    ];

    protected $casts = [
        'dob' => 'date',
        'interests' => 'array',
    ];

    // --- Rank thresholds ---
    const RANKS = [
        'Explorer'       => 0,
        'Innovator'      => 200,
        'Builder'        => 500,
        'Creator'        => 1000,
        'Master Inventor'=> 2000,
    ];

    // --- Relationships ---

    public function parent()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function xpLogs()
    {
        return $this->hasMany(XpLog::class);
    }

    public function courses()
    {
        return $this->belongsToMany(Course::class, 'enrollments', 'child_profile_id', 'course_id');
    }

    // --- Helpers ---

    public function awardXp(int $amount, string $activity)
    {
        $this->increment('xp', $amount);
        $this->xpLogs()->create(['amount' => $amount, 'activity' => $activity]);
        $this->updateRank();
    }

    public function updateRank()
    {
        $rank = 'Explorer';
        foreach (self::RANKS as $name => $threshold) {
            if ($this->xp >= $threshold) {
                $rank = $name;
            }
        }
        $this->update(['rank' => $rank]);
    }

    public function getAgeAttribute()
    {
        return $this->dob ? $this->dob->age : null;
    }

    public function getXpToNextRankAttribute()
    {
        $thresholds = array_values(self::RANKS);
        foreach ($thresholds as $t) {
            if ($this->xp < $t) {
                return $t - $this->xp;
            }
        }
        return 0;
    }

    public function getRankProgressAttribute()
    {
        $ranks = array_values(self::RANKS);
        $current = 0;
        $next = 0;
        foreach ($ranks as $i => $t) {
            if ($this->xp >= $t) {
                $current = $t;
                $next = $ranks[$i + 1] ?? $t;
            }
        }
        if ($next === $current) return 100;
        return min(100, round((($this->xp - $current) / ($next - $current)) * 100));
    }
}
