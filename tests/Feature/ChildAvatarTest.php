<?php

namespace Tests\Feature;

use App\Models\ChildProfile;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ChildAvatarTest extends TestCase
{
    use RefreshDatabase;

    private function parent(): User
    {
        return User::factory()->create(['role' => 'parent']);
    }

    public function test_parent_can_upload_a_child_picture_on_create(): void
    {
        Storage::fake('public');

        $response = $this->actingAs($this->parent())->post(route('parent.children.store'), [
            'name' => 'Adaeze Okonkwo',
            'dob' => '2015-05-01',
            'gender' => 'female',
            'avatar' => UploadedFile::fake()->image('adaeze.jpg'),
        ]);

        $response->assertRedirect(route('parent.dashboard'));

        $child = ChildProfile::firstOrFail();
        $this->assertNotNull($child->avatar);
        Storage::disk('public')->assertExists($child->avatar);
    }

    public function test_parent_can_replace_a_child_picture_on_edit(): void
    {
        Storage::fake('public');

        $parent = $this->parent();
        $child = ChildProfile::factory()->create(['user_id' => $parent->id]);

        $this->actingAs($parent)->put(route('parent.children.update', $child), [
            'name' => $child->name,
            'dob' => '2015-05-01',
            'gender' => 'male',
            'avatar' => UploadedFile::fake()->image('new.png'),
        ])->assertRedirect(route('parent.children.show', $child));

        $this->assertNotNull($child->fresh()->avatar);
    }

    public function test_uploaded_picture_must_be_an_image(): void
    {
        Storage::fake('public');

        $this->actingAs($this->parent())->post(route('parent.children.store'), [
            'name' => 'Adaeze Okonkwo',
            'dob' => '2015-05-01',
            'gender' => 'female',
            'avatar' => UploadedFile::fake()->create('notes.pdf', 100, 'application/pdf'),
        ])->assertSessionHasErrors('avatar');
    }
}
