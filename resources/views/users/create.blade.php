@extends('layouts.master')
@section('title','Create User')

@section('content')

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">New User</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    <form method="POST" action="{{ route('users.store') }}" class="form-horizontal">
        @csrf
        <div class="card-body">
            <div class="form-group row">
                <label for="Name" class="col-sm-2 control-label">Name</label>
                <div class="col-sm-10">
                    <input type="text" class="form-control" name="name" value="{{ old('name') }}" placeholder="Name"
                        required autocomplete="name" autofocus>
                </div>
            </div>
            <div class="form-group row">
                <label for="inputEmail3" class="col-sm-2 control-label">Email</label>
                <div class="col-sm-10">
                    <input type="email" class="form-control" name="email" value="{{ old('email') }}" placeholder="Email"
                        required autocomplete="email">
                </div>
            </div>
            <div class="form-group row">
                <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
                <div class="col-sm-10">
                    <input id="password" type="password" class="form-control" name="password" required
                        autocomplete="new-password">
                </div>
            </div>
            <div class="form-group row">
                <label for="Department" class="col-sm-2 control-label">Department</label>
                <div class="col-sm-10">
                    @php
                    $departments=App\Department::pluck('name', 'id');
                    @endphp
                    {!! Form::select('department_id', $departments , null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <label for="Balance" class="col-sm-2 control-label">Balance</label>
                <div class="col-sm-10">
                    @php
                    $balances=App\Balance::pluck('name', 'id');
                    @endphp
                    {!! Form::select('balance_id', $balances , null, ['class' => 'form-control']) !!}
                </div>
            </div>
            <div class="form-group row">
                <div class="col-sm-offset-2 col-sm-10">
                    <div class="form-check">
                        {{Form::hidden('is_manager',0)}}
                        {{ Form::checkbox('is_manager' , "1", null, ['class' => 'form-check-input']   ) }}
                        <label class="form-check-label" for="exampleCheck2">Is Manager</label>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-body -->
        <div class="card-footer">
            <button type="submit" class="btn btn-info">Create</button>
        </div>
        <!-- /.card-footer -->
    </form>
</div>





@endsection