<?php

namespace Tests\Unit;

use App\Models\Club;
use PHPUnit\Framework\TestCase;

class ClubAccentColorTest extends TestCase
{
    public function test_it_defaults_to_brand_teal_for_missing_or_grey_colours(): void
    {
        $this->assertSame(Club::ACCENTS['teal'], (new Club(['color_theme' => null]))->accentColor());
        $this->assertSame(Club::ACCENTS['teal'], (new Club(['color_theme' => '#000000']))->accentColor());
        $this->assertSame(Club::ACCENTS['teal'], (new Club(['color_theme' => '#808080']))->accentColor());
    }

    public function test_it_maps_the_legacy_dark_theme_greens_onto_the_brand_palette(): void
    {
        // the four colours historically seeded into clubs.color_theme
        $this->assertSame(Club::ACCENTS['teal'], (new Club(['color_theme' => '#4E9966']))->accentColor());
        $this->assertSame(Club::ACCENTS['gold'], (new Club(['color_theme' => '#D4A224']))->accentColor());
        $this->assertSame(Club::ACCENTS['coral'], (new Club(['color_theme' => '#C24B1E']))->accentColor());
        $this->assertSame(Club::ACCENTS['violet'], (new Club(['color_theme' => '#6B3FA0']))->accentColor());
    }

    public function test_it_groups_hues_into_the_brand_families(): void
    {
        $this->assertSame(Club::ACCENTS['blue'], (new Club(['color_theme' => '#2563EB']))->accentColor());
        $this->assertSame(Club::ACCENTS['coral'], (new Club(['color_theme' => '#EA580C']))->accentColor());
        $this->assertSame(Club::ACCENTS['teal'], (new Club(['color_theme' => '#16A34A']))->accentColor());
        $this->assertSame(Club::ACCENTS['teal'], (new Club(['color_theme' => '4E9966']))->accentColor());
    }
}
