<?php

return [

    /*
    |--------------------------------------------------------------------------
    | TLab Enquiry Delivery
    |--------------------------------------------------------------------------
    |
    | Where contact-form submissions are delivered. Kept in config rather than
    | hardcoded so the address can change without touching application code.
    |
    */

    'admin_email' => env('TLAB_ADMIN_EMAIL', 'tlabadmin@edfrica.org'),

    'admin_name' => env('TLAB_ADMIN_NAME', 'TLab Admin'),

];
