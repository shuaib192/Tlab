<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class License extends Model
{
    use HasFactory;

    protected $fillable = ['school_id', 'type', 'seats', 'used_seats', 'start_date', 'end_date', 'status'];

    protected $casts = ['start_date' => 'date', 'end_date' => 'date'];

    public function school()
    {
        return $this->belongsTo(School::class);
    }

    public function scopeActive($q)
    {
        return $q->where('status', 'active');
    }

    public function seatsRemaining()
    {
        return $this->seats - $this->used_seats;
    }
}
