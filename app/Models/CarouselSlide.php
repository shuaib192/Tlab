<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CarouselSlide extends Model
{
    protected $fillable = [
        'title', 'body', 'image', 'link', 'link_text',
        'bg_color', 'active', 'sort_order',
    ];

    protected $casts = ['active' => 'boolean'];

    public static function active()
    {
        return static::where('active', true)
            ->orderBy('sort_order')
            ->orderBy('id')
            ->get();
    }
}
