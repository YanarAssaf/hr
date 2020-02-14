<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        DB::table('departments')->insert([
            'name' => 'ROOT',
        ]);

        DB::table('departments')->insert([
            'name' => 'HR',
        ]);

        DB::table('balances')->insert([
            'name' => '2020days14',
            'year' => '2020',
            'days' => '14',
        ]);
        
        DB::table('users')->insert([
            'name' => 'Admin',
            'email' => 'admin'.'@hr.sy',
            'password' => bcrypt('12345678'),
            'is_manager' => '1',
            'department_id' => '1',
        ]);

        DB::table('users')->insert([
            'name' => env('USER_HR_NAME'),
            'email' => env('MAIL_HR_ADDRESS'),
            'password' => bcrypt('12345678'),
            'is_manager' => '1',
            'department_id' => '2',
        ]);

        DB::table('roles')->insert([
            'name' => 'admins',
        ]);

        DB::table('roles')->insert([
            'name' => 'managers',
        ]);

        DB::table('roles')->insert([
            'name' => 'users',
        ]);

        DB::table('permissions')->insert([
            'route' => 'BalancesController@index',
        ]);

        DB::table('permissions')->insert([
            'route' => 'BalancesController@store',
        ]);

        DB::table('permissions')->insert([
            'route' => 'BalancesController@edit',
        ]);

        DB::table('permissions')->insert([
            'route' => 'BalancesController@update',
        ]);

        DB::table('permissions')->insert([
            'route' => 'DepartmentsController@index',
        ]);

        DB::table('permissions')->insert([
            'route' => 'DepartmentsController@store',
        ]);

        DB::table('permissions')->insert([
            'route' => 'LeavesController@index',
        ]);

        DB::table('permissions')->insert([
            'route' => 'LeavesController@pending',
        ]);

        DB::table('permissions')->insert([
            'route' => 'LeavesController@list',
        ]);

        DB::table('permissions')->insert([
            'route' => 'LeavesController@store',
        ]);

        DB::table('permissions')->insert([
            'route' => 'LeavesController@accept',
        ]);

        DB::table('permissions')->insert([
            'route' => 'LeavesController@reject',
        ]);

        DB::table('permissions')->insert([
            'route' => 'LeavesController@report',
        ]);

        DB::table('permissions')->insert([
            'route' => 'UsersController@index',
        ]);

        DB::table('permissions')->insert([
            'route' => 'UsersController@create',
        ]);

        DB::table('permissions')->insert([
            'route' => 'UsersController@store',
        ]);

        DB::table('permissions')->insert([
            'route' => 'UsersController@edit',
        ]);

        DB::table('permissions')->insert([
            'route' => 'UsersController@update',
        ]);

        DB::table('permissions')->insert([
            'route' => 'RolesController@store',
        ]);

        DB::table('permissions')->insert([
            'route' => 'RolesController@edit',
        ]);

        DB::table('permissions')->insert([
            'route' => 'RolesController@update',
        ]);

        $users = App\User::all();
        $permissions = App\Permission::all();
        $role = App\Role::find(1);
        $role->permissions()->sync( $permissions );
        
        $role->users()->sync($users);
        
        $balance = App\Balance::find(1);
        $balance->users()->saveMany($users);
        
    }
}
