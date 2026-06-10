<?php
namespace Database\Factories;
use App\Models\AssignmentSubmission;
use App\Models\Assignment;
use App\Models\ChildProfile;
use Illuminate\Database\Eloquent\Factories\Factory;
class AssignmentSubmissionFactory extends Factory
{
    protected $model = AssignmentSubmission::class;
    public function definition(): array
    {
        return [
            'assignment_id' => Assignment::factory(),
            'child_profile_id' => ChildProfile::factory(),
            'submission_text' => fake()->paragraph(),
            'status' => 'submitted',
            'submitted_at' => now(),
        ];
    }
}
