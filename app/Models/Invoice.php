<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Invoice extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'invoice_number', 'amount', 'currency', 'status', 'due_date', 'paid_at', 'items', 'notes'];

    protected $casts = ['items' => 'array', 'due_date' => 'date', 'paid_at' => 'datetime'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function scopePending($q)
    {
        return $q->where('status', 'pending');
    }

    public function scopeOverdue($q)
    {
        return $q->where('status', 'pending')->where('due_date', '<', now());
    }

    public static function generateNumber()
    {
        return 'INV-'.date('Y').'-'.str_pad(static::max('id') + 1 ?? 1, 5, '0', STR_PAD_LEFT);
    }
}
