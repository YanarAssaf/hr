<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Response;
use App\User;
use App\Permission;

class HasPermission
{
    public function handle($request, Closure $next)
    {
        $user_id = auth()->user()->id;
        $user = User::find($user_id);
        $action = app('request')->route()->getAction();
        $controller = class_basename($action['controller']);
        $roles = $user->roles;
        $has=false;
        foreach ($roles as $role) {
            $permissions = $role->permissions;
            foreach ($permissions as $permission) {
                if ($permission->route == $controller) {
                    $has = true;
                }
            }
        }
        if ($has != true) {
            return new Response(view('unauthorized'));
        }

        return $next($request);
    }
}
