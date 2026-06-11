<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Cache;

class SiteSetting extends Model
{
    protected $fillable = ['key', 'value', 'group', 'type', 'label'];

    /**
     * Get a setting value by key, with an optional default.
     */
    public static function get(string $key, $default = null)
    {
        return Cache::rememberForever("setting:{$key}", function () use ($key, $default) {
            $setting = static::where('key', $key)->first();

            return $setting ? $setting->value : $default;
        });
    }

    /**
     * Set a setting value and bust the cache.
     */
    public static function set(string $key, $value): void
    {
        static::updateOrCreate(['key' => $key], ['value' => $value]);
        Cache::forget("setting:{$key}");
    }

    /**
     * Get all settings grouped.
     */
    public static function getAllGrouped(): array
    {
        return static::all()->groupBy('group')->toArray();
    }
}
