<?php

namespace Tests\Feature;

use App\Models\ChildProfile;
use App\Models\ClassSession;
use App\Models\Cohort;
use App\Models\Course;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class TeacherFlowTest extends TestCase
{
    use RefreshDatabase;

    public function test_teacher_can_view_dashboard()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $response = $this->actingAs($teacher)->get(route('teacher.dashboard'));
        $response->assertStatus(200);
    }

    public function test_teacher_can_view_course()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $response = $this->actingAs($teacher)->get(route('teacher.course', $course));
        $response->assertStatus(200);
    }

    public function test_teacher_can_mark_attendance()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $cohort = Cohort::factory()->create(['course_id' => $course->id]);
        $session = ClassSession::factory()->create(['course_id' => $course->id, 'cohort_id' => $cohort->id]);
        $child = ChildProfile::factory()->create();

        $response = $this->actingAs($teacher)->post(route('teacher.session.attendance', $session), [
            'attendance' => [
                $child->id => ['status' => 'present', 'notes' => ''],
            ],
        ]);
        $response->assertSessionHasNoErrors();
    }

    public function test_teacher_can_grade_assignment()
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $submission = \App\Models\AssignmentSubmission::factory()->create();
        $submission->assignment->lesson->module->course()->associate($course);

        $response = $this->actingAs($teacher)->post(route('teacher.grade.submit', $submission), [
            'score' => 85,
            'feedback' => 'Good work!',
            'status' => 'graded',
        ]);
        $response->assertSessionHasNoErrors();
    }
}
