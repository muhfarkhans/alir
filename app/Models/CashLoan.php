<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashLoan extends Model
{
    use HasFactory;

    protected $table = 'cash_loans';

    protected $fillable = [
        'market_id',
        'code_dpm',
        'name',
        'address',
        'disbursement_date',
        'due_date',
        'total_loan',
        'loan_period',
        'contribution',
        'contribution_percentage',
        'contribution_tolerance',
        'status',
    ];

    public function members()
    {
        return $this->hasMany(CashLoanMember::class, 'cashloan_id', 'id');
    }

    public function monthly_installment()
    {
        return $this->hasMany(MonthlyInstallment::class, 'cash_loan_id', 'id');
    }
}