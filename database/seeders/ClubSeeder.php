<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Club;
use App\Models\Course;

class ClubSeeder extends Seeder
{
    public function run(): void
    {
        $clubs = [
            [
                'name'        => 'STEM Club',
                'slug'        => 'stem-club',
                'description' => 'Robotics, Python, Scratch, and Science experiments for ages 7–15.',
                'color_theme' => '#4E9966',
                'icon'        => 'chip',
                'courses' => [
                    ['title' => 'Introduction to Scratch', 'level' => 'beginner'],
                    ['title' => 'Python for Kids',         'level' => 'intermediate'],
                    ['title' => 'Robotics Fundamentals',   'level' => 'intermediate'],
                    ['title' => 'Science Experiments Lab', 'level' => 'beginner'],
                ],
            ],
            [
                'name'        => 'Brain Club',
                'slug'        => 'brain-club',
                'description' => 'Logic, Math Olympiad, Puzzles and Lateral Thinking for ages 5–15.',
                'color_theme' => '#D4A224',
                'icon'        => 'lightbulb',
                'courses' => [
                    ['title' => 'Math Foundations',       'level' => 'beginner'],
                    ['title' => 'Math Olympiad Prep',     'level' => 'advanced'],
                    ['title' => 'Logic and Puzzles',      'level' => 'beginner'],
                    ['title' => 'Lateral Thinking Mastery','level' => 'intermediate'],
                ],
            ],
            [
                'name'        => 'Art & Craft Club',
                'slug'        => 'art-craft-club',
                'description' => 'Canva Design, Lego StoryStarter and Creative Expression for ages 3–12.',
                'color_theme' => '#C24B1E',
                'icon'        => 'pencil',
                'courses' => [
                    ['title' => 'Canva for Kids',          'level' => 'beginner'],
                    ['title' => 'Lego StoryStarter',       'level' => 'beginner'],
                    ['title' => 'Drawing and Illustration','level' => 'beginner'],
                    ['title' => 'Digital Design Basics',   'level' => 'intermediate'],
                ],
            ],
            [
                'name'        => 'Leadership Club',
                'slug'        => 'leadership-club',
                'description' => 'Debate, Confidence Building, Entrepreneurship and Communication for ages 8–15.',
                'color_theme' => '#6B3FA0',
                'icon'        => 'users',
                'courses' => [
                    ['title' => 'Public Speaking Foundations', 'level' => 'beginner'],
                    ['title' => 'Debate Mastery',              'level' => 'intermediate'],
                    ['title' => 'Young Entrepreneurs',         'level' => 'intermediate'],
                    ['title' => 'Confidence & Communication',  'level' => 'beginner'],
                ],
            ],
        ];

        foreach ($clubs as $clubData) {
            $courses = $clubData['courses'];
            unset($clubData['courses']);

            $club = Club::updateOrCreate(
                ['slug' => $clubData['slug']],
                $clubData
            );

            foreach ($courses as $course) {
                Course::updateOrCreate(
                    ['slug' => $club->slug . '-' . \Illuminate\Support\Str::slug($course['title'])],
                    array_merge($course, ['club_id' => $club->id])
                );
            }
        }
    }
}
