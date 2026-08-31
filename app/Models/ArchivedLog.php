<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ArchivedLog extends Model
{
    use HasFactory;

    protected $fillable = ['original_type', 'original_id', 'data', 'archived_at'];

    protected $casts = [
        'data' => 'array',
        'archived_at' => 'datetime',
    ];
}
