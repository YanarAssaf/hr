<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Role;
use App\User;
use App\Permission;

class RolesController extends Controller
{
    public function edit(Role $role)
    {
        $users = User::all();
        $permissions = Permission::all();
        return view('roles.edit', compact('role', 'users', 'permissions'));
    }

    public function update(Request $request, $id)
    {
        if (!$request->input('perm')) {
            $users_perm = [];
        } else {
            $users_perm = $request->perm;
        }

        if (!$request->input('perm1')) {
            $permissions_perm = [];
        } else {
            $permissions_perm = $request->perm1;
        }
      
        $role = Role::find($id);
        $users = User::whereIn('id', $users_perm)->get();
        $permissions = Permission::whereIn('id', $permissions_perm)->get();

        if (!empty($users)) {
            $role->users()->sync($users);
        } else {
            $role->users()->detach();
        }

        if (!empty($permissions)) {
            $role->permissions()->sync($permissions);
        } else {
            $role->permissions()->detach();
        }
    }
}
