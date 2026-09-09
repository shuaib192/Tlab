<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'reference', 'transaction_id', 'amount',
        'currency', 'channel', 'status', 'description', 'metadata', 'paid_at',
        'gateway', 'proof_path', 'proof_submitted_at', 'verified_at', 'verified_by',
        'rejection_reason', 'invoice_id',
    ];

    protected $casts = [
        'metadata' => 'array',
        'paid_at' => 'datetime',
        'proof_submitted_at' => 'datetime',
        'verified_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function invoice()
    {
        return $this->belongsTo(Invoice::class);
    }

    public function verifier()
    {
        return $this->belongsTo(User::class, 'verified_by');
    }

    public function isManual()
    {
        return $this->gateway === 'manual';
    }
}
