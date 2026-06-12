<?php

namespace Tests\Feature;

use App\Models\ChildProfile;
use App\Models\User;
use App\Services\EdfricaAuthService;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ParentFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_parent_can_register()
    {
        $this->mock(EdfricaAuthService::class, function ($mock) {
            $mock->shouldReceive('register')
                ->once()
                ->andReturn([
                    'user' => [
                        'id' => 999,
                        'name' => 'Test Parent',
                        'email' => 'parent@test.com',
                        'role' => 'parent',
                    ],
                    'access_token' => 'fake-token',
                ]);
        });

        $response = $this->post('/signup', [
            'name' => 'Test Parent',
            'email' => 'parent@test.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => '1',
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
            'gender' => 'male',
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
