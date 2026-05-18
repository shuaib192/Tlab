<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Enrollment extends Model
{
    use HasFactory;

    protected $fillable = ['child_profile_id', 'course_id', 'status', 'payment_status'];

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }
}
