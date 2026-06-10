<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cohort extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id', 'name', 'slug', 'description',
        'start_date', 'end_date', 'session_time', 'session_days', 'status',
    ];

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function enrollments()
    {
        return $this->hasMany(Enrollment::class);
    }

    public function children()
    {
        return $this->hasManyThrough(ChildProfile::class, Enrollment::class, 'cohort_id', 'id', 'id', 'child_profile_id');
    }

    public function sessions()
    {
        return $this->hasMany(ClassSession::class);
    }
}
