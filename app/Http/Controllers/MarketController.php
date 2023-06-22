<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Market;
use Illuminate\Support\Facades\Validator;
use DataTables;

class MarketController extends Controller
{
    public function index()
    {
        return view('market.index');
    }

    public function dataTablesMarket(Request $request)
    {
        if ($request->ajax()) {
            $data = Market::latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('market.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                  <a href="' . route('market.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        return view('market.create');
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
        ];
        // return $dataCreate;

        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
        ])->validate();

        try {
            Market::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('market.create');
        }
        return redirect()->route('market.index');
    }

    public function edit($id)
    {
        $market = Market::find($id);
        return view('market.edit', ['market' => $market]);
    }

    public function update(Request $request, $id)
    {
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
            Market::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('market.edit');
        }
        return redirect()->route('market.index');
    }

    public function delete($id)
    {
        try {
            Market::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('market.index');
        }
        return redirect()->route('market.index');
    }
}
