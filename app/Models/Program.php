<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Program extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'slug',
        'tagline',
        'discipline',
        'ages',
        'color',
        'accent_color',
        'gradient',
        'icon_svg',
        'description',
        'what_learn',
        'outcomes',
        'career_paths',
        'featured_image',
        'sort_order',
        'is_active',
    ];

    protected $casts = [
        'what_learn' => 'array',
        'outcomes' => 'array',
        'career_paths' => 'array',
        'is_active' => 'boolean',
        'sort_order' => 'integer',
    ];

    public function growthStages(): HasMany
    {
        return $this->hasMany(ProgramGrowthStage::class)->orderBy('sort_order')->orderBy('min_age');
    }

    public function scopeActive($query)
    {
        return $query->where('is_active', true)->orderBy('sort_order');
    }

    public function courses(): HasMany
    {
        return $this->hasMany(Course::class);
    }
}
