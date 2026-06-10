<?php
namespace App\Models;
use Illuminate\Database\Eloquent\Model;
class FeatureFlag extends Model
{
    protected $fillable = ['key', 'name', 'description', 'enabled_for_roles', 'enabled_for_users', 'is_active', 'staging_only'];
    protected $casts = [
        'enabled_for_roles' => 'array',
        'enabled_for_users' => 'array',
        'is_active' => 'boolean',
        'staging_only' => 'boolean',
    ];

    public function scopeActive($q) { return $q->where('is_active', true); }

    public static function isEnabled($key, $user = null): bool
    {
        $flag = static::where('key', $key)->where('is_active', true)->first();
        if (!$flag) return false;
        if (!$flag->staging_only && app()->environment('production') && !$user) return true;
        if ($flag->staging_only && app()->environment('production')) {
            if (!$user) return false;
            $roles = $flag->enabled_for_roles ?? [];
            $users = $flag->enabled_for_users ?? [];
            if (in_array($user->id, $users)) return true;
            if (in_array($user->role, $roles)) return true;
            return false;
        }
        return true;
    }
}
