<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Course;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCurriculumTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'super_admin']);
    }

    private function course(): Course
    {
        return Course::factory()->create(['club_id' => Club::factory()->create()->id]);
    }

    public function test_admin_can_create_a_module(): void
    {
        $course = $this->course();

        $this->actingAs($this->admin())
            ->post(route('admin.curriculum.modules.store', $course), [
                'title' => 'Introduction to Python',
                'description' => 'Getting started.',
            ])
            ->assertRedirect(route('admin.curriculum.modules', $course));

        $this->assertDatabaseHas('modules', [
            'course_id' => $course->id,
            'title' => 'Introduction to Python',
            'slug' => 'introduction-to-python',
        ]);
    }

    public function test_module_slug_is_unique_when_titles_repeat(): void
    {
        $course = $this->course();
        $admin = $this->admin();

        $this->actingAs($admin)->post(route('admin.curriculum.modules.store', $course), [
            'title' => 'Foundations',
        ]);
        $this->actingAs($admin)->post(route('admin.curriculum.modules.store', $course), [
            'title' => 'Foundations',
        ]);

        $this->assertSame(2, Module::where('course_id', $course->id)->count());
        $this->assertDatabaseHas('modules', ['slug' => 'foundations']);
        $this->assertDatabaseHas('modules', ['slug' => 'foundations-2']);
    }

    public function test_admin_can_create_a_lesson(): void
    {
        $module = Module::factory()->create();

        $this->actingAs($this->admin())
            ->post(route('admin.curriculum.lessons.store', $module), [
                'title' => 'Your First Script',
                'type' => 'text',
                'content' => 'Write your first line.',
            ])
            ->assertRedirect(route('admin.curriculum.lessons', $module));

        $this->assertDatabaseHas('lessons', [
            'module_id' => $module->id,
            'title' => 'Your First Script',
            'slug' => 'your-first-script',
        ]);
    }
}
