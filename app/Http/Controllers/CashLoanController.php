<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CashLoan;
use App\Models\CommunityGroup;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CashLoanController extends Controller
{
    public function index() {
        return view('cash-loan.index');
    }

    public function dataTablesCashLoan(Request $request) {
        if ($request->ajax()) {
            $data = CashLoan::with(['community_group'])->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('loan-period', function ($row) {
                    $period = $row->loan_period . ' bulan';
                    return $period;
                })
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('cash-loan.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
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
        
        $contribution = 3/100 * $request->input('total_loan');
        $dataCreate['contribution'] = $contribution;
        $totalLoan = $request->input('total_loan') + $contribution;
        $dataCreate['remaining_fund'] = $totalLoan;
        $dataCreate['monthly_payment'] = $totalLoan / $request->input('loan_period');

        try {
            CashLoan::Insert($dataCreate);
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
        
        $contribution = 3/100 * $request->input('total_loan');
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
