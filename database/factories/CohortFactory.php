<?php
namespace Database\Factories;
use App\Models\Cohort;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
class CohortFactory extends Factory
{
    protected $model = Cohort::class;
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'name' => fake()->word() . ' Cohort',
            'slug' => fake()->unique()->slug(),
            'status' => 'active',
        ];
    }
}
