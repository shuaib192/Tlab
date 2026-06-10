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
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
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

    // --- Helpers ---

    public function isParent()
    {
        return in_array($this->role, ['parent', 'entrepreneur', 'aider', 'admin', 'super_admin']) || empty($this->role);
    }

    public function isTeacher()
    {
        return $this->role === 'teacher';
    }

    public function isSchoolAdmin()
    {
        return $this->role === 'school_admin';
    }

    public function isSuperAdmin()
    {
        return $this->role === 'super_admin';
    }
}
