<?php
Auth::routes();

//Route::view('about','about');
Route::get('/', 'LeavesController@index');
Route::get('pending', 'LeavesController@pending');
Route::get('list', 'LeavesController@list');
Route::get('leaves/report', 'LeavesController@report');
Route::get('leaves/{leave}/accept', 'LeavesController@accept');
Route::get('leaves/{leave}/reject', 'LeavesController@reject');
Route::resource('leaves', 'LeavesController');
Route::resource('users', 'UsersController');
Route::resource('departments', 'DepartmentsController');
Route::resource('balances', 'BalancesController');
Route::resource('roles', 'RolesController');