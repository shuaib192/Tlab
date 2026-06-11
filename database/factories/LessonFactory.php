<?php

namespace Database\Factories;

use App\Models\Lesson;
use App\Models\Module;
use Illuminate\Database\Eloquent\Factories\Factory;

class LessonFactory extends Factory
{
    protected $model = Lesson::class;

    public function definition(): array
    {
        return [
            'module_id' => Module::factory(),
            'title' => fake()->sentence(3),
            'slug' => fake()->unique()->slug(),
            'content' => fake()->paragraphs(3, true),
            'type' => 'video',
            'sort_order' => fake()->numberBetween(1, 10),
            'is_published' => true,
        ];
    }
}
