<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'edfrica' => [
        'url' => env('EDFRICA_AUTH_URL', 'https://auth.edfrica.org'),
        'client_id' => env('EDFRICA_CLIENT_ID'),
        'client_secret' => env('EDFRICA_CLIENT_SECRET'),
    ],

    'paystack' => [
        'key' => env('PAYSTACK_PUBLIC_KEY'),
        'secret' => env('PAYSTACK_SECRET_KEY'),
        'payment_url' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),
        'merchant_email' => env('PAYSTACK_MERCHANT_EMAIL'),
    ],

    /*
    | Live classrooms run on a Jitsi Meet domain. Defaults to the public
    | meet.jit.si bridge for day one; flip JITSI_DOMAIN to a self-hosted
    | instance whenever you're ready (no code changes required).
    |
    | JWT auth (app id/secret) is only used when talking to a self-hosted
    | Jitsi instance configured for JWT authentication. Public meet.jit.si
    | never receives a token.
    */
    'jitsi' => [
        'domain' => env('JITSI_DOMAIN', 'meet.jit.si'),
        'app_id' => env('JITSI_APP_ID', ''),
        'app_secret' => env('JITSI_APP_SECRET', ''),
        'jwt_enabled' => env('JITSI_JWT_ENABLED', false),
        'room_prefix' => env('JITSI_ROOM_PREFIX', 'tlab'),
        'force_lobby' => env('JITSI_FORCE_LOBBY', true),
    ],

];
