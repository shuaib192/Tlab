<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ProfileFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_guest_is_redirected_to_login(): void
    {
        $this->get('/settings/profile')->assertRedirect(route('login'));
    }

    public function test_teacher_can_view_profile_page(): void
    {
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher)
            ->get(route('settings.profile'))
            ->assertOk()
            ->assertSee('Profile Photo');
    }

    public function test_teacher_can_upload_profile_photo(): void
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);

        $response = $this->actingAs($teacher)
            ->post(route('settings.profile.update'), [
                'avatar' => UploadedFile::fake()->image('me.jpg', 400, 300),
            ]);

        $response->assertRedirect();

        $teacher->refresh();
        $this->assertNotNull($teacher->avatar);
        $this->assertStringStartsWith('avatars/', $teacher->avatar);
        Storage::disk('public')->assertExists($teacher->avatar);
    }

    public function test_uploading_new_photo_deletes_previous_avatar(): void
    {
        Storage::fake('public');
        $teacher = User::factory()->create([
            'role' => 'teacher',
            'avatar' => 'avatars/old.jpg',
        ]);
        Storage::disk('public')->put('avatars/old.jpg', 'x');
        Storage::disk('public')->assertExists('avatars/old.jpg');

        $this->actingAs($teacher)
            ->post(route('settings.profile.update'), [
                'avatar' => UploadedFile::fake()->image('new.png', 400, 300),
            ])
            ->assertRedirect();

        $teacher->refresh();
        $this->assertNotEquals('avatars/old.jpg', $teacher->avatar);
        Storage::disk('public')->assertMissing('avatars/old.jpg');
        Storage::disk('public')->assertExists($teacher->avatar);
    }

    public function test_non_image_file_is_rejected(): void
    {
        Storage::fake('public');
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($teacher)
            ->from(route('settings.profile'))
            ->post(route('settings.profile.update'), [
                'avatar' => UploadedFile::fake()->create('notes.txt', 100),
            ])
            ->assertSessionHasErrors('avatar');

        $teacher->refresh();
        $this->assertNull($teacher->avatar);
    }
}
