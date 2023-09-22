<?php

namespace App\Http\Controllers;
use App\Models\CashLoan; 
use App\Models\CashLoanMember; 
use App\Models\User; 

use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {   
        $data = [
            'total_user' => User::count(),
            'total_cash_loan' => CashLoan::count(),
            'total_nominal_loan' => CashLoan::sum('total_loan'),
            'total_cash_loan_member' => CashLoanMember::count()
        ];
        return view('dashboard', compact('data'));
    }
}