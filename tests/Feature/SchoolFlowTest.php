<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SchoolFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_school_admin_without_school_is_redirected_not_500()
    {
        $admin = User::factory()->create(['role' => 'school_admin', 'school_id' => null]);

        $response = $this->actingAs($admin)->get(route('school.students'));
        $response->assertStatus(302);
    }

    public function test_school_admin_with_school_can_view_students()
    {
        $admin = User::factory()->create(['role' => 'school_admin', 'school_id' => 1, 'school_name' => 'Demo School']);

        $this->seedSchools();

        $response = $this->actingAs($admin)->get(route('school.students'));
        $response->assertStatus(200);
    }

    public function test_school_admin_with_school_can_view_dashboard()
    {
        $admin = User::factory()->create(['role' => 'school_admin', 'school_id' => 1, 'school_name' => 'Demo School']);

        $this->seedSchools();

        $response = $this->actingAs($admin)->get(route('school.dashboard'));
        $response->assertStatus(200);
    }

    protected function seedSchools()
    {
        if (\App\Models\School::where('id', 1)->exists()) {
            return;
        }

        \App\Models\School::create([
            'id' => 1,
            'name' => 'Demo School',
            'slug' => 'demo-school',
            'city' => 'Lagos',
            'state' => 'Lagos',
            'status' => 'active',
        ]);
    }
}
