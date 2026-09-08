<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LiveSession extends Model
{
    use HasFactory;

    public const STATUS_SCHEDULED = 'scheduled';

    public const STATUS_LIVE = 'live';

    public const STATUS_ENDED = 'ended';

    protected $fillable = [
        'class_session_id', 'course_id', 'title', 'room_name', 'jitsi_domain',
        'status', 'scheduled_at', 'duration_minutes', 'started_at', 'ended_at', 'host_id',
    ];

    protected $casts = [
        'scheduled_at' => 'datetime',
        'started_at' => 'datetime',
        'ended_at' => 'datetime',
    ];

    protected $appends = ['ends_at'];

    public function classSession()
    {
        return $this->belongsTo(ClassSession::class);
    }

    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    public function host()
    {
        return $this->belongsTo(User::class, 'host_id');
    }

    public function isLive(): bool
    {
        return $this->status === self::STATUS_LIVE;
    }

    public function isEnded(): bool
    {
        return $this->status === self::STATUS_ENDED;
    }

    public function getEndsAtAttribute()
    {
        if (! $this->started_at) {
            return $this->scheduled_at?->addMinutes($this->duration_minutes);
        }

        return $this->started_at->copy()->addMinutes($this->duration_minutes);
    }
}
