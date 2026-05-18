<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Club extends Model
{
    use HasFactory;

    protected $fillable = ['name', 'slug', 'description', 'color_theme', 'icon'];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
