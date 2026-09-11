<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'club_id', 'title', 'slug', 'description', 'level',
        'teacher_id', 'grade_level', 'thumbnail', 'fee', 'is_published',
    ];

    protected $casts = ['is_published' => 'boolean'];

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

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function modules()
    {
        return $this->hasMany(Module::class)->orderBy('sort_order');
    }

    public function cohorts()
    {
        return $this->hasMany(Cohort::class);
    }

    public function sessions()
    {
        return $this->hasMany(ClassSession::class);
    }

    public function certificates()
    {
        return $this->hasMany(Certificate::class);
    }

    /**
     * Whether a staff user may manage/teach this course.
     *
     * The admin UI has no teacher-assignment selector, so admin-created courses
     * are unclaimed (teacher_id = null). Any staff member may teach an unclaimed
     * course; only the owning teacher (when one exists) may teach a claimed one.
     */
    public function canBeManagedBy(User $user): bool
    {
        if ($this->teacher_id !== null) {
            return $this->teacher_id === $user->id;
        }

        return $user->isStaff();
    }
}
