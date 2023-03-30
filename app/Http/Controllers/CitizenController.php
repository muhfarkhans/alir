<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Citizen;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CitizenController extends Controller
{
    public function index() {
        return view('citizen.index');
    }

    public function dataTablesCitizen(Request $request) {
        if ($request->ajax()) {
            $data = Citizen::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('citizen.edit', ['id' => $row->id]).'" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="'.route('citizen.delete', ['id' => $row->id]).'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create() {
        return view('citizen.create');
    }

    public function store(Request $request) {
        $dataCreate = [
            'nik' => $request->input('nik'),
            'fullname' => $request->input('fullname'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'role' => $request->input('role')
        ];
        //return $dataCreate;

        Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16|unique:citizens,nik',
            'fullname' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'role' => 'required',
        ])->validate();

        try {
            Citizen::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('citizen.create');
        }
        return redirect()->route('citizen.index');
    }

    public function edit($id) {
        $citizen = Citizen::find($id);
        return view('citizen.edit', ['citizen' => $citizen]);
    }

    public function update(Request $request, $id) {
        $dataUpdate = [
            'nik' => $request->input('nik'),
            'fullname' => $request->input('fullname'),
            'address' => $request->input('address'),
            'phone' => $request->input('phone'),
            'role' => $request->input('role')
        ];
        //return $dataCreate;

        Validator::make($request->all(), [
            'nik' => 'required|numeric|digits:16|unique:citizens,nik,'.$id.',id',
            'fullname' => 'required',
            'address' => 'required',
            'phone' => 'required|numeric',
            'role' => 'required',
        ])->validate();

        try {
            Citizen::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('citizen.edit');
        }
        return redirect()->route('citizen.index');
    }

    public function delete($id) {
        try {
            Citizen::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('citizen.index');
        }
        return redirect()->route('citizen.index');
    }
}
