<?php

namespace Database\Factories;

use App\Models\Club;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;

class CourseFactory extends Factory
{
    protected $model = Course::class;

    public function definition(): array
    {
        return [
            'title' => fake()->sentence(3),
            'slug' => fake()->unique()->slug(),
            'club_id' => Club::factory(),
            'is_published' => true,
        ];
    }
}
