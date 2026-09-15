<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProgrammeRegistration extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_name',
        'phone',
        'email',
        'child_name',
        'child_age',
        'programme',
        'device',
        'payment_option',
        'amount',
        'status',
        'reference',
        'gateway_transaction',
        'gateway_channel',
        'paid_at',
    ];

    protected $casts = [
        'paid_at' => 'datetime',
    ];

    public function recordPaystackSuccess(array $data): void
    {
        $this->update([
            'status' => 'paid',
            'gateway_transaction' => $data['id'] ?? $this->gateway_transaction,
            'gateway_channel' => $data['channel'] ?? $this->gateway_channel,
            'paid_at' => now(),
        ]);
    }
}
