<?php

namespace Tests\Feature;

use App\Models\ChildProfile;
use App\Models\Course;
use App\Models\Enrollment;
use App\Models\Payment;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Unicodeveloper\Paystack\Facades\Paystack;

class EnrolmentFlowTest extends TestCase
{
    use RefreshDatabase;

    private function parentChild(): array
    {
        $user = User::factory()->create(['role' => 'parent']);
        $child = ChildProfile::factory()->create(['user_id' => $user->id]);

        return [$user, $child];
    }

    public function test_free_course_flow_marks_paid_and_confirms()
    {
        [$user, $child] = $this->parentChild();
        $course = Course::factory()->create(['fee' => null]);

        $response = $this->actingAs($user)->post(route('parent.courses.enroll.submit', $course), [
            'child_profile_id' => $child->id,
        ]);

        $enrollment = Enrollment::where('child_profile_id', $child->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        $response->assertRedirect(route('parent.courses.payment', $enrollment));
        $this->assertDatabaseHas('enrollments', ['id' => $enrollment->id, 'payment_status' => 'pending']);

        $this->actingAs($user)->get(route('parent.courses.payment', $enrollment))
            ->assertStatus(200)
            ->assertSee('Free');

        $this->actingAs($user)->post(route('parent.courses.pay', $enrollment))
            ->assertRedirect(route('parent.enrollments.confirmation', $enrollment));

        $this->assertDatabaseHas('enrollments', ['id' => $enrollment->id, 'payment_status' => 'paid']);
        $this->assertDatabaseHas('notifications', ['user_id' => $user->id, 'type' => 'enrollment']);

        $this->actingAs($user)->get(route('parent.enrollments.confirmation', $enrollment))
            ->assertStatus(200)
            ->assertSee('Enrolment Confirmed!');
    }

    public function test_paid_course_pay_redirects_to_paystack_and_creates_pending_payment()
    {
        [$user, $child] = $this->parentChild();
        $course = Course::factory()->create(['fee' => 5000]);

        $this->actingAs($user)->post(route('parent.courses.enroll.submit', $course), [
            'child_profile_id' => $child->id,
        ]);

        $enrollment = Enrollment::where('child_profile_id', $child->id)
            ->where('course_id', $course->id)
            ->firstOrFail();

        Paystack::shouldReceive('getAuthorizationUrl')
            ->once()
            ->andReturn(new class
            {
                public $url = 'https://checkout.paystack.test/session';
            });

        $response = $this->actingAs($user)->post(route('parent.courses.pay', $enrollment));

        $response->assertRedirect('https://checkout.paystack.test/session');

        $payment = Payment::where('metadata->enrollment_id', $enrollment->id)->firstOrFail();
        $this->assertSame(5000, $payment->amount);
        $this->assertSame('pending', $payment->status);
        $this->assertSame($course->title, $payment->metadata['course_title']);
        $this->assertDatabaseHas('enrollments', ['id' => $enrollment->id, 'payment_status' => 'pending']);
    }

    public function test_paid_enrollment_skips_straight_to_confirmation()
    {
        [$user, $child] = $this->parentChild();
        $course = Course::factory()->create(['fee' => 5000]);
        $enrollment = Enrollment::factory()->create([
            'child_profile_id' => $child->id,
            'course_id' => $course->id,
            'payment_status' => 'paid',
        ]);

        $response = $this->actingAs($user)->post(route('parent.courses.pay', $enrollment));

        $response->assertRedirect(route('parent.enrollments.confirmation', $enrollment));
    }

    public function test_parent_cannot_touch_another_families_enrollment()
    {
        [$user, $child] = $this->parentChild();
        $course = Course::factory()->create(['fee' => 1000]);
        $enrollment = Enrollment::factory()->create([
            'child_profile_id' => $child->id,
            'course_id' => $course->id,
            'payment_status' => 'pending',
        ]);

        $meddler = User::factory()->create(['role' => 'parent']);

        $this->actingAs($meddler)->get(route('parent.courses.payment', $enrollment))
            ->assertStatus(Response::HTTP_FORBIDDEN);
        $this->actingAs($meddler)->post(route('parent.courses.pay', $enrollment))
            ->assertStatus(Response::HTTP_FORBIDDEN);
        $this->actingAs($meddler)->get(route('parent.enrollments.confirmation', $enrollment))
            ->assertStatus(Response::HTTP_FORBIDDEN);
    }

    public function test_callback_marks_enrollment_paid_and_redirects_to_confirmation()
    {
        [$user, $child] = $this->parentChild();
        $course = Course::factory()->create(['fee' => 1000]);
        $enrollment = Enrollment::factory()->create([
            'child_profile_id' => $child->id,
            'course_id' => $course->id,
            'payment_status' => 'pending',
        ]);
        $payment = Payment::create([
            'user_id' => $user->id,
            'reference' => 'TLAB-ENR-TESTCALL',
            'amount' => 1000,
            'currency' => 'NGN',
            'status' => 'pending',
            'metadata' => [
                'enrollment_id' => $enrollment->id,
                'course_id' => $course->id,
                'course_title' => $course->title,
                'child_profile_id' => $child->id,
                'child_name' => $child->name,
            ],
        ]);

        Paystack::shouldReceive('getPaymentData')
            ->once()
            ->with($payment->reference)
            ->andReturn([
                'data' => [
                    'status' => 'success',
                    'id' => 9876,
                    'channel' => 'card',
                ],
            ]);

        $response = $this->actingAs($user)->get(route('payment.callback', [
            'trxref' => 'PAYD-9876',
            'reference' => $payment->reference,
        ]));

        $response->assertRedirect(route('parent.enrollments.confirmation', $enrollment));

        $this->assertDatabaseHas('payments', ['id' => $payment->id, 'status' => 'paid']);
        $this->assertDatabaseHas('enrollments', ['id' => $enrollment->id, 'payment_status' => 'paid']);
        $this->assertDatabaseHas('notifications', ['user_id' => $user->id, 'type' => 'enrollment']);
    }

    public function test_webhook_marks_enrollment_paid()
    {
        [$user, $child] = $this->parentChild();
        $course = Course::factory()->create(['fee' => 1000]);
        $enrollment = Enrollment::factory()->create([
            'child_profile_id' => $child->id,
            'course_id' => $course->id,
            'payment_status' => 'pending',
        ]);
        $payment = Payment::create([
            'user_id' => $user->id,
            'reference' => 'TLAB-ENR-WEBHOOK1',
            'amount' => 1000,
            'currency' => 'NGN',
            'status' => 'pending',
            'metadata' => ['enrollment_id' => $enrollment->id],
        ]);

        $payload = [
            'event' => 'charge.success',
            'data' => [
                'reference' => $payment->reference,
                'id' => 5555,
                'channel' => 'card',
            ],
        ];

        $response = $this->postJson(route('payment.webhook'), $payload, [
            'x-paystack-signature' => hash_hmac('sha512', json_encode($payload), config('services.paystack.secret')),
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('enrollments', ['id' => $enrollment->id, 'payment_status' => 'paid']);
    }
}
