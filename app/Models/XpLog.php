<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class XpLog extends Model
{
    use HasFactory;

    protected $fillable = ['child_profile_id', 'amount', 'activity'];

    public function child()
    {
        return $this->belongsTo(ChildProfile::class, 'child_profile_id');
    }
}
