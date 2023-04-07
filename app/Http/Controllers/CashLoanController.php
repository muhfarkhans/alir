<?php

namespace App\Http\Controllers;

use App\Models\MonthlyInstallment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CashLoan;
use App\Models\CommunityGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CashLoanController extends Controller
{
    public function index()
    {
        return view('cash-loan.index');
    }

    public function dataTablesCashLoan(Request $request)
    {
        if ($request->ajax()) {
            $data = CashLoan::with(['community_group'])->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('loan-period', function ($row) {
                    $period = $row->loan_period . ' bulan';
                    return $period;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('cash-loan.detail', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">Detail</a> 
                                  <a href="' . route('cash-loan.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'loan-period'])
                ->make(true);
        }
    }

    public function create()
    {
        $communityGroup = CommunityGroup::latest()->get();
        return view('cash-loan.create', ['group' => $communityGroup]);
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'community_group_id' => $request->input('community_group_id'),
            'total_loan' => $request->input('total_loan'),
            'loan_period' => $request->input('loan_period'),
        ];
        // return $dataCreate;

        Validator::make($request->all(), [
            'community_group_id' => 'required',
            'total_loan' => 'required|numeric',
            'loan_period' => 'required',
        ])->validate();

        $now = Carbon::now();
        $loanPeriod = $request->input('loan_period');
        $loan = $request->input('total_loan');
        $contribution = $loan * 0.12;
        $totalLoan = $loan + $contribution;

        $dataCreate['contribution'] = $contribution;
        $dataCreate['remaining_fund'] = $totalLoan;
        $dataCreate['monthly_payment'] = $loan / ($loanPeriod - 4);

        try {
            DB::transaction(function () use ($dataCreate, $loanPeriod, $now) {
                $cashData = CashLoan::create($dataCreate);
                $monthly = [];

                for ($i = 0; $i < $loanPeriod; $i++) {
                    if ($i < 4)
                        continue;

                    $monthly[] = [
                        'cash_loan_id' => $cashData->id,
                        'principal_payment' => 0,
                        'contribution_payment' => 0,
                        'installment_date' => Carbon::now()->addMonths($i)->startOfMonth(),
                        'created_at' => $now,
                        'updated_at' => $now
                    ];
                }
                MonthlyInstallment::insert($monthly);
            });
        } catch (\Throwable $th) {
            return redirect()->route('cash-loan.create');
        }
        return redirect()->route('cash-loan.index');
    }

    public function edit($id)
    {
        $cashLoan = CashLoan::find($id);
        $communityGroup = CommunityGroup::latest()->get();
        return view('cash-loan.edit', ['group' => $communityGroup, 'loan' => $cashLoan]);
    }

    public function detail($id)
    {
        $cashLoan = CashLoan::with(['community_group', 'monthly_installment'])->where('id', $id)->first();
        return view('cash-loan.detail', ['loan' => $cashLoan]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'community_group_id' => $request->input('community_group_id'),
            'total_loan' => $request->input('total_loan'),
            'loan_period' => $request->input('loan_period'),
        ];
        // return $dataCreate;

        Validator::make($request->all(), [
            'community_group_id' => 'required',
            'total_loan' => 'required|numeric',
            'loan_period' => 'required',
        ])->validate();

        $contribution = $request->input('total_loan') * 0.12;
        $dataUpdate['contribution'] = $contribution;
        $totalLoan = $request->input('total_loan') + $contribution;
        $dataUpdate['remaining_fund'] = $totalLoan;
        $dataUpdate['monthly_payment'] = $totalLoan / $request->input('loan_period');
        try {
            CashLoan::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('cash-loan.edit');
        }
        return redirect()->route('cash-loan.index');
    }

    public function delete($id)
    {
        try {
            CashLoan::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('cash-loan.index');
        }
        return redirect()->route('cash-loan.index');
    }
}