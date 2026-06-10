<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CommunicationLog extends Model
{
    use HasFactory;

    protected $fillable = ['teacher_id', 'parent_id', 'child_profile_id', 'subject', 'message', 'type', 'is_read'];

    protected $casts = ['is_read' => 'boolean'];

    public function teacher()
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    public function parent()
    {
        return $this->belongsTo(User::class, 'parent_id');
    }

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }

    public function scopeUnread($q)
    {
        return $q->where('is_read', false);
    }
}
