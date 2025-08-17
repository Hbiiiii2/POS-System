<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id',
        'amount_paid',
        'change',
    ];

    protected $casts = [
        'amount_paid' => 'decimal:2',
        'change' => 'decimal:2',
    ];

    /**
     * Get the transaction that owns the payment.
     */
    public function transaction()
    {
        return $this->belongsTo(Transaction::class);
    }
}
