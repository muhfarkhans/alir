<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MonthlyInstallment extends Model
{
    use HasFactory;

    protected $table = 'monthly_installments';

    protected $fillable = [
        'cash_loan_id',
        'principal_payment',
        'contribution_payment',
        'installment_date',
    ];

    public function cash_loan()
    {
        return $this->hasOne(CashLoan::class, 'id', 'cash_loan_id');
    }
}