<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use App\Models\ChildProfile;
use App\Models\Course;
use App\Models\Enrollment;
use Illuminate\Foundation\Testing\RefreshDatabase;

class ParentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_can_register()
    {
        $response = $this->post('/signup', [
            'name' => 'Test Parent',
            'email' => 'parent@test.com',
            'password' => 'password',
            'password_confirmation' => 'password',
        ]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('users', ['email' => 'parent@test.com']);
    }

    public function test_parent_can_view_dashboard()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $response = $this->actingAs($user)->get(route('parent.dashboard'));
        $response->assertStatus(200);
    }

    public function test_parent_can_add_child()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $response = $this->actingAs($user)->post(route('parent.children.store'), [
            'name' => 'Test Child',
            'username' => 'testchild',
            'dob' => '2015-01-01',
        ]);
        $response->assertSessionHasNoErrors();
        $this->assertDatabaseHas('child_profiles', ['username' => 'testchild']);
    }

    public function test_parent_can_switch_to_child()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->create(['user_id' => $user->id]);
        $response = $this->actingAs($user)->get(route('parent.children.switch', $child));
        $response->assertRedirect();
        $this->assertEquals(session('active_child_id'), $child->id);
    }

    public function test_parent_can_browse_courses()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $response = $this->actingAs($user)->get(route('parent.courses.index'));
        $response->assertStatus(200);
    }

    public function test_parent_can_view_subscription()
    {
        $user = User::factory()->create(['role' => 'parent']);
        $response = $this->actingAs($user)->get(route('parent.subscription'));
        $response->assertStatus(200);
    }
}
