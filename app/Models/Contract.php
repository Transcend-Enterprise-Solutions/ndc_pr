<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Contract extends Model
{
    use HasFactory;

    protected $fillable = [
        'procurement_id',
        'contract_number',
        'supplier_name',
        'supplier_tin',
        'supplier_address',
        'contract_amount',
        'contract_date',
        'delivery_date',
        'delivery_days',
        'status',
        'terms_and_conditions',
    ];

    protected $casts = [
        'contract_amount' => 'decimal:2',
        'contract_date' => 'date',
        'delivery_date' => 'date',
    ];

    public function procurement(): BelongsTo
    {
        return $this->belongsTo(Procurement::class);
    }

    public function payments(): HasMany
    {
        return $this->hasMany(Payment::class);
    }

    public function monitoringReports(): HasMany
    {
        return $this->hasMany(MonitoringReport::class);
    }
}