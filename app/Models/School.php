<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class School extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'email', 'phone', 'address', 'city', 'state', 'country', 'status', 'max_students', 'subscription_tier'];

    public function licenses()
    {
        return $this->hasMany(License::class);
    }

    public function teachers()
    {
        return User::where('school_id', $this->id)->where('role', 'teacher');
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }
}
