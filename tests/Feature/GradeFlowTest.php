<?php

namespace Tests\Feature;

use App\Mail\SubmissionGraded;
use App\Models\Assignment;
use App\Models\AssignmentSubmission;
use App\Models\ChildProfile;
use App\Models\CommunicationLog;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\Notification;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class GradeFlowTest extends TestCase
{
    use RefreshDatabase;

    private function gradedSetup(): array
    {
        $teacher = User::factory()->create(['role' => 'teacher']);
        $course = Course::factory()->create(['teacher_id' => $teacher->id]);
        $parent = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->for($parent, 'parent')->create();
        $enrollment = Enrollment::factory()->create(['child_profile_id' => $child->id, 'course_id' => $course->id]);
        $module = Module::factory()->create(['course_id' => $course->id]);
        $lesson = Lesson::factory()->create(['module_id' => $module->id]);
        $assignment = Assignment::factory()->create(['lesson_id' => $lesson->id, 'max_score' => 100]);
        $submission = AssignmentSubmission::factory()->create([
            'assignment_id' => $assignment->id,
            'child_profile_id' => $child->id,
            'submission_text' => 'My work',
            'status' => 'submitted',
        ]);

        return [$teacher, $parent, $child, $submission];
    }

    public function test_grading_a_submission_awards_xp_emails_parent_and_logs()
    {
        Mail::fake();
        [$teacher, $parent, $child, $submission] = $this->gradedSetup();

        $response = $this->actingAs($teacher)
            ->post(route('teacher.grade.submit', $submission), [
                'score' => 95,
                'feedback' => 'Fantastic! Great creativity.',
                'status' => 'graded',
            ]);

        $response->assertRedirect(route('teacher.grade', $submission->assignment));

        $this->assertEquals(30, $child->fresh()->xpLogs()->sum('amount'));
        $this->assertEquals('95', $submission->fresh()->score);
        Mail::assertSent(SubmissionGraded::class);
        $this->assertDatabaseHas('communication_logs', ['type' => 'grade', 'parent_id' => $parent->id, 'child_profile_id' => $child->id]);
        $this->assertDatabaseHas('notifications', ['user_id' => $parent->id, 'type' => 'grade']);
    }

    public function test_medium_score_awards_lower_xp()
    {
        Mail::fake();
        [$teacher, , $child, $submission] = $this->gradedSetup();

        $this->actingAs($teacher)
            ->post(route('teacher.grade.submit', $submission), [
                'score' => 60,
                'status' => 'graded',
            ]);

        $this->assertEquals(15, $child->fresh()->xpLogs()->sum('amount'));
    }

    public function test_regrading_does_not_double_award_xp_or_email()
    {
        Mail::fake();
        [$teacher, $parent, $child, $submission] = $this->gradedSetup();

        $this->actingAs($teacher)
            ->post(route('teacher.grade.submit', $submission), ['score' => 95, 'status' => 'graded']);
        $this->actingAs($teacher)
            ->post(route('teacher.grade.submit', $submission), ['score' => 100, 'feedback' => 'Bumping to 100', 'status' => 'approved']);

        $this->assertEquals(30, $child->fresh()->xpLogs()->sum('amount'));
        $this->assertEquals(100, (int) $submission->fresh()->score);
        Mail::assertSent(SubmissionGraded::class, 1);
        $this->assertEquals(1, CommunicationLog::where('child_profile_id', $child->id)->where('type', 'grade')->count());
        $this->assertEquals(1, Notification::where('user_id', $parent->id)->where('type', 'grade')->count());
    }
}