<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Hash;

class ChildProfile extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'name',
        'username',
        'dob',
        'gender',
        'interests',
        'skill_level',
        'xp',
        'rank',
        'pin',
        'pin_enabled',
        'avatar',
    ];

    protected $casts = [
        'dob' => 'date',
        'interests' => 'array',
        'pin_enabled' => 'boolean',
    ];

    // --- Rank thresholds ---
    const RANKS = [
        'Explorer' => 0,
        'Innovator' => 200,
        'Builder' => 500,
        'Creator' => 1000,
        'Master Inventor' => 2000,
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

    public function attendance()
    {
        return $this->hasMany(Attendance::class, 'child_profile_id');
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class, 'child_profile_id');
    }

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'child_achievements')
            ->withPivot('earned_at')
            ->withTimestamps();
    }

    public function assignmentSubmissions()
    {
        return $this->hasMany(AssignmentSubmission::class, 'child_profile_id');
    }

    public function assessmentAttempts()
    {
        return $this->hasMany(AssessmentAttempt::class, 'child_profile_id');
    }

    // --- Helpers ---

    public function verifyPin(string $pin): bool
    {
        if (! $this->pin_enabled || ! $this->pin) {
            return false;
        }
        if (Hash::check($pin, $this->pin)) {
            return true;
        }
        if ($this->pin === $pin) {
            $this->update(['pin' => Hash::make($pin)]);

            return true;
        }

        return false;
    }

    public function awardXp(int $amount, string $activity)
    {
        $oldRank = $this->rank;
        $this->increment('xp', $amount);
        $this->xpLogs()->create(['amount' => $amount, 'activity' => $activity]);
        $this->updateRank();
        \App\Http\Controllers\AchievementController::checkAndAward($this);
        \App\Models\Streak::recordActivity($this->id);
    }

    public function updateRank()
    {
        $rank = 'Explorer';
        foreach (self::RANKS as $name => $threshold) {
            if ($this->xp >= $threshold) {
                $rank = $name;
            }
        }
        if ($rank !== $this->rank) {
            $this->update(['rank' => $rank]);
            \App\Http\Controllers\AchievementController::checkAndAward($this);
        } elseif ($this->rank !== $rank) {
            $this->update(['rank' => $rank]);
        }
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
        if ($next === $current) {
            return 100;
        }

        return min(100, round((($this->xp - $current) / ($next - $current)) * 100));
    }
}
