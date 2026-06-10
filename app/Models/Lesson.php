<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Lesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'module_id', 'title', 'slug', 'content', 'type',
        'video_url', 'duration', 'sort_order', 'is_free', 'is_published',
    ];

    protected $casts = [
        'is_free' => 'boolean',
        'is_published' => 'boolean',
    ];

    public function module()
    {
        return $this->belongsTo(Module::class);
    }

    public function assessment()
    {
        return $this->hasOne(Assessment::class);
    }

    public function assignments()
    {
        return $this->hasMany(Assignment::class);
    }
}
