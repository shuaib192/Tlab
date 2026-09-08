<?php

namespace App\Services;

use App\Models\LiveSession;
use App\Models\User;

class JitsiService
{
    public function domain(): string
    {
        $domain = config('services.jitsi.domain', 'meet.jit.si');
        $override = \App\Models\SiteSetting::get('jitsi_domain');

        return $override ?: $domain;
    }

    public function isJwtEnabled(): bool
    {
        return filter_var(
            config('services.jitsi.jwt_enabled', false),
            FILTER_VALIDATE_BOOLEAN
        ) && config('services.jitsi.app_id') && config('services.jitsi.app_secret');
    }

    public function shouldForceLobby(): bool
    {
        return filter_var(config('services.jitsi.force_lobby', true), FILTER_VALIDATE_BOOLEAN);
    }

    public function generateRoomName(LiveSession $session): string
    {
        $prefix = preg_replace('/[^a-z0-9-]/i', '', config('services.jitsi.room_prefix', 'tlab')) ?: 'tlab';
        $course = $session->course;
        $slug = $course ? preg_replace('/[^a-zA-Z0-9-]/', '', str_replace(' ', '-', strtolower($course->title))) : 'live';

        return strtolower($prefix)
            .'-'.(strlen($slug) > 24 ? substr($slug, 0, 24) : $slug)
            .'-'.$session->id
            .'-'.substr(bin2hex(random_bytes(6)), 0, 12);
    }

    public function externalApiUrl(): string
    {
        return 'https://'.$this->domain().'/external_api.js';
    }

    /**
     * Build a signed Jitsi JWT (HS256) for self-hosted instances configured
     * with JWT authentication. Returns null on the public bridge.
     *
     * Payload shape follows the Jitsi "jwt" documentation:
     * https://developer.8x8.com/guide/token
     */
    public function buildJwt(LiveSession $session, array $identity, bool $moderator): ?string
    {
        if (! $this->isJwtEnabled()) {
            return null;
        }

        $appId = config('services.jitsi.app_id');
        $secret = config('services.jitsi.app_secret');
        $issuer = config('services.jitsi.app_id');

        $header = $this->base64Url(json_encode([
            'alg' => 'HS256',
            'typ' => 'JWT',
            'kid' => $appId,
        ]));

        $payload = $this->base64Url(json_encode([
            'context' => [
                'user' => array_filter([
                    'name' => $identity['name'] ?? 'TLab Student',
                    'email' => $identity['email'] ?? null,
                    'avatar' => $identity['avatar'] ?? null,
                ]),
            ],
            'aud' => 'jitsi',
            'iss' => $issuer,
            'sub' => $this->domain(),
            'room' => $session->room_name,
            'moderator' => $moderator,
            'exp' => time() + 21600,
            'nbf' => time() - 30,
        ]));

        $signature = $this->base64Url(
            hash_hmac('sha256', $header.'.'.$payload, $secret, true)
        );

        return $header.'.'.$payload.'.'.$signature;
    }

    public function displayNameFor(?User $user, ?string $childName): string
    {
        if ($childName) {
            return $childName;
        }

        return $user?->name ?? 'Guest';
    }

    protected function base64Url(string $data): string
    {
        return rtrim(strtr(base64_encode($data), '+/', '-_'), '=');
    }
}
