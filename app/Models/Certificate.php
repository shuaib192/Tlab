<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Certificate extends Model
{
    use HasFactory;

    protected $fillable = [
        'certificate_id', 'child_profile_id', 'course_id',
        'type', 'title', 'grade', 'metadata', 'file_url', 'issued_at',
    ];

    protected $casts = [
        'metadata' => 'array',
        'issued_at' => 'datetime',
    ];

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public static function generateId(): string
    {
        return 'TLAB-'.strtoupper(substr(uniqid(), -8)).'-'.strtoupper(bin2hex(random_bytes(4)));
    }
}
