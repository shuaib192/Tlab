<?php

namespace App\Rules;

use Illuminate\Contracts\Validation\Rule;

class AllowlistedUrl implements Rule
{
    public function passes($attribute, $value): bool
    {
        if (! is_string($value) || trim($value) === '') {
            return true;
        }

        $host = strtolower((string) parse_url($value, PHP_URL_HOST));
        $host = preg_replace('/^www\./', '', $host);

        if (! $host) {
            return false;
        }

        foreach (config('safe_links.domains', []) as $allowed) {
            $allowed = strtolower($allowed);
            if ($host === $allowed || str_ends_with($host, '.'.$allowed)) {
                return true;
            }
        }

        return false;
    }

    public function message(): string
    {
        return 'The project link must be from an approved platform (Scratch, Replit, GitHub, Google Drive/Docs, Figma, Canva, Tinkercad, Code.org, Microsoft MakeCode, Trinket).';
    }
}