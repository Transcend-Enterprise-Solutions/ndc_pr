<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Budget extends Model
{
    use HasFactory;

    protected $fillable = [
        'fiscal_year',
        'department',
        'total_amount',
        'status',
        'description',
    ];

    protected $casts = [
        'total_amount' => 'decimal:2',
    ];

    public function procurementPlannings(): HasMany
    {
        return $this->hasMany(ProcurementPlanning::class);
    }

    public function reviews(): HasMany
    {
        return $this->hasMany(BudgetReview::class);
    }

    public function isApproved(): bool
    {
        return $this->status === 'approved';
    }
}