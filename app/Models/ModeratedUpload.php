<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ModeratedUpload extends Model
{
    use HasFactory;

    protected $fillable = ['child_profile_id', 'file_url', 'file_name', 'file_type', 'file_size', 'status', 'moderated_by', 'moderated_at', 'reason'];

    protected $casts = ['moderated_at' => 'datetime', 'file_size' => 'integer'];

    public function child()
    {
        return $this->belongsTo(ChildProfile::class);
    }

    public function moderator()
    {
        return $this->belongsTo(User::class, 'moderated_by');
    }

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function scopeApproved($q)
    {
        return $q->where('status', 'approved');
    }
}
