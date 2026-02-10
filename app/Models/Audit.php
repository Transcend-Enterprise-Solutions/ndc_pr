<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Audit extends Model
{
    use HasFactory;

    protected $fillable = [
        'procurement_id',
        'audit_number',
        'audit_date',
        'auditor_name',
        'audit_type',
        'status',
        'findings',
        'recommendations',
        'compliance_status',
    ];

    protected $casts = [
        'audit_date' => 'date',
    ];

    public function procurement(): BelongsTo
    {
        return $this->belongsTo(Procurement::class);
    }
}