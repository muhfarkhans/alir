<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ComunityGroup;
use Illuminate\Support\Facades\Validator;
use DataTables;

class ComunityGroupController extends Controller
{
    public function index() {
        return view('comunity-group.index');
    }

    public function dataTablesComunityGroup(Request $request) {
        if ($request->ajax()) {
            $data = ComunityGroup::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function($row){
                    $actionBtn = '<a href="'.route('comunity-group.edit', ['id' => $row->id]).'" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="'.route('comunity-group.delete', ['id' => $row->id]).'" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create() {
        return view('comunity-group.create');
    }

    public function store(Request $request) {
        $dataCreate = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ];
        //return $dataCreate;

        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ])->validate();

        try {
            ComunityGroup::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('comunity-group.create');
        }
        return redirect()->route('comunity-group.index');
    }

    public function edit($id) {
        $comunityGroup = ComunityGroup::find($id);
        return view('comunity-group.edit', ['group' => $comunityGroup]);
    }

    public function update(Request $request, $id) {
        $dataUpdate = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ];
        //return $dataCreate;

        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ])->validate();

        try {
            ComunityGroup::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('comunity-group.edit');
        }
        return redirect()->route('comunity-group.index');
    }

    public function delete($id) {
        try {
            ComunityGroup::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('comunity-group.index');
        }
        return redirect()->route('comunity-group.index');
    }
}
