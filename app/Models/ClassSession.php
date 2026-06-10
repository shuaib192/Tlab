<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClassSession extends Model
{
    use HasFactory;

    protected $table = 'class_sessions';

    protected $fillable = [
        'cohort_id', 'course_id', 'title', 'date', 'start_time',
        'end_time', 'meeting_url', 'notes', 'status',
    ];

    protected $casts = ['date' => 'date'];

    public function cohort()
    {
        return $this->belongsTo(Cohort::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function attendance()
    {
        return $this->hasMany(Attendance::class);
    }
}
