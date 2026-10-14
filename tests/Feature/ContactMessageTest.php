<?php

namespace Tests\Feature;

use App\Mail\ContactMessageReceived;
use App\Models\ContactMessage;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Mail;
use Tests\TestCase;

class ContactMessageTest extends TestCase
{
    use RefreshDatabase;

    public function test_the_contact_page_renders(): void
    {
        $this->get('/contact')->assertOk();
    }

    public function test_a_visitor_can_submit_an_enquiry(): void
    {
        Mail::fake();

        $response = $this->post('/contact', [
            'name' => 'Ade Bodija',
            'email' => 'ade@example.com',
            'subject' => 'Summer workshop for my son',
            'message' => 'I would like to know the dates and cost of the robotics workshop.',
        ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $this->assertDatabaseHas('contact_messages', [
            'email' => 'ade@example.com',
            'subject' => 'Summer workshop for my son',
        ]);
    }

    public function test_submissions_are_delivered_to_the_tlab_admin_address(): void
    {
        Mail::fake();

        config(['tlab.admin_email' => 'tlabadmin@edfrica.org']);

        $this->post('/contact', [
            'name' => 'Ade Bodija',
            'email' => 'ade@example.com',
            'subject' => 'Question',
            'message' => 'Is the STEM club available in Port Harcourt?',
        ]);

        Mail::assertSent(ContactMessageReceived::class, function ($mail) {
            return $mail->hasTo('tlabadmin@edfrica.org');
        });
    }

    public function test_the_notification_allows_replying_to_the_sender(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => 'Ade Bodija',
            'email' => 'ade@example.com',
            'subject' => 'Question',
            'message' => 'Is the STEM club available in Port Harcourt?',
        ]);

        Mail::assertSent(ContactMessageReceived::class, function ($mail) {
            return in_array('ade@example.com', array_map(
                fn ($address) => $address->address,
                $mail->envelope()->replyTo
            ));
        });
    }

    public function test_the_enquiry_is_stored_even_if_mail_delivery_fails(): void
    {
        Mail::shouldReceive('to')->andThrow(new \RuntimeException('SMTP down'));

        $response = $this->post('/contact', [
            'name' => 'Ade Bodija',
            'email' => 'ade@example.com',
            'subject' => 'Question',
            'message' => 'Please keep this enquiry even if email fails.',
        ]);

        $response->assertSessionHas('success');
        $this->assertDatabaseHas('contact_messages', ['email' => 'ade@example.com']);
    }

    public function test_the_enquiry_is_validated(): void
    {
        Mail::fake();

        $this->post('/contact', [
            'name' => '',
            'email' => 'not-an-email',
            'subject' => '',
            'message' => '',
        ])->assertSessionHasErrors(['name', 'email', 'subject', 'message']);

        $this->assertDatabaseCount('contact_messages', 0);
    }

    public function test_admin_can_list_enquiries(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);

        ContactMessage::create([
            'name' => 'Ade Bodija',
            'email' => 'ade@example.com',
            'subject' => 'Workshop enquiry',
            'message' => 'Please send the dates for the robotics workshop.',
        ]);

        $this->actingAs($admin)
            ->get('/admin/contact-messages')
            ->assertOk()
            ->assertSee('Ade Bodija')
            ->assertSee('Workshop enquiry');
    }

    public function test_guests_cannot_view_the_enquiry_inbox(): void
    {
        $this->get('/admin/contact-messages')->assertRedirect('/login');
    }

    public function test_opening_an_enquiry_marks_it_read(): void
    {
        $admin = User::factory()->create(['role' => 'super_admin']);

        $message = ContactMessage::create([
            'name' => 'Ade Bodija',
            'email' => 'ade@example.com',
            'subject' => 'Workshop enquiry',
            'message' => 'Please send the dates for the robotics workshop.',
        ]);

        $this->assertFalse($message->fresh()->is_read);

        $this->actingAs($admin)
            ->get(route('admin.contact-messages.show', $message))
            ->assertOk();

        $this->assertTrue($message->fresh()->is_read);
        $this->assertNotNull($message->fresh()->read_at);
    }
}
