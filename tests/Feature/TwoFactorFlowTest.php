<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class TwoFactorFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_with_2fa_is_intercepted_before_login(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'two_factor_enabled' => true,
            'is_active' => true,
        ]);
        \Illuminate\Support\Facades\Mail::fake();

        $response = $this->post('/login', [
            'email' => $teacher->email,
            'password' => 'password',
        ]);

        $response->assertRedirect(route('two-factor.challenge'));
        $this->assertEquals($teacher->id, session('two_factor_pending_user_id'));

        \Illuminate\Support\Facades\Mail::assertSent(\App\Mail\TwoFactorCode::class);
    }

    public function test_suspended_staff_cannot_login(): void
    {
        $user = User::factory()->create([
            'role' => 'teacher',
            'is_active' => false,
            'suspended_at' => now(),
            'suspended_reason' => 'test suspension',
        ]);

        $response = $this->post('/login', [
            'email' => $user->email,
            'password' => 'password',
        ]);

        $response->assertSessionHasErrors(['email']);
        $this->assertGuest();
    }

    public function test_verifying_code_completes_login_flow(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'two_factor_enabled' => true,
            'is_active' => true,
        ]);
        \Illuminate\Support\Facades\Mail::fake();

        $this->post('/login', [
            'email' => $teacher->email,
            'password' => 'password',
        ]);

        session([
            'two_factor_code_hash' => Hash::make('123456'),
            'two_factor_expires_at' => now()->addSeconds(600)->timestamp,
        ]);

        $response = $this->post(route('two-factor.verify'), ['code' => '123456']);

        $response->assertRedirect(route('teacher.dashboard'));
        $this->assertAuthenticatedAs($teacher);
        $this->assertEquals($teacher->id, session('two_factor_verified_user'));
    }

    public function test_wrong_code_is_rejected(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'two_factor_enabled' => true,
            'is_active' => true,
        ]);
        \Illuminate\Support\Facades\Mail::fake();

        $this->post('/login', [
            'email' => $teacher->email,
            'password' => 'password',
        ]);

        session([
            'two_factor_code_hash' => Hash::make('123456'),
            'two_factor_expires_at' => now()->addSeconds(600)->timestamp,
        ]);

        $response = $this->post(route('two-factor.verify'), ['code' => '000000']);

        $response->assertSessionHasErrors(['code']);
        $this->assertGuest();
    }

    public function test_staff_can_enable_and_confirm_2fa(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'is_active' => true,
        ]);
        \Illuminate\Support\Facades\Mail::fake();

        $this->actingAs($teacher)
            ->post(route('two-factor.enable'))
            ->assertRedirect(route('two-factor.enroll-verify'));

        session([
            'two_factor_code_hash' => Hash::make('123456'),
            'two_factor_expires_at' => now()->addSeconds(600)->timestamp,
        ]);

        $this->actingAs($teacher)
            ->post(route('two-factor.enroll-verify.store'), ['code' => '123456'])
            ->assertRedirect(route('settings.security'));

        $this->assertTrue($teacher->fresh()->two_factor_enabled);
    }

    public function test_staff_can_disable_2fa(): void
    {
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'is_active' => true,
            'two_factor_enabled' => true,
            'two_factor_enrolled_at' => now(),
        ]);

        $this->actingAs($teacher)
            ->post(route('two-factor.disable'))
            ->assertSessionHas('success');

        $this->assertFalse($teacher->fresh()->two_factor_enabled);
    }
}
