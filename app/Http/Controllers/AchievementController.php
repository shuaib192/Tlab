<?php

namespace App\Http\Controllers;

use App\Models\Achievement;
use App\Models\ChildProfile;
use App\Models\Notification;
use App\Models\XpLog;

class AchievementController extends Controller
{
    public function index(ChildProfile $child)
    {
        $this->authorize('view', $child);
        $achievements = Achievement::all();
        $earnedIds = $child->achievements->pluck('id')->toArray();
        $totalXpFromAchievements = $child->achievements->sum('xp_reward');

        return view('child.achievements', compact('child', 'achievements', 'earnedIds', 'totalXpFromAchievements'));
    }

    public static function checkAndAward(ChildProfile $child): array
    {
        $awarded = [];
        $achievements = Achievement::all();

        foreach ($achievements as $achievement) {
            if ($child->achievements->contains($achievement->id)) {
                continue;
            }

            $earned = false;
            switch ($achievement->slug) {
                case 'first-xp':
                    $earned = $child->xp > 0;
                    break;
                case 'xp-100':
                    $earned = $child->xp >= 100;
                    break;
                case 'xp-500':
                    $earned = $child->xp >= 500;
                    break;
                case 'xp-1000':
                    $earned = $child->xp >= 1000;
                    break;
                case 'first-course':
                    $earned = $child->enrollments()->count() >= 1;
                    break;
                case 'course-complete':
                    $earned = $child->enrollments()->where('status', 'completed')->count() >= 1;
                    break;
                case 'attendance-5':
                    $earned = $child->attendance()->where('status', 'present')->count() >= 5;
                    break;
                case 'attendance-10':
                    $earned = $child->attendance()->where('status', 'present')->count() >= 10;
                    break;
                case 'assessment-pass':
                    $earned = $child->assessmentAttempts()->where('status', 'passed')->count() >= 1;
                    break;
                case 'assessment-perfect':
                    $earned = $child->assessmentAttempts()
                        ->where('status', 'passed')
                        ->whereColumn('score', 'total')
                        ->count() >= 1;
                    break;
                case 'rank-innovator':
                    $earned = in_array($child->rank, ['Innovator', 'Builder', 'Creator', 'Master Inventor']);
                    break;
                case 'rank-builder':
                    $earned = in_array($child->rank, ['Builder', 'Creator', 'Master Inventor']);
                    break;
                case 'rank-creator':
                    $earned = in_array($child->rank, ['Creator', 'Master Inventor']);
                    break;
                case 'rank-master':
                    $earned = $child->rank === 'Master Inventor';
                    break;
            }

            if ($earned) {
                $child->achievements()->attach($achievement->id, ['earned_at' => now()]);
                if ($achievement->xp_reward > 0) {
                    $child->increment('xp', $achievement->xp_reward);
                    XpLog::create([
                        'child_profile_id' => $child->id,
                        'amount' => $achievement->xp_reward,
                        'activity' => "Achievement: {$achievement->name}",
                    ]);
                    $child->refresh();
                }
                Notification::create([
                    'user_id' => $child->user_id,
                    'type' => 'achievement',
                    'title' => "🏆 {$achievement->name} Unlocked!",
                    'body' => "{$child->name} earned the '{$achievement->name}' badge".
                        ($achievement->xp_reward > 0 ? " (+{$achievement->xp_reward} XP)" : '').'!',
                    'icon' => $achievement->icon ?? '🏆',
                    'link' => route('child.achievements', $child),
                ]);
                $awarded[] = $achievement->name;
            }
        }

        return $awarded;
    }
}
