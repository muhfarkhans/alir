<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashLoanMember extends Model
{
    use HasFactory;

    protected $table = 'cash_loan_members';

    protected $fillable = [
        'cash_loan_id',
        'position',
        'name',
        'phone',
        'address',
        'nik',
        'gurantor_name',
        'gurantor_nik',
        'gurantor_phone',
        'gurantor_address',
    ];

    public function cashloan()
    {
        return $this->hasOne(CashLoan::class, 'id', 'cash_loan_id');
    }
}