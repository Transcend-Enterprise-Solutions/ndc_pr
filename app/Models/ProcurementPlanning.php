<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ProcurementPlanning extends Model
{
    use HasFactory;

    protected $fillable = [
        'budget_id',
        'item_description',
        'estimated_budget',
        'quantity',
        'unit_of_measure',
        'target_procurement_date',
        'procurement_mode',
        'status',
        'justification',
    ];

    protected $casts = [
        'estimated_budget' => 'decimal:2',
        'target_procurement_date' => 'date',
    ];

    public function budget(): BelongsTo
    {
        return $this->belongsTo(Budget::class);
    }

    public function procurements(): HasMany
    {
        return $this->hasMany(Procurement::class);
    }
}