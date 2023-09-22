<?php

namespace App\Http\Controllers;

use App\Models\MonthlyInstallment;
use App\Models\CashLoan;
use Carbon\Carbon;
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
            DB::transaction(function () use ($request, $dataUpdate, $id) {
                MonthlyInstallment::where('id', $id)->update($dataUpdate);
                $monthly = MonthlyInstallment::where('id', $id)->first();
                $cashLoan = CashLoan::with(['monthly_installment'])->where('id', $monthly->cash_loan_id)->first();

                $updateLoan = [
                    'status' => 0,
                    'remaining_loan' => $cashLoan->remaining_loan - ($request->input('principal_payment') + $request->input('contribution_payment'))
                ];
                $totalMustPay = $cashLoan->total_loan + $cashLoan->contribution;
                $totalPayment = 0;
                // foreach ($cashLoan->monthly_installment as $item) {
                //     $totalPayment += ($item->principal_payment + $item->contribution_payment);
                // }

                $now = Carbon::now();
                $toleranceMonth = Carbon::parse($cashLoan->disbursement_date)->addMonths(10);
                if ($now->lte($toleranceMonth)) {
                    $totalMustPay = $cashLoan->total_loan + $cashLoan->contribution_tolerance;
                }

                // if ($totalMustPay <= $totalPayment) {
                //     $updateLoan = ['status' => 1];
                // }
                if ($updateLoan['remaining_loan'] <= 0) {
                    $updateLoan = [
                        'status' => 1,
                        'remaining_loan' => $cashLoan->remaining_loan - ($request->input('principal_payment') + $request->input('contribution_payment'))
                    ];
                }
                CashLoan::where('id', $monthly->cash_loan_id)->update($updateLoan);
            });
        } catch (\Throwable $th) {
            throw $th;
        }

        return 1;
    }
}