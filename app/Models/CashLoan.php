<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CashLoan extends Model
{
    protected $table = 'cash_loans';

    protected $fillable = [
        'community_group_id',
        'loan_period',
        'total_loan',
        'contribution',
        'monthly_payment',
        'remaining_fund',
    ];

    public function community_group()
    {
        return $this->hasOne(CommunityGroup::class, 'id', 'community_group_id');
    }

    use HasFactory;
}
