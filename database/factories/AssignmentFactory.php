<?php
namespace Database\Factories;
use App\Models\Assignment;
use App\Models\Lesson;
use Illuminate\Database\Eloquent\Factories\Factory;
class AssignmentFactory extends Factory
{
    protected $model = Assignment::class;
    public function definition(): array
    {
        return [
            'lesson_id' => Lesson::factory(),
            'title' => fake()->sentence(3),
            'instructions' => fake()->paragraph(),
            'type' => 'project',
            'max_score' => 100,
        ];
    }
}
