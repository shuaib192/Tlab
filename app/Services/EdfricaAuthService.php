<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class EdfricaAuthService
{
    protected $baseUrl;

    public function __construct()
    {
        $this->baseUrl = config('services.edfrica.url', 'https://auth.edfrica.org');
    }

    public function login($email, $password)
    {
        $response = Http::post("{$this->baseUrl}/api/login", [
            'email' => $email,
            'password' => $password,
        ]);

        return $response->json();
    }

    public function register($data)
    {
        $response = Http::post("{$this->baseUrl}/api/register", $data);

        return $response->json();
    }

    public function forgotPassword($email)
    {
        $response = Http::post("{$this->baseUrl}/api/forgot-password", [
            'email' => $email,
        ]);

        return $response->json();
    }

    public function resetPassword($data)
    {
        $response = Http::post("{$this->baseUrl}/api/reset-password", $data);

        return $response->json();
    }

    public function getUser($token)
    {
        $response = Http::withToken($token)->get("{$this->baseUrl}/api/user");

        return $response->json();
    }
}
