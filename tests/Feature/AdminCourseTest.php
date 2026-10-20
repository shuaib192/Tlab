<?php

namespace Tests\Feature;

use App\Models\Club;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class AdminCourseTest extends TestCase
{
    use RefreshDatabase;

    private function admin(): User
    {
        return User::factory()->create(['role' => 'super_admin']);
    }

    public function test_admin_can_create_a_course_with_an_assigned_teacher(): void
    {
        $club = Club::factory()->create();
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($this->admin())
            ->post(route('admin.courses.store'), [
                'club_id' => $club->id,
                'teacher_id' => $teacher->id,
                'title' => 'Python for Kids',
                'level' => 'beginner',
            ])
            ->assertRedirect(route('admin.courses.index'));

        $this->assertDatabaseHas('courses', [
            'title' => 'Python for Kids',
            'teacher_id' => $teacher->id,
        ]);
    }

    public function test_admin_can_change_the_assigned_teacher(): void
    {
        $course = Course::factory()->create(['club_id' => Club::factory()->create()->id]);
        $teacher = User::factory()->create(['role' => 'teacher']);

        $this->actingAs($this->admin())
            ->put(route('admin.courses.update', $course), [
                'club_id' => $course->club_id,
                'teacher_id' => $teacher->id,
                'title' => $course->title,
                'level' => 'beginner',
            ])
            ->assertRedirect(route('admin.courses.index'));

        $this->assertSame($teacher->id, $course->fresh()->teacher_id);
    }

    public function test_editing_a_club_persists_the_age_range_and_status(): void
    {
        $club = Club::factory()->create(['min_age' => 3, 'max_age' => 15, 'is_active' => true]);

        $this->actingAs($this->admin())
            ->put(route('admin.clubs.update', $club), [
                'name' => $club->name,
                'color_theme' => '#0DAA9C',
                'min_age' => 5,
                'max_age' => 18,
                'is_active' => '1',
            ])
            ->assertSessionHasNoErrors()
            ->assertRedirect(route('admin.clubs.index'));

        $club->refresh();
        $this->assertSame(5, $club->min_age);
        $this->assertSame(18, $club->max_age);
        $this->assertTrue($club->is_active);
    }
}
