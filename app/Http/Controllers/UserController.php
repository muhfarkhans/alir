<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('user.index', ['users' => $users]);
    }

    public function create()
    {
        return view('user.create');
    }

    public function store(Request $request)
    {
        $dataCreate = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
            'password' => Hash::make($request->input('password'))
        ];

        Validator::make($request->all(), [
            'name' => 'required',
            'email' => 'required',
            'password' => 'required',
        ])->validate();

        try {
            User::create($dataCreate);
        } catch (\Throwable $th) {
            return redirect()->route('user.create');
        }

        return redirect()->route('user.index');
    }

    public function edit($id)
    {
        $user = User::find($id);
        return view('user.edit', ['user' => $user]);
    }

    public function update(Request $request, $id)
    {
        $dataUpdate = [
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ];

        $validationRule = [
            'name' => 'required',
            'email' => 'unique:users,email,' . $id,
        ];

        if (strlen($request->input('password')) < 8 && strlen($request->input('password')) != 0) {
            $validationRule = array_merge($validationRule, ['password' => 'min:8']);

        }
        Validator::make($request->all(), $validationRule)->validate();

        try {
            if ($request->input('password') != null) {
                $dataUpdate['password'] = Hash::make($request->input('password'));
            }

            User::where('id', $id)->update($dataUpdate);
        } catch (\Throwable $th) {
            throw $th;
        }

        return redirect()->route('user.edit', $id);
    }

    public function delete($id)
    {
        try {
            User::where('id', $id)->delete();
        } catch (\Throwable $th) {
            return redirect()->route('user.index');
        }

        return redirect()->route('user.index');
    }
}