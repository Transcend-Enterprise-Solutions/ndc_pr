<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class MonitoringReport extends Model
{
    use HasFactory;

    protected $fillable = [
        'contract_id',
        'report_type',
        'report_date',
        'percentage_completed',
        'status',
        'observations',
        'issues',
        'recommendations',
        'prepared_by',
    ];

    protected $casts = [
        'report_date' => 'date',
        'percentage_completed' => 'decimal:2',
    ];

    public function contract(): BelongsTo
    {
        return $this->belongsTo(Contract::class);
    }
}