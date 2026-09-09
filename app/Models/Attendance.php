<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Attendance extends Model
{
    use HasFactory;

    protected $table = 'attendance';

    protected $fillable = [
        'session_id', 'child_profile_id', 'status', 'notes', 'marked_by',
        'edit_reason', 'edited_at',
    ];

    protected $casts = [
        'marked_at' => 'datetime',
        'edited_at' => 'datetime',
    ];

    public function session()
    {
        return $this->belongsTo(ClassSession::class, 'session_id');
    }

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function marker()
    {
        return $this->belongsTo(User::class, 'marked_by');
    }

    public function isOlderThanHours(int $hours): bool
    {
        return $this->marked_at && $this->marked_at->diffInHours(now()) >= $hours;
    }
}
