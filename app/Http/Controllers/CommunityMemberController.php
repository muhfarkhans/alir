<?php

namespace App\Http\Controllers;

use App\Models\CommunityGroup;
use Illuminate\Http\Request;
use App\Models\CommunityMember;
use Illuminate\Support\Facades\Validator;
use DataTables;

class CommunityMemberController extends Controller
{
    public function dataTablesCommunityMember(Request $request, $community_id)
    {
        if ($request->ajax()) {
            $data = CommunityMember::with(['citizen', 'gurantor_citizen'])->where('community_group_id', $community_id)->latest()->get();
            return Datatables::of($data)
                ->addIndexColumn()
                ->addColumn('action', function ($row) {
                    $actionBtn = '<a href="' . route('community-group.member.edit', ['community_id' => $row->community_group_id, 'id' => $row->id]) . '" class="delete btn btn-success btn-sm">Edit</a>
                                <a href="' . route('community-group.member.delete', ['community_id' => $row->community_group_id, 'id' => $row->id]) . '" class="delete btn btn-danger btn-sm">Delete</a>';

                    return $actionBtn;
                })
                ->rawColumns(['action'])
                ->make(true);
        }
    }

    public function create($community_id)
    {
        return view('community-group.member.create', ['community_id' => $community_id]);
    }

    public function store(Request $request, $community_id)
    {
        $dataCreate = [
            'community_group_id' => $community_id,
            'citizen_id' => $request->input('citizen_id'),
            'gurantor_citizen_id' => $request->input('gurantor_citizen_id'),
            'role' => $request->input('role'),
        ];

        if ($dataCreate['citizen_id'] == $dataCreate['gurantor_citizen_id']) {
            return back()->withErrors([
                'error' => 'Data penerima tidak boleh sama dengan data penjamin',
            ]);
        }

        Validator::make($request->all(), [
            'citizen_id' => 'required',
            'gurantor_citizen_id' => 'required',
            'role' => 'required',
        ])->validate();

        $checkCitizen = CommunityMember::where('citizen_id', $dataCreate['citizen_id'])->orWhere('gurantor_citizen_id', $dataCreate['citizen_id'])->first();
        $checkGuarantor = CommunityMember::where('citizen_id', $dataCreate['gurantor_citizen_id'])->orWhere('gurantor_citizen_id', $dataCreate['gurantor_citizen_id'])->first();

        if ($checkCitizen || $checkGuarantor) {
            return back()->withErrors([
                'error' => 'Data anggota sudah digunakan',
            ]);
        }

        try {
            CommunityMember::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('community-group.member.create', ['community_id' => $community_id]);
        }
        return redirect()->route('community-group.detail', ['id' => $community_id]);
    }

    public function edit($community_id, $id)
    {
        $member = CommunityMember::with(['citizen', 'gurantor_citizen'])->where('id', $id)->first();
        return view('community-group.member.edit', ['member' => $member]);
    }

    public function update(Request $request, $community_id, $id)
    {
        $dataUpdate = [
            'community_group_id' => $community_id,
            'citizen_id' => $request->input('citizen_id'),
            'gurantor_citizen_id' => $request->input('gurantor_citizen_id'),
            'role' => $request->input('role'),
        ];

        if ($dataUpdate['citizen_id'] == $dataUpdate['gurantor_citizen_id']) {
            return back()->withErrors([
                'error' => 'Data penerima tidak boleh sama dengan data penjamin',
            ]);
        }

        Validator::make($request->all(), [
            'citizen_id' => 'required',
            'gurantor_citizen_id' => 'required',
            'role' => 'required',
        ])->validate();

        $checkCitizen = CommunityMember::where('citizen_id', $dataUpdate['citizen_id'])->orWhere('gurantor_citizen_id', $dataUpdate['citizen_id'])->first();
        $checkGuarantor = CommunityMember::where('citizen_id', $dataUpdate['gurantor_citizen_id'])->orWhere('gurantor_citizen_id', $dataUpdate['gurantor_citizen_id'])->first();

        if ($checkCitizen) {
            if ($checkCitizen->community_group_id != $community_id) {
                return back()->withErrors([
                    'error' => 'Data anggota sudah digunakan',
                ]);
            }
        }

        if ($checkGuarantor) {
            if ($checkGuarantor->community_group_id != $community_id) {
                return back()->withErrors([
                    'error' => 'Data anggota sudah digunakan',
                ]);
            }
        }

        try {
            CommunityMember::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            return redirect()->route('community-group.member.edit', ['community_id' => $community_id, 'id' => $id]);
        }
        return redirect()->route('community-group.detail', ['id' => $community_id]);
    }

    public function delete($community_id, $id)
    {
        try {
            CommunityMember::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('community-group.detail', ['id' => $community_id]);
        }
        return redirect()->route('community-group.detail', ['id' => $community_id]);
    }
}