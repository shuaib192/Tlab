<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AchievementSeeder extends Seeder
{
    public function run(): void
    {
        $achievements = [
            ['name' => 'First Steps', 'slug' => 'first-xp', 'description' => 'Earn your first XP', 'icon' => '🌟', 'category' => 'xp', 'xp_reward' => 10],
            ['name' => 'Century Club', 'slug' => 'xp-100', 'description' => 'Reach 100 XP', 'icon' => '💯', 'category' => 'xp', 'xp_reward' => 25],
            ['name' => 'Half Mill', 'slug' => 'xp-500', 'description' => 'Reach 500 XP', 'icon' => '🔥', 'category' => 'xp', 'xp_reward' => 50],
            ['name' => 'XP Master', 'slug' => 'xp-1000', 'description' => 'Reach 1000 XP', 'icon' => '👑', 'category' => 'xp', 'xp_reward' => 100],

            ['name' => 'First Course', 'slug' => 'first-course', 'description' => 'Enroll in your first course', 'icon' => '📚', 'category' => 'learning', 'xp_reward' => 15],
            ['name' => 'Course Complete', 'slug' => 'course-complete', 'description' => 'Complete a full course', 'icon' => '🎓', 'category' => 'learning', 'xp_reward' => 50],

            ['name' => 'Dedicated Learner', 'slug' => 'attendance-5', 'description' => 'Attend 5 sessions', 'icon' => '📋', 'category' => 'attendance', 'xp_reward' => 20],
            ['name' => 'Super Attendee', 'slug' => 'attendance-10', 'description' => 'Attend 10 sessions', 'icon' => '⭐', 'category' => 'attendance', 'xp_reward' => 40],

            ['name' => 'Quiz Taker', 'slug' => 'assessment-pass', 'description' => 'Pass your first assessment', 'icon' => '✅', 'category' => 'assessment', 'xp_reward' => 20],
            ['name' => 'Perfect Score', 'slug' => 'assessment-perfect', 'description' => 'Score 100% on any assessment', 'icon' => '🏅', 'category' => 'assessment', 'xp_reward' => 50],

            ['name' => 'Innovator Rising', 'slug' => 'rank-innovator', 'description' => 'Reach Innovator rank', 'icon' => '⚡', 'category' => 'rank', 'xp_reward' => 30],
            ['name' => 'Builder Status', 'slug' => 'rank-builder', 'description' => 'Reach Builder rank', 'icon' => '🔨', 'category' => 'rank', 'xp_reward' => 60],
            ['name' => 'Creator Unlocked', 'slug' => 'rank-creator', 'description' => 'Reach Creator rank', 'icon' => '🎨', 'category' => 'rank', 'xp_reward' => 100],
            ['name' => 'Master Inventor', 'slug' => 'rank-master', 'description' => 'Reach Master Inventor rank', 'icon' => '🚀', 'category' => 'rank', 'xp_reward' => 200],
        ];

        foreach ($achievements as $achievement) {
            DB::table('achievements')->updateOrInsert(
                ['slug' => $achievement['slug']],
                $achievement
            );
        }
    }
}
