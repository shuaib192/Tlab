<?php
namespace Tests\Feature;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AdminFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_dashboard()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $response = $this->actingAs($admin)->get(route('admin.dashboard'));
        $response->assertStatus(200);
    }

    public function test_admin_can_manage_clubs()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $response = $this->actingAs($admin)->get(route('admin.clubs.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_manage_users()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $response = $this->actingAs($admin)->get(route('admin.users.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_manage_courses()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $response = $this->actingAs($admin)->get(route('admin.courses.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_view_payments()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $response = $this->actingAs($admin)->get(route('admin.payments.index'));
        $response->assertStatus(200);
    }

    public function test_admin_can_manage_safe_links()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        $response = $this->actingAs($admin)->get(route('admin.safety.safe-links'));
        $response->assertStatus(200);
    }
}
