<?php

namespace App\Http\Controllers;

use App\Models\CashLoanMember;
use App\Models\MonthlyInstallment;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\CashLoan;
use App\Models\CommunityGroup;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;
use Yajra\DataTables\DataTables;

class CashLoanController extends Controller
{
    public function index()
    {
        return view('cash-loan.index');
    }

    public function dataTablesCashLoan(Request $request)
    {
        if ($request->ajax()) {
            $data = CashLoan::latest()->get();
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
            'market_id' => $request->input('market_id'),
            'code_dpm' => $request->input('code_dpm'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'disbursement_date' => $request->input('disbursement_date'),
            'due_date' => $request->input('due_date'),
            'total_loan' => $request->input('total_loan'),
            'loan_period' => $request->input('loan_period'),
            'contribution' => ((int) $request->input('total_loan')) * (((int) $request->input('contribution_percentage')) / 100),
            'contribution_percentage' => $request->input('contribution_percentage'),
            'contribution_tolerance' => (((int) $request->input('total_loan')) * (((int) $request->input('contribution_percentage')) / 100) / (((int) $request->input('loan_period')) - 4) * 10),
            'status' => 0,
        ];

        Validator::make($request->all(), [
            'market_id' => 'required',
            'code_dpm' => 'required',
            'name' => 'required',
            'address' => 'required',
            'disbursement_date' => 'required',
            'due_date' => 'required',
            'total_loan' => 'required',
            'loan_period' => 'required',
            'contribution_percentage' => 'required',
        ])->validate();

        $now = Carbon::now();
        $loanPeriod = $request->input('loan_period');

        try {
            DB::transaction(function () use ($dataCreate, $loanPeriod, $now, $request) {
                $cashData = CashLoan::create($dataCreate);
                $monthly = [];

                foreach ($request->input('peminjam-nama') as $key => $value) {
                    CashLoanMember::create([
                        'cash_loan_id' => $cashData->id,
                        'position' => $request->input('peminjam-jabatan')[$key],
                        'name' => $request->input('peminjam-nama')[$key],
                        'phone' => $request->input('peminjam-hp')[$key],
                        'address' => $request->input('peminjam-alamat')[$key],
                        'nik' => $request->input('peminjam-nik')[$key],
                        'gurantor_name' => $request->input('penjamin-nama')[$key],
                        'gurantor_nik' => $request->input('penjamin-nik')[$key],
                        'gurantor_phone' => $request->input('penjamin-hp')[$key],
                        'gurantor_address' => $request->input('penjamin-alamat')[$key],
                    ]);
                }

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
            throw $th;
            // return redirect()->route('cash-loan.create');
        }
        return redirect()->route('cash-loan.index');
    }

    public function edit($id)
    {
        $cashLoan = CashLoan::find($id);
        return view('cash-loan.edit', ['loan' => $cashLoan]);
    }

    public function detail($id)
    {
        $cashLoan = CashLoan::with(['monthly_installment'])->where('id', $id)->first();
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
            DB::transaction(function () use ($id) {
                CashLoan::where('id', $id)->delete();
                MonthlyInstallment::where('cash_loan_id', $id)->delete();
            });
        } catch (\Throwable $th) {
            return redirect()->route('cash-loan.index');
        }
        return redirect()->route('cash-loan.index');
    }

    public function paidOff($id)
    {
        $dataUpdate = [
            'loan_status' => 'done',
        ];

        try {
            CashLoan::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('cash-loan.detail', $id);
        }
        return redirect()->route('cash-loan.detail', $id);
    }

    public function checkMember(Request $request)
    {
        $checkApplicant = true;
        $checkGurantor = true;

        $applicant = CashLoanMember::with('cashloan')
            ->where('nik', $request->nik)
            ->orWhere('gurantor_nik', $request->nik)
            ->get();
        foreach ($applicant as $value) {
            if ($value->status == 1)
                $checkApplicant = false;
        }

        $gurantor = CashLoanMember::with('cashloan')
            ->where('nik', $request->gurantor_nik)
            ->orWhere('gurantor_nik', $request->gurantor_nik)
            ->get();
        foreach ($gurantor as $value) {
            if ($value->status == 1)
                $checkGurantor = false;
        }

        if ($checkApplicant && $checkGurantor) {
            return 1;
        }

        return 0;
    }
}