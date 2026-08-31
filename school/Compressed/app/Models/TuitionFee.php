<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class TuitionFee extends Model
{
    use HasFactory;

    protected $fillable = [
        'grade_id',
        'academic_year',
        'annual_fee',
        'registration_fee',
        'cash_amount',
        'installment_amount',
        'installment_count',
        'first_term_amount',
        'second_term_amount',
        'sibling_discount',
        'notes',
        'status',
    ];

    protected function casts(): array
    {
        return [
            'annual_fee' => 'decimal:2',
            'registration_fee' => 'decimal:2',
            'cash_amount' => 'decimal:2',
            'installment_amount' => 'decimal:2',
            'first_term_amount' => 'decimal:2',
            'second_term_amount' => 'decimal:2',
            'sibling_discount' => 'decimal:2',
            'installment_count' => 'integer',
            'status' => 'boolean',
        ];
    }

    public function grade(): BelongsTo
    {
        return $this->belongsTo(Grade::class);
    }
}