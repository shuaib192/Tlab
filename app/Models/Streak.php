<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Streak extends Model
{
    use HasFactory;

    protected $fillable = ['child_profile_id', 'current_streak', 'longest_streak', 'last_activity_date'];

    protected $casts = ['last_activity_date' => 'date'];

    public function child()
    {
        return $this->belongsTo(ChildProfile::class);
    }

    public static function recordActivity($childId)
    {
        $streak = static::firstOrCreate(['child_profile_id' => $childId]);
        $yesterday = now()->subDay()->toDateString();
        $today = now()->toDateString();

        if ($streak->last_activity_date?->toDateString() === $yesterday) {
            $streak->current_streak++;
        } elseif ($streak->last_activity_date?->toDateString() !== $today) {
            $streak->current_streak = 1;
        }

        if ($streak->current_streak > $streak->longest_streak) {
            $streak->longest_streak = $streak->current_streak;
        }

        $streak->last_activity_date = now();
        $streak->save();

        return $streak;
    }
}
