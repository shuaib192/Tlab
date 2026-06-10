<?php
namespace Database\Factories;
use App\Models\Enrollment;
use App\Models\ChildProfile;
use App\Models\Course;
use Illuminate\Database\Eloquent\Factories\Factory;
class EnrollmentFactory extends Factory
{
    protected $model = Enrollment::class;
    public function definition(): array
    {
        return [
            'child_profile_id' => ChildProfile::factory(),
            'course_id' => Course::factory(),
            'status' => 'active',
            'payment_status' => 'paid',
        ];
    }
}
