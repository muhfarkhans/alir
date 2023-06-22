<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\CommunityGroup;
use App\Models\Market;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CommunityGroupController extends Controller
{
    public function index()
    {
        return view('community-group.index');
    }

    public function dataTablesCommunityGroup(Request $request)
    {
        if ($request->ajax()) {
            $data = CommunityGroup::with(['market'])->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('community-group.detail', ['id' => $row->id]) . '" class="edit btn btn-primary btn-sm">Detail</a> 
                                    <a href="' . route('community-group.edit', ['id' => $row->id]) . '" class="edit btn btn-success btn-sm">Edit</a> 
                                    <a href="' . route('community-group.delete', ['id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';
                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create()
    {
        $market = Market::get();
        return view('community-group.create', ['market' => $market]);
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'market_id' => $request->input('market_id')
        ];
        //return $dataCreate;

        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'market_id' => 'required'
        ])->validate();

        try {
            CommunityGroup::create($dataCreate);
        } catch (\Throwable $th) {
            //return $th;
            return redirect()->route('community-group.create');
        }
        return redirect()->route('community-group.index');
    }

    public function edit($id)
    {
        $communityGroup = CommunityGroup::find($id);
        $market = Market::get();
        return view('community-group.edit', ['group' => $communityGroup, 'market' => $market]);
    }

    public function detail($id)
    {
        $communityGroup = CommunityGroup::find($id);
        return view('community-group.detail', ['group' => $communityGroup]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'name' => $request->input('name'),
            'address' => $request->input('address'),
            'market_id' => $request->input('market_id'),
        ];
        //return $dataCreate;

        Validator::make($request->all(), [
            'name' => 'required',
            'address' => 'required',
            'market_id' => 'required',
        ])->validate();

        try {
            CommunityGroup::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('community-group.edit');
        }
        return redirect()->route('community-group.index');
    }

    public function delete($id)
    {
        try {
            CommunityGroup::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('community-group.index');
        }
        return redirect()->route('community-group.index');
    }
}