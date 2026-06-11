<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SafeLink extends Model
{
    use HasFactory;

    protected $fillable = ['domain', 'is_allowed', 'category', 'description'];

    protected $casts = ['is_allowed' => 'boolean'];

    public function scopeAllowed($q)
    {
        return $q->where('is_allowed', true);
    }

    public static function isSafe($url)
    {
        $host = parse_url($url, PHP_URL_HOST);
        if (! $host) {
            return false;
        }
        $host = strtolower(preg_replace('/^www\./', '', $host));

        return static::allowed()->where('domain', $host)->exists();
    }
}
