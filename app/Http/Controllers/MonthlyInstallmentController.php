<?php

namespace App\Http\Controllers;

use App\Models\MonthlyInstallment;
use App\Models\CashLoan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\DB;
use Yajra\DataTables\DataTables;

class MonthlyInstallmentController extends Controller
{
    public function dataTablesMonthly(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = MonthlyInstallment::with(['cash_loan'])->where('cash_loan_id', $id)->get();
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="edit btn btn-success btn-sm" onclick="setFormData(' . $row->id . ')">Edit</button>';
                    return $actionBtn;
                })
                ->addColumn('monthlycontribution', function ($row) {
                    if ($row->cash_loan->loan_period == 12) {
                        $monthlyContibution = $row->cash_loan->contribution / 8;
                    } elseif ($row->cash_loan->loan_period == 24) {
                        $monthlyContibution = $row->cash_loan->contribution / 20;
                    } elseif ($row->cash_loan->loan_period == 36) {
                        $monthlyContibution = $row->cash_loan->contribution / 32;
                    }
                    return $monthlyContibution;
                })
                ->addColumn('monthly_payment', function ($row) {
                    return $row->total_loan / ($row->loan_period - 4);
                })
                ->addColumn('updated_at', function ($row) {
                    return $row->updated_at->format('Y-m-d');
                })
                ->rawColumns(['action', 'monthlycontribution', 'monthly_payment', 'updated_at'])
                ->make(true);
        }
    }

    public function find(Request $request)
    {
        $monthly = MonthlyInstallment::where('id', $request->id)->first();

        return response()->json($monthly);
    }

    public function updateAPI(Request $request, $id)
    {
        $dataUpdate = [
            'principal_payment' => $request->input('principal_payment'),
            'contribution_payment' => $request->input('contribution_payment'),
        ];

        Validator::make($request->all(), [
            'principal_payment' => 'required',
            'contribution_payment' => 'required',
        ])->validate();

        try {
            DB::transaction(function () use ($dataUpdate, $id) {
                MonthlyInstallment::where('id', $id)->update($dataUpdate);

                $getMonthly = MonthlyInstallment::where('id', $id)->first();
                $getCashLoan = CashLoan::where('id', $getMonthly->cash_loan_id)->first();
                $remainingFund = $getCashLoan->remaining_fund - ($dataUpdate['principal_payment'] + $dataUpdate['contribution_payment']);
                $updateCashLoan = ['remaining_fund' => $remainingFund];
                CashLoan::where('id', $getMonthly->cash_loan_id)->update($updateCashLoan);
            });
        } catch (\Throwable $th) {
            //throw $th;
            return false;
        }

        return true;
    }
}