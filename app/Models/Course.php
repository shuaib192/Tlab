<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = ['club_id', 'title', 'slug', 'description', 'level'];

    public function club()
    {
        return $this->belongsTo(Club::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function children()
    {
        return $this->belongsToMany(ChildProfile::class, 'enrollments', 'course_id', 'child_profile_id');
    }
}
