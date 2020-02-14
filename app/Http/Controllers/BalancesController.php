<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\User;
use App\Balance;

class BalancesController extends Controller
{
    public function index()
    {
        $balances = Balance::all();
        return view('balances.index', compact('balances'));
    }

    public function store(Request $request)
    {
        Balance::create($request->all());
        return redirect('balances');
    }

    public function edit(Balance $balance)
    {
        $users = User::all();
        return view('balances.edit', compact('balance', 'users'));
    }

    public function update(Request $request, Balance $balance)
    {
        $users = User::whereIn('id', $request->perm)->get();
        $balance->users()->saveMany($users);
        return redirect('balances');
    }
}
