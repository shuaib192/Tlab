<?php

namespace Tests\Feature;

use App\Models\Cohort;
use App\Models\Course;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherCurriculumTest extends TestCase
{
    use RefreshDatabase;

    private function teacher(): User
    {
        return User::factory()->create(['role' => 'teacher']);
    }

    private function club()
    {
        return \App\Models\Club::factory()->create(['name' => 'Coding Club']);
    }

    public function test_teacher_can_create_a_course()
    {
        $teacher = $this->teacher();
        $club = $this->club();

        $response = $this->actingAs($teacher)
            ->post(route('teacher.courses.store'), [
                'club_id' => $club->id,
                'title' => 'Creative Coding with Scratch',
                'description' => 'Learn to build games.',
                'level' => 'Beginner',
                'is_published' => 1,
            ]);

        $course = Course::where('title', 'Creative Coding with Scratch')->first();
        $response->assertRedirect(route('teacher.course', $course));
        $this->assertNotNull($course);
        $this->assertEquals($teacher->id, $course->teacher_id);
        $this->assertNotNull($course->slug);
    }

    public function test_course_requires_a_club()
    {
        $teacher = $this->teacher();

        $response = $this->actingAs($teacher)
            ->post(route('teacher.courses.store'), ['title' => 'No club course']);

        $response->assertSessionHasErrors('club_id');
        $this->assertEquals(0, Course::count());
    }

    public function test_teacher_can_build_modules_and_lessons()
    {
        $teacher = $this->teacher();
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);

        $this->actingAs($teacher)
            ->post(route('teacher.modules.store', $course), ['title' => 'Module One', 'description' => 'Intro'])
            ->assertRedirect(route('teacher.curriculum', $course));

        $module = Module::where('course_id', $course->id)->first();
        $this->assertNotNull($module);

        $this->actingAs($teacher)
            ->post(route('teacher.lessons.store', $module), [
                'title' => 'Your First Sprite',
                'type' => 'text',
                'content' => 'Open Scratch and add a sprite.',
                'duration' => 15,
            ])
            ->assertRedirect(route('teacher.curriculum', $course));

        $lesson = Lesson::where('module_id', $module->id)->first();
        $this->assertNotNull($lesson);
        $this->assertEquals('text', $lesson->type);

        $this->actingAs($teacher)
            ->get(route('teacher.curriculum', $course))
            ->assertOk()
            ->assertSee('Module One')
            ->assertSee('Your First Sprite');
    }

    public function test_teacher_can_create_a_cohort()
    {
        $teacher = $this->teacher();
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);

        $response = $this->actingAs($teacher)
            ->post(route('teacher.cohorts.store', $course), [
                'name' => 'Saturday Morning',
                'session_time' => '10:00 AM',
                'session_days' => 'Saturdays',
            ]);

        $response->assertRedirect(route('teacher.course', $course));
        $this->assertDatabaseHas('cohorts', ['course_id' => $course->id, 'name' => 'Saturday Morning']);
    }

    public function test_non_owner_teacher_cannot_edit_curriculum()
    {
        $owner = $this->teacher();
        $other = $this->teacher();
        $course = Course::factory()->create(['teacher_id' => $owner->id]);

        $response = $this->actingAs($other)
            ->get(route('teacher.curriculum', $course));

        $response->assertForbidden();
    }

    public function test_teacher_can_delete_a_lesson_and_module()
    {
        $teacher = $this->teacher();
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);

        $this->actingAs($teacher)
            ->delete(route('teacher.lessons.destroy', $lesson))
            ->assertRedirect(route('teacher.curriculum', $course));
        $this->assertDatabaseMissing('lessons', ['id' => $lesson->id]);

        $this->actingAs($teacher)
            ->delete(route('teacher.modules.destroy', $module))
            ->assertRedirect(route('teacher.curriculum', $course));
        $this->assertDatabaseMissing('modules', ['id' => $module->id]);
    }

    public function test_teacher_can_update_an_assignment()
    {
        $teacher = $this->teacher();
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $assignment = \App\Models\Assignment::factory()->create(['lesson_id' => $lesson->id, 'type' => 'file']);

        $response = $this->actingAs($teacher)
            ->put(route('teacher.assignments.update', $assignment), [
                'lesson_id' => $lesson->id,
                'title' => 'Redesigned Task',
                'instructions' => 'New brief',
                'type' => 'canvas',
                'max_score' => 75,
                'is_published' => 0,
            ]);

        $response->assertRedirect(route('teacher.assignments', $course));
        $assignment->refresh();
        $this->assertEquals('Redesigned Task', $assignment->title);
        $this->assertEquals('canvas', $assignment->type);
        $this->assertEquals(75, $assignment->max_score);
        $this->assertFalse($assignment->is_published);
    }

    public function test_teacher_can_delete_an_assignment()
    {
        $teacher = $this->teacher();
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $assignment = \App\Models\Assignment::factory()->create(['lesson_id' => $lesson->id]);

        $this->actingAs($teacher)
            ->delete(route('teacher.assignments.destroy', $assignment))
            ->assertRedirect(route('teacher.assignments', $course));

        $this->assertDatabaseMissing('assignments', ['id' => $assignment->id]);
    }

    public function test_non_owner_cannot_update_assignment()
    {
        $owner = $this->teacher();
        $other = $this->teacher();
        $course = Course::factory()->create(['teacher_id' => $owner->id]);
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $assignment = \App\Models\Assignment::factory()->create(['lesson_id' => $lesson->id]);

        $this->actingAs($other)
            ->put(route('teacher.assignments.update', $assignment), [
                'lesson_id' => $lesson->id,
                'title' => 'Hijacked',
                'type' => 'file',
                'max_score' => 10,
            ])
->assertForbidden();
    }
}
