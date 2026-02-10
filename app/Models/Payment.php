<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'dv_number',
        'dv_date',
        'amount',
        'payment_type',
        'status',
        'check_number',
        'check_date',
        'remarks',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'dv_date' => 'date',
        'check_date' => 'date',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}