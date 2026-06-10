<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoanReturn extends Model
{
    use HasFactory;

    protected $fillable = [
        'loan_id',
        'return_date',
        'late_days',
        'fine_amount',
        'notes',
    ];

    protected $casts = [
        'return_date' => 'date',
    ];

    public function loan()
    {
        return $this->belongsTo(Loan::class);
    }

    public function finePayment()
    {
        return $this->hasOne(FinePayment::class);
    }
}
