<?php

namespace App\Exports;

use App\Models\CashLoan;
use App\Models\CashLoanMember;
use App\Models\MonthlyInstallment;
use Carbon\Carbon;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;

class ReportExport implements FromView
{
    public function view(): View
    {
        //$data = CashLoan::with('monthly_installment', 'members')->get();
        $cashLoan = CashLoan::all();
        $getDisbursementDate = CashLoan::select('disbursement_date', 'due_date')
        ->groupBy('disbursement_date', 'due_date')
        ->get();


        $response = [];
        $resultData =[];
        foreach($getDisbursementDate as $key => $data) {
            $resultData[$data->disbursement_date] = [
                'disbursement_date' => $data->disbursement_date,
                'due_date' => $data->due_date,
                'data' => []
            ];
        }

        foreach($cashLoan as $key => $data) {
            $getKetua = CashLoanMember::select('name')
                        ->where('cash_loan_id', $data->id)
                        ->where('position', 'ketua')
                        ->first();

            $dataRow = [
                'kode_dpm' => $data->code_dpm,
                'nama' => $data->name,
                'alamat' => $data->address,
                'ketua' => $getKetua->name,
                'pinj_pokok' => $data->total_loan,
                'pinj_kontr' => $data->contribution,
                'pinj_jml' => $data->total_loan + $data->contribution,
                'keterangan' => '--'
            ];

            //get angsuran bulanan
            if($data->loan_period == 12) {
                $dataRow['angs_pokok'] = $data->total_loan/8;
                $dataRow['angs_kontr'] = $data->contribution/8;
                $dataRow['angs_jml'] = ($data->total_loan + $data->contribution)/8;
            } elseif ($data->loan_period == 24) {
                $dataRow['angs_pokok'] = $data->total_loan/20;
                $dataRow['angs_kontr'] = $data->contribution/20;
                $dataRow['angs_jml'] = ($data->total_loan + $data->contribution)/20;
            } elseif ($data->loan_period == 36) {
                $dataRow['angs_pokok'] = $data->total_loan/32;
                $dataRow['angs_kontr'] = $data->contribution/32;
                $dataRow['angs_jml'] = ($data->total_loan + $data->contribution)/32;
            }
        
            //count data pengembalian sd bulan lalu
            $dataRow['kmb_sd_bln_lalu_pokok'] = 0;
            $dataRow['kmb_sd_bln_lalu_kontr'] = 0;

            $lastMonthData = MonthlyInstallment::where('cash_loan_id', $data->id)->get();
            foreach($lastMonthData as $lastMonth) {
                $dataRow['kmb_sd_bln_lalu_pokok'] += $lastMonth->principal_payment;
                $dataRow['kmb_sd_bln_lalu_pokok'] += $lastMonth->contribution_payment;
                $dataRow['kmb_sd_bln_lalu_jml'] = $dataRow['kmb_sd_bln_lalu_pokok'] + $dataRow['kmb_sd_bln_lalu_pokok'];
            }

            //count data pengembalian bulan ini
            $currentDate = Carbon::now();
            $onlyMonth = $currentDate->format('m');
            $onlyYear = $currentDate->format('Y');
            $currentMonthData = MonthlyInstallment::whereMonth('installment_date', '=', $onlyMonth)
                                ->whereYear('installment_date', '=', $onlyYear)
                                ->first();
                                
            $dataRow['kmb_bln_ini_pokok'] = $currentMonthData->principal_payment;
            $dataRow['kmb_bln_ini_kontr'] = $currentMonthData->contribution_payment;
            $dataRow['kmb_bln_ini_jml'] = $currentMonthData->principal_payment + $currentMonthData->contribution_payment;

            //count data pengembalian sd bulan ini
            $dataRow['kmb_sd_bln_ini_pokok'] = 0;
            $dataRow['kmb_sd_bln_ini_kontr'] = 0;

            $totalCurrentMonthData = MonthlyInstallment::whereMonth('installment_date', '<=', $onlyMonth)
                                    ->whereYear('installment_date', '<=', $onlyYear)
                                    ->get();
            foreach($totalCurrentMonthData as $totalCurrent) {
                $dataRow['kmb_sd_bln_ini_pokok'] += $totalCurrent->principal_payment;
                $dataRow['kmb_sd_bln_ini_kontr'] += $totalCurrent->contribution_payment;
                $dataRow['kmb_sd_bln_ini_jml'] = $dataRow['kmb_sd_bln_ini_pokok'] + $dataRow['kmb_sd_bln_ini_kontr'];
            }

            //count target pengembalian
            $dataRow['target_kmb_pokok'] = 0;
            $dataRow['target_kmb_kontr'] = 0;
            $dataRow['target_kmb_jml'] = 0;

            //count tunggakan
            $dataRow['tunggakan_pokok'] = 0;
            $dataRow['tunggakan_kontr'] = 0;
            $dataRow['tunggakan_jml'] = 0;

            //count sisa pinjaman
            $dataRow['sisa_pinj_pokok'] = 0;
            $dataRow['sisa_pinj_kontr'] = 0;
            $dataRow['sisa_pinj_jml'] = 0;
            
            $resultData[$data->disbursement_date]['data'][] = $dataRow;
        }
        
        $result = [];
        foreach($resultData as $item) {
            $result[] = $item;
        }

        //return $result;
        
        return view ('excel.report', compact('result'));
    }
}
