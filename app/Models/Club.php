<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'color_theme', 'icon'];

    /**
     * Brand-consistent accent for the club, derived from its stored colour.
     *
     * color_theme holds arbitrary hex values set in the admin, which historically
     * produced a different palette per club and clashed with the TLab brand. Clubs
     * are now grouped into the four brand families instead, so cards stay on-brand
     * while each club keeps a distinct identity.
     */
    public function accentColor(): string
    {
        $hex = ltrim((string) $this->color_theme, '#');

        if (strlen($hex) === 6) {
            [$r, $g, $b] = array_map('hexdec', str_split($hex, 2));
            [$h, $s, $v] = $this->rgbToHsv($r, $g, $b);
        } else {
            [$h, $s, $v] = [0.0, 0.0, 0.0];
        }

        if ($v < 0.18 || $s < 0.12) {
            return self::ACCENTS['teal'];
        }

        // Reds/oranges -> coral, yellows/greens -> gold, blues -> blue, rest -> violet
        return match (true) {
            $h < 0.09 || $h >= 0.95 => self::ACCENTS['coral'],
            $h < 0.18 => self::ACCENTS['gold'],
            $h < 0.50 => self::ACCENTS['teal'],
            $h < 0.72 => self::ACCENTS['blue'],
            default => self::ACCENTS['violet'],
        };
    }

    public const ACCENTS = [
        'teal' => '#0DAA9C',
        'blue' => '#2563EB',
        'gold' => '#B08414',
        'coral' => '#C24B1E',
        'violet' => '#6B3FA0',
    ];

    /**
     * @return array{0: float, 1: float, 2: float}
     */
    protected function rgbToHsv(int $r, int $g, int $b): array
    {
        $rf = $r / 255;
        $gf = $g / 255;
        $bf = $b / 255;

        $max = max($rf, $gf, $bf);
        $min = min($rf, $gf, $bf);
        $delta = $max - $min;

        $h = 0.0;
        if ($delta > 0) {
            $h = match ($max) {
                $rf => fmod((($gf - $bf) / $delta), 6),
                $gf => (($bf - $rf) / $delta) + 2,
                default => (($rf - $gf) / $delta) + 4,
            } / 6;
        }

        return [$h, $max <= 0.0 ? 0.0 : $delta / $max, $max];
    }

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
