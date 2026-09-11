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
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class CanvasAssignmentTest extends TestCase
{
    use RefreshDatabase;

    private function makePngDataUrl(): string
    {
        $im = imagecreatetruecolor(8, 8);
        $c = imagecolorallocate($im, 119, 255, 162);
        imagefill($im, 0, 0, $c);
        ob_start();
        imagepng($im);
        $bin = ob_get_clean();
        imagedestroy($im);

        return 'data:image/png;base64,'.base64_encode($bin);
    }

    private function canvasSetup(): array
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $parent = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->for($parent, 'parent')->create();
        $enrollment = Enrollment::factory()->create(['child_profile_id' => $child->id, 'course_id' => $course->id]);
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $assignment = Assignment::factory()->create(['lesson_id' => $lesson->id, 'type' => 'canvas']);

        return [$teacher, $parent, $child, $enrollment, $assignment];
    }

    public function test_canvas_assignment_renders_draw_work_area()
    {
        [, $parent, $child, $enrollment, $assignment] = $this->canvasSetup();

        $response = $this->actingAs($parent)->withSession(['active_child_id' => $child->id])
            ->get(route('child.project', [$enrollment, $assignment]));

        $response->assertOk();
        $response->assertSee('kid-canvas', false);
        $response->assertSee('Interactive Canvas', false);
    }

    public function test_canvas_submission_persists_canvas_image()
    {
        Storage::fake('public');
        [, $parent, $child, $enrollment, $assignment] = $this->canvasSetup();

        $response = $this->actingAs($parent)->withSession(['active_child_id' => $child->id])
            ->post(route('child.project.submit', [$enrollment, $assignment]), [
                'canvas_data' => $this->makePngDataUrl(),
                'canvas_bg' => 'white',
                'submission_text' => 'Done!',
            ]);

        $response->assertRedirect(route('child.course', $enrollment));

        $submission = $assignment->submissions()->where('child_profile_id', $child->id)->first();
        $this->assertNotNull($submission);
        $this->assertNotNull($submission->canvas_path);
        $this->assertEquals('white', $submission->canvas_bg);
        $this->assertEquals('Done!', $submission->submission_text);
        $this->assertEquals(1, $submission->version);
        Storage::disk('public')->assertExists($submission->canvas_path);
        $this->assertEquals(15, $child->fresh()->xpLogs()->sum('amount'));
    }

    public function test_canvas_submission_without_drawing_has_no_canvas()
    {
        Storage::fake('public');
        [, $parent, $child, $enrollment, $assignment] = $this->canvasSetup();

        $response = $this->actingAs($parent)->withSession(['active_child_id' => $child->id])
            ->post(route('child.project.submit', [$enrollment, $assignment]), [
                'submission_text' => 'no drawing hand-in',
            ]);

        $response->assertRedirect(route('child.course', $enrollment));

        $submission = $assignment->submissions()->where('child_profile_id', $child->id)->first();
        $this->assertNull($submission->canvas_path);
    }

    public function test_teacher_can_create_canvas_assignment()
    {
        [$teacher] = $this->canvasSetup();
        $course = $teacher->taughtCourses()->first();
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);

        $response = $this->actingAs($teacher)
            ->post(route('teacher.assignments.store', $course), [
                'lesson_id' => $lesson->id,
                'title' => 'Draw your robot',
                'instructions' => 'Draw and label a robot that helps your community.',
                'type' => 'canvas',
                'max_score' => 50,
                'is_published' => 1,
            ]);

        $response->assertRedirect(route('teacher.assignments', $course));
        $this->assertDatabaseHas('assignments', [
            'title' => 'Draw your robot',
            'type' => 'canvas',
            'max_score' => 50,
        ]);
    }
}
