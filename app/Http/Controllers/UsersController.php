<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\User;
use App\Role;
use Carbon\Carbon;

class UsersController extends Controller
{
    public function index()
    {
        $users = User::all();
        return view('users.index', compact('users'));
    }

    public function create()
    {
        return view('users.create');
    }

    public function store(Request $request)
    {
        $request->merge(['password' => Hash::make($request->password)]);
        $user = User::create($request->all());
        if ($request->is_manager == '0') {
            $role = Role::find(3);
        } else {
            $role = Role::find(2);
        }
        $user->roles()->sync($role);
        return redirect('/users');
    }

    public function edit(User $user)
    {
        return view('users.edit', compact('user'));
    }

    public function update(Request $request, User $user)
    {
        if (!$request->password) {
            $request->merge(['password' => $user->password]);
            $input = $request->all();
            $user->fill($input)->save();
            if ($request->input('is_manager') == '0') {
                $role = Role::find(3);
            } else {
                $role = Role::find(2);
            }
        } else {
            $request->merge(['password' => Hash::make($request->password)]);
            $input = $request->all();
            $user->fill($input)->save();
            if ($request->input('is_manager') == '0') {
                $role = Role::find(3);
            } else {
                $role = Role::find(2);
            }
        }
        $user->roles()->sync($role);
        return redirect('/users');
    }
}
