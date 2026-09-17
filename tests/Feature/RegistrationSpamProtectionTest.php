<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class RegistrationSpamProtectionTest extends TestCase
{
    use RefreshDatabase;

    public function test_honeypot_submissions_are_silently_dismissed(): void
    {
        $this->post('/signup', [
            'name' => 'Spam Bot',
            'email' => 'spam@example.com',
            'password' => 'password123',
            'password_confirmation' => 'password123',
            'terms' => '1',
            'website' => 'http://spammer.example.com',
        ])->assertRedirect(route('home'));

        $this->assertDatabaseMissing('users', ['email' => 'spam@example.com']);
    }

    public function test_signup_is_rate_limited(): void
    {
        $this->post('/signup', []);
        $this->post('/signup', []);
        $this->post('/signup', []);

        $this->post('/signup', [])->assertStatus(429);
    }
}
