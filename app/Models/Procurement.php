<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

class Procurement extends Model
{
    use HasFactory;

    protected $fillable = [
        'procurement_planning_id',
        'pr_number',
        'pr_date',
        'purpose',
        'status',
    ];

    protected $casts = [
        'pr_date' => 'date',
    ];

    public function procurementPlanning(): BelongsTo
    {
        return $this->belongsTo(ProcurementPlanning::class);
    }

    public function contract(): HasOne
    {
        return $this->hasOne(Contract::class);
    }

    public function audits(): HasMany
    {
        return $this->hasMany(Audit::class);
    }
}