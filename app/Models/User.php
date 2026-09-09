<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
        'edfrica_id',
        'role',
        'avatar',
        'phone',
        'school_name',
        'school_id',
        'is_active',
        'suspended_at',
        'suspended_reason',
        'two_factor_enabled',
        'two_factor_enrolled_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
        'is_active' => 'boolean',
        'suspended_at' => 'datetime',
        'two_factor_enabled' => 'boolean',
        'two_factor_enrolled_at' => 'datetime',
    ];

    // --- Relationships ---

    public function children()
    {
        return $this->hasMany(ChildProfile::class);
    }

    public function subscriptions()
    {
        return $this->hasMany(Subscription::class);
    }

    public function activeSubscription()
    {
        return $this->hasOne(Subscription::class)->where('status', 'active')->latest();
    }

    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function notifications()
    {
        return $this->hasMany(Notification::class);
    }

    public function unreadNotifications()
    {
        return $this->hasMany(Notification::class)->where('is_read', false);
    }

    public function taughtCourses()
    {
        return $this->hasMany(Course::class, 'teacher_id');
    }

    public const ROLE_SUPER_ADMIN = 'super_admin';

    public const ROLE_ADMIN = 'admin';

    public const ROLE_FACILITATOR = 'facilitator';

    public const ROLE_PARENT = 'parent';

    public const ROLE_SCHOOL_ADMIN = 'school_admin';

    // --- Helpers ---

    public function isParent()
    {
        return in_array($this->role, ['parent', 'entrepreneur', 'aider', 'admin', 'super_admin', 'facilitator']) || empty($this->role);
    }

    public function isTeacher()
    {
        return in_array($this->role, ['teacher', self::ROLE_FACILITATOR]);
    }

    public function isSchoolAdmin()
    {
        return $this->role === self::ROLE_SCHOOL_ADMIN;
    }

    public function isSuperAdmin()
    {
        return $this->role === self::ROLE_SUPER_ADMIN;
    }

    public function isAdmin()
    {
        return in_array($this->role, [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN]);
    }

    public function isStaff()
    {
        return in_array($this->role, [
            self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN, self::ROLE_FACILITATOR,
            'teacher', self::ROLE_SCHOOL_ADMIN,
        ]);
    }

    public function isSuspended(): bool
    {
        return $this->is_active === false || $this->suspended_at !== null;
    }

    public function homeRoute(): string
    {
        if (in_array($this->role, [self::ROLE_ADMIN, self::ROLE_SUPER_ADMIN])) {
            return 'admin.dashboard';
        }

        if (in_array($this->role, ['teacher', self::ROLE_FACILITATOR])) {
            return 'teacher.dashboard';
        }

        if ($this->role === self::ROLE_SCHOOL_ADMIN) {
            return 'school.dashboard';
        }

        return 'parent.dashboard';
    }

    public function requiresTwoFactor(): bool
    {
        return $this->isStaff() && $this->two_factor_enabled;
    }

    public function revokeAllSessions(): void
    {
        \DB::table('sessions')->where('user_id', $this->id)->delete();
    }
}
