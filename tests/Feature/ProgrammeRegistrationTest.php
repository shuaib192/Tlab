<?php

namespace Tests\Feature;

use App\Models\ProgrammeRegistration;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\Response;
use Tests\TestCase;
use Unicodeveloper\Paystack\Facades\Paystack;

class ProgrammeRegistrationTest extends TestCase
{
    use RefreshDatabase;

    private const VALID = [
        'parent_name' => 'Adaeze Okafor',
        'phone' => '08012345678',
        'email' => 'adaeze@example.com',
        'child_name' => 'Chidera Okafor',
        'child_age' => 9,
        'programme' => 'scratch',
        'device' => 'laptop',
        'payment_option' => 'monthly',
        'consent' => '1',
    ];

    public function test_home_page_lists_programme_sections(): void
    {
        $this->get(route('home'))
            ->assertStatus(200)
            ->assertSee('Practical Skills for')
            ->assertSee('Choose a Programme')
            ->assertSee('Secure a Place')
            ->assertSee('Ready to Get Started?')
            ->assertSee('tlabadmin@edfrica.org');
    }

    public function test_enrol_page_renders_form(): void
    {
        $this->get(route('programme.enrol'))
            ->assertStatus(200)
            ->assertSee('Register Your Child')
            ->assertSee('parent_name')
            ->assertSee('payment_option')
            ->assertSee('Proceed to Payment');
    }

    public function test_store_creates_registration_and_redirects_to_paystack(): void
    {
        Paystack::shouldReceive('getAuthorizationUrl')
            ->once()
            ->andReturn(new class
            {
                public $url = 'https://checkout.paystack.test/session';
            });

        $response = $this->post(route('programme.enrol.store'), self::VALID);

        $response->assertRedirect('https://checkout.paystack.test/session');

        $registration = ProgrammeRegistration::firstOrFail();
        $this->assertSame('Chidera Okafor', $registration->child_name);
        $this->assertSame('Scratch Programming', $registration->programme);
        $this->assertSame('monthly', $registration->payment_option);
        $this->assertSame(10000, $registration->amount);
        $this->assertSame('pending', $registration->status);
        $this->assertStringStartsWith('TLAB-PRG-', $registration->reference);
    }

    public function test_full_payment_option_charges_full_amount(): void
    {
        Paystack::shouldReceive('getAuthorizationUrl')
            ->once()
            ->andReturn(new class
            {
                public $url = 'https://checkout.paystack.test/session';
            });

        $this->post(route('programme.enrol.store'), [...self::VALID, 'payment_option' => 'full']);

        $registration = ProgrammeRegistration::firstOrFail();
        $this->assertSame(30000, $registration->amount);
    }

    public function test_programme_must_match_child_age(): void
    {
        $response = $this->post(route('programme.enrol.store'), [...self::VALID, 'programme' => 'python']);

        $response->assertInvalid(['programme']);
        $this->assertDatabaseCount('programme_registrations', 0);
    }

    public function test_consent_is_required(): void
    {
        $response = $this->post(route('programme.enrol.store'), [...self::VALID, 'consent' => null]);

        $response->assertInvalid(['consent']);
        $this->assertDatabaseCount('programme_registrations', 0);
    }

    public function test_callback_marks_registration_paid_and_redirects_to_success(): void
    {
        $registration = ProgrammeRegistration::create([
            'parent_name' => 'Adaeze Okafor',
            'phone' => '08012345678',
            'email' => 'adaeze@example.com',
            'child_name' => 'Chidera Okafor',
            'child_age' => 9,
            'programme' => 'Scratch Programming',
            'device' => 'laptop',
            'payment_option' => 'monthly',
            'amount' => 10000,
            'status' => 'pending',
            'reference' => 'TLAB-PRG-TESTCALL',
        ]);

        Paystack::shouldReceive('getPaymentData')
            ->once()
            ->with($registration->reference)
            ->andReturn([
                'data' => [
                    'status' => 'success',
                    'id' => 4321,
                    'channel' => 'card',
                ],
            ]);

        $response = $this->get(route('payment.callback', [
            'trxref' => 'PAYD-4321',
            'reference' => $registration->reference,
        ]));

        $response->assertRedirect(route('programme.enrol.success', ['reference' => $registration->reference]));

        $this->assertDatabaseHas('programme_registrations', [
            'id' => $registration->id,
            'status' => 'paid',
            'gateway_transaction' => '4321',
        ]);

        $this->get(route('programme.enrol.success', ['reference' => $registration->reference]))
            ->assertStatus(200)
            ->assertSee('Registration received')
            ->assertSee($registration->reference);
    }

    public function test_webhook_marks_registration_paid(): void
    {
        $registration = ProgrammeRegistration::create([
            'parent_name' => 'Adaeze Okafor',
            'phone' => '08012345678',
            'email' => 'adaeze@example.com',
            'child_name' => 'Chidera Okafor',
            'child_age' => 14,
            'programme' => 'Python Programming',
            'device' => 'smartphone',
            'payment_option' => 'full',
            'amount' => 30000,
            'status' => 'pending',
            'reference' => 'TLAB-PRG-WEBHOOK1',
        ]);

        $payload = [
            'event' => 'charge.success',
            'data' => [
                'reference' => $registration->reference,
                'id' => 6666,
                'channel' => 'card',
            ],
        ];

        $response = $this->postJson(route('payment.webhook'), $payload, [
            'x-paystack-signature' => hash_hmac('sha512', json_encode($payload), config('services.paystack.secret')),
        ]);

        $response->assertOk();
        $this->assertDatabaseHas('programme_registrations', [
            'id' => $registration->id,
            'status' => 'paid',
            'gateway_transaction' => '6666',
        ]);
    }

    public function test_admin_can_view_registrations(): void
    {
        $admin = $this->adminUser();

        ProgrammeRegistration::factory()->create(['status' => 'paid', 'amount' => 30000]);

        $this->actingAs($admin)->get(route('admin.programme-registrations.index'))
            ->assertStatus(200)
            ->assertSee('Programme Registrations')
            ->assertSee('30,000');
    }

    public function test_admin_can_verify_pending_registration(): void
    {
        $admin = $this->adminUser();
        $registration = ProgrammeRegistration::factory()->create(['status' => 'pending']);

        $this->actingAs($admin)->post(route('admin.programme-registrations.verify', $registration))
            ->assertSessionHas('success');

        $this->assertDatabaseHas('programme_registrations', ['id' => $registration->id, 'status' => 'paid']);
    }

    public function test_guest_cannot_access_admin_registrations(): void
    {
        $this->get(route('admin.programme-registrations.index'))
            ->assertStatus(Response::HTTP_FOUND);
    }

    private function adminUser()
    {
        return \App\Models\User::factory()->create(['role' => 'admin']);
    }
}
