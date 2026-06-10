<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\ChildProfile;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ChildFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_child_can_login_with_pin()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->create([
            'user_id' => $user->id,
            'pin' => '1234',
            'pin_enabled' => true,
        ]);

        $response = $this->post(route('child.login.submit'), [
            'username' => $child->username,
            'pin' => '1234',
        ]);
        $response->assertSessionHasNoErrors();
    }

    public function test_child_can_view_dashboard()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->create(['user_id' => $user->id]);

        $response = $this->actingAs($user)
            ->withSession(['active_child_id' => $child->id])
            ->get(route('child.dashboard'));
        $response->assertStatus(200);
    }

    public function test_child_can_view_course()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->create(['user_id' => $user->id]);
        $course = Course::factory()->create();
        $enrollment = Enrollment::factory()->create([
            'child_profile_id' => $child->id,
            'course_id' => $course->id,
        ]);

        $response = $this->withSession(['active_child_id' => $child->id])
            ->get(route('child.course', $enrollment));
        $response->assertStatus(200);
    }
}
