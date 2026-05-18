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

    // --- Helpers ---

    public function isParent()
    {
        return $this->role === 'parent';
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
