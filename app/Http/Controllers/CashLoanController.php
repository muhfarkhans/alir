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
                    $actionBtn = '<a href="' . route('cash-loan.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                    <a href="' . route('cash-loan.detail', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">Detail</a> 
                                    <a href="' . route('cash-loan.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action', 'loan-period'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('cash-loan.create');
    }

    public function store(Request $request)
    {
        $contribution = ((int) $request->input('total_loan')) * (((int) $request->input('contribution_percentage')) / 100);
        $dataCreate = [
            'market_id' => $request->input('market_id'),
            'code_dpm' => $request->input('code_dpm'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'disbursement_date' => $request->input('disbursement_date'),
            'due_date' => $request->input('due_date'),
            'total_loan' => $request->input('total_loan'),
            'loan_period' => $request->input('loan_period'),
            'contribution' => $contribution,
            'contribution_percentage' => $request->input('contribution_percentage'),
            'contribution_tolerance' => (((int) $request->input('total_loan')) * (((int) $request->input('contribution_percentage')) / 100) / (((int) $request->input('loan_period')) - 4) * 10),
            'status' => 0,
            'remaining_loan' => $request->input('total_loan') + $contribution
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
        $disbursementDate = $request->input('disbursement_date');
        //return $disbursementDate;
        $disbursementDateConvert = Carbon::createFromFormat('Y-m-d', $disbursementDate);
        //return $disbursementDateConvert;
        //return $loanPeriod;

        try {
            DB::transaction(function () use ($dataCreate, $loanPeriod, $now, $request, $disbursementDateConvert) {
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

                $installmentDate = $disbursementDateConvert->copy()->addMonths(4);
                $totalInstallment = $loanPeriod - 4;
                for ($i = 0; $i < $totalInstallment; $i++) {
                    $monthly[] = [
                        'cash_loan_id' => $cashData->id,
                        'principal_payment' => 0,
                        'contribution_payment' => 0,
                        'installment_date' => $installmentDate->copy()->addMonths($i)->startOfMonth(),
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
        $cashLoan = CashLoan::with('members')->where('id', $id)->first();
        return view('cash-loan.edit', ['loan' => $cashLoan, 'jsonMembers' => json_encode($cashLoan->members)]);
    }

    public function detail($id)
    {
        $cashLoan = CashLoan::with(['monthly_installment'])->where('id', $id)->first();
        return view('cash-loan.detail', ['loan' => $cashLoan]);
    } 

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'market_id' => $request->input('market_id'),
            'code_dpm' => $request->input('code_dpm'),
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ];

        Validator::make($request->all(), [
            'market_id' => 'required',
            'code_dpm' => 'required',
            'name' => 'required',
            'address' => 'required',
        ])->validate();

        try {
            DB::transaction(function () use ($id, $dataUpdate, $request) {
                CashLoan::where('id', $id)->update($dataUpdate);
                CashLoanMember::where('cash_loan_id', $id)->delete();

                foreach ($request->input('peminjam-nama') as $key => $value) {
                    CashLoanMember::create([
                        'cash_loan_id' => $id,
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
            });
        } catch (\Throwable $th) {
            throw $th;
            // return redirect()->route('cash-loan.create');
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
            'status' => 'done',
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
            if ($value->cashloan->status == 0)
                $checkApplicant = false;
        }

        $gurantor = CashLoanMember::with('cashloan')
            ->where('nik', $request->gurantor_nik)
            ->orWhere('gurantor_nik', $request->gurantor_nik)
            ->get();
        foreach ($gurantor as $value) {
            if ($value->cashloan->status == 0)
                $checkGurantor = false;
        }

        if ($checkApplicant && $checkGurantor) {
            return 1;
        }

        return 0;
    }
}