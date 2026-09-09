<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\ChildProfile;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ChildKidSpaceTest extends TestCase
{
    use RefreshDatabase;

    private function enrolledChild(User $parent): array
    {
        $course = Course::factory()->create(['teacher_id' => User::factory()->create(['role' => 'teacher'])->id]);
        $child = ChildProfile::factory()->for($parent, 'parent')->create();
        $enrollment = Enrollment::factory()->create(['child_profile_id' => $child->id, 'course_id' => $course->id]);
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $assignment = Assignment::factory()->create(['lesson_id' => $lesson->id]);

        return [$child, $enrollment, $assignment];
    }

    public function test_achievements_render_in_child_portal_for_parent_owner()
    {
        $parent = User::factory()->create(['role' => 'parent']);
        [$child] = $this->enrolledChild($parent);

        $response = $this->actingAs($parent)->get(route('child.achievements', $child));

        $response->assertStatus(200);
        $response->assertSee('KIDS // MISSION');
        $response->assertSee('Achievements');
    }

    public function test_achievements_forbidden_for_non_owner_parent()
    {
        $parent = User::factory()->create(['role' => 'parent']);
        $other = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->for($other, 'parent')->create();

        $this->actingAs($parent)->get(route('child.achievements', $child))->assertStatus(403);
    }

    public function test_achievements_allowed_for_super_admin()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        [$child] = $this->enrolledChild(User::factory()->create(['role' => 'parent']));

        $this->actingAs($admin)->get(route('child.achievements', $child))->assertStatus(200);
    }

    public function test_project_page_renders_in_child_portal_with_child_session()
    {
        $parent = User::factory()->create(['role' => 'parent']);
        [$child, $enrollment, $assignment] = $this->enrolledChild($parent);

        $this->withSession(['active_child_id' => $child->id]);

        $response = $this->actingAs($parent)->get(route('child.project', [$enrollment, $assignment]));

        $response->assertStatus(200);
        $response->assertSee('KIDS // MISSION');
        $response->assertSee('Submit Your Work');
    }

    public function test_project_page_accessible_to_super_admin()
    {
        $admin = User::factory()->create(['role' => 'super_admin']);
        [$child, $enrollment, $assignment] = $this->enrolledChild(User::factory()->create(['role' => 'parent']));

        $response = $this->actingAs($admin)->withSession(['active_child_id' => $child->id])->get(route('child.project', [$enrollment, $assignment]));

        $response->assertStatus(200);
        $response->assertSee('KIDS // MISSION');
    }

    public function test_project_submission_records_and_redirects()
    {
        $parent = User::factory()->create(['role' => 'parent']);
        [$child, $enrollment, $assignment] = $this->enrolledChild($parent);

        $response = $this->actingAs($parent)->withSession(['active_child_id' => $child->id])
            ->post(route('child.project.submit', [$enrollment, $assignment]), [
                'link_url' => 'https://scratch.mit.edu/projects/12345',
                'link_note' => 'my first project',
            ]);

        $response->assertRedirect(route('child.course', $enrollment));
        $this->assertDatabaseHas('assignment_submissions', [
            'assignment_id' => $assignment->id,
            'child_profile_id' => $child->id,
            'link_url' => 'https://scratch.mit.edu/projects/12345',
            'status' => 'submitted',
        ]);
        $this->assertEquals($child->xp + 15, $child->fresh()->xp);
    }

    public function test_project_page_forbidden_for_another_child()
    {
        $parent = User::factory()->create(['role' => 'parent']);
        $activeChild = ChildProfile::factory()->for($parent, 'parent')->create();
        [$otherChild, $enrollment, $assignment] = $this->enrolledChild($parent);

        $this->withSession(['active_child_id' => $activeChild->id]);

        $this->actingAs($parent)->get(route('child.project', [$enrollment, $assignment]))
            ->assertStatus(403);
    }
}