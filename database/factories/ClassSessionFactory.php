<?php
namespace Database\Factories;
use App\Models\ClassSession;
use App\Models\Course;
use App\Models\Cohort;
use Illuminate\Database\Eloquent\Factories\Factory;
class ClassSessionFactory extends Factory
{
    protected $model = ClassSession::class;
    public function definition(): array
    {
        return [
            'course_id' => Course::factory(),
            'cohort_id' => Cohort::factory(),
            'title' => fake()->sentence(3),
            'date' => fake()->date(),
            'start_time' => fake()->time('H:i'),
            'end_time' => fake()->time('H:i'),
            'status' => 'scheduled',
        ];
    }
}
