<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Safe-Link Allowlist
    |--------------------------------------------------------------------------
    |
    | Child project submissions may only link to approved, education-safe
    | platforms (PRD §5.3 "Safe-link filtering — allowlisted domains only").
    | A host matches if it exactly equals one of these domains or is a
    | subdomain of one of them (e.g. "anything.github.com").
    |
    */

    'domains' => [
        'github.com',
        'replit.com',
        'repl.it',
        'scratch.mit.edu',
        'drive.google.com',
        'docs.google.com',
        'figma.com',
        'canva.com',
        'tinkercad.com',
        'code.org',
        'studio.code.org',
        'youtube.com',
        'youtu.be',
        'vimeo.com',
        'loom.com',
        'trinket.io',
        'makecode.microbit.org',
        'makecode.adafruit.com',
        'makecode.arcade.com',
    ],

];