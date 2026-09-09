<?php

namespace Tests\Feature;

use App\Models\Assignment;
use App\Models\ChildProfile;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Lesson;
use App\Models\Module;
use App\Models\User;
use App\Rules\AllowlistedUrl;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class SafetySecurityTest extends TestCase
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

    public function test_safelink_rule_accepts_approved_platforms()
    {
        $rule = new AllowlistedUrl;

        $this->assertTrue($rule->passes('link_url', 'https://scratch.mit.edu/projects/12345'));
        $this->assertTrue($rule->passes('link_url', 'https://www.replit.com/@kid/project'));
        $this->assertTrue($rule->passes('link_url', 'https://github.com/kid/project'));
        $this->assertTrue($rule->passes('link_url', 'https://docs.google.com/document/d/abc'));
        $this->assertTrue($rule->passes('link_url', 'https://drive.google.com/file/d/x/view'));
        $this->assertTrue($rule->passes('link_url', 'https://youtu.be/abc123'));
        $this->assertFalse($rule->passes('link_url', 'https://example-evil-page.com/x'));
        $this->assertFalse($rule->passes('link_url', 'https://scratch.mit.edu.evil.com/x'));
        $this->assertFalse($rule->passes('link_url', 'http://127.0.0.1/x'));
    }

    public function test_project_submission_rejects_blocked_domains()
    {
        $parent = User::factory()->create(['role' => 'parent']);
        [$child, $enrollment, $assignment] = $this->enrolledChild($parent);

        $response = $this->actingAs($parent)->withSession(['active_child_id' => $child->id])
            ->post(route('child.project.submit', [$enrollment, $assignment]), [
                'link_url' => 'https://submission-served-from-evil.example.com/payload',
            ]);

        $response->assertSessionHasErrors('link_url');
        $this->assertDatabaseMissing('assignment_submissions', ['assignment_id' => $assignment->id]);
        $this->assertEquals(0, $child->fresh()->xpLogs()->count());
    }

    public function test_staff_login_is_rate_limited()
    {
        \Illuminate\Support\Facades\Cache::flush();
        $user = User::factory()->create(['role' => 'parent']);

        $lastCode = 302;
        for ($i = 0; $i < 10; $i++) {
            $r = $this->post('/login', ['email' => $user->email, 'password' => 'wrong-password']);
            $lastCode = $r->getStatusCode();
        }

        $this->assertNotEquals(429, $lastCode);

        $r = $this->post('/login', ['email' => $user->email, 'password' => 'wrong-password']);
        $this->assertEquals(429, $r->getStatusCode());

        \Illuminate\Support\Facades\Cache::flush();
    }
}