<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SessionRedirectTest extends TestCase
{
    use RefreshDatabase;

    public function test_authenticated_super_admin_visiting_login_goes_to_admin_not_parent()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);

        $response = $this->actingAs($admin)->get(route('login'));
        $response->assertRedirect(route('admin.dashboard'));

        $this->actingAs($admin)->get(route('admin.dashboard'))->assertStatus(200);
    }

    public function test_authenticated_teacher_visiting_login_goes_to_teacher_not_parent_no_loop()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)->get(route('login'));
        $response->assertRedirect(route('teacher.dashboard'));

        $this->actingAs($teacher)->get(route('teacher.dashboard'))->assertStatus(200);
    }

    public function test_authenticated_school_admin_visiting_login_goes_to_school_not_parent_no_loop()
    {
        $schoolAdmin = User::factory()->create(['role' => 'school_admin', 'school_id' => 1, 'school_name' => 'Demo School']);

        if (! \App\Models\School::where('id', 1)->exists()) {
            \App\Models\School::create([
                'id' => 1,
                'name' => 'Demo School',
                'slug' => 'demo-school',
                'city' => 'Lagos',
                'state' => 'Lagos',
                'status' => 'active',
            ]);
        }

        $response = $this->actingAs($schoolAdmin)->get(route('login'));
        $response->assertRedirect(route('school.dashboard'));

        $this->actingAs($schoolAdmin)->get(route('school.dashboard'))->assertStatus(200);
    }

    public function test_inactive_user_is_logged_out_by_idle_timeout()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher)->get(route('teacher.dashboard'));
        session()->put('last_activity_at', time() - (31 * 60));

        $response = $this->actingAs($teacher)->get(route('teacher.dashboard'));
        $response->assertRedirect(route('login'));
        $this->assertGuest();
    }

    public function test_active_user_is_not_logged_out()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher)->get(route('teacher.dashboard'));
        session()->put('last_activity_at', time());

        $this->actingAs($teacher)->get(route('teacher.dashboard'))->assertStatus(200);
        $this->assertAuthenticatedAs($teacher);
    }
}