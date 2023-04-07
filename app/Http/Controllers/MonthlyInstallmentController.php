<?php

namespace App\Http\Controllers;

use App\Models\MonthlyInstallment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use DataTables;

class MonthlyInstallmentController extends Controller
{
    public function dataTablesMonthly(Request $request, $id)
    {
        if ($request->ajax()) {
            $data = MonthlyInstallment::with(['cash_loan'])->where('cash_loan_id', $id)->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<button type="button" class="edit btn btn-success btn-sm" onclick="setFormData(' . $row->id . ')">Edit</button>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
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
            MonthlyInstallment::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return false;
        }

        return true;
    }
}