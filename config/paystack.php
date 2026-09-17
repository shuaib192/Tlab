<?php

/*
|--------------------------------------------------------------------------
| Paystack
|--------------------------------------------------------------------------
|
| Config read by the Laravel Paystack package (vendor/unicodeveloper).
| The UnicodDeveloper facade loads these keys from this file on every
| transaction initialization, so they must be present for payments
| (`getAuthorizationUrl()`, webhook verification, etc.) to work.
|
*/

return [
    'publicKey' => env('PAYSTACK_PUBLIC_KEY'),

    'secretKey' => env('PAYSTACK_SECRET_KEY'),

    'paymentUrl' => env('PAYSTACK_PAYMENT_URL', 'https://api.paystack.co'),

    'merchantEmail' => env('PAYSTACK_MERCHANT_EMAIL'),
];
