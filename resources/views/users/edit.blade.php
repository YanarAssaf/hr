@extends('layouts.master')
@section('title','Update User')

@section('content')

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">Update User</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::open(['action' => ['UsersController@update', $user->id], 'method' => 'PUT', 'class'=> 'form-horizontal'])
    !!}
    @csrf
    <div class="card-body">
        <div class="form-group row">
            <label for="Name" class="col-sm-2 control-label">Name</label>
            <div class="col-sm-10">
                <input type="text" class="form-control" name="name" value="{{ $user->name }}" placeholder="Name"
                    required autocomplete="name" autofocus>
            </div>
        </div>
        <div class="form-group row">
            <label for="inputPassword3" class="col-sm-2 control-label">Password</label>
            <div class="col-sm-10">
                <input id="password" type="password" class="form-control" name="password" 
                    autocomplete="new-password">
            </div>
        </div>
        <div class="form-group row">
            <label for="Department" class="col-sm-2 control-label">Balance</label>
            <div class="col-sm-10">
                @php
                $departments=App\Department::pluck('name', 'id');
                @endphp
                {!! Form::select('department_id', $departments , $user->department_id, ['class' => 'form-control']) !!}
            </div>
        </div>
        <div class="form-group row">
            <label for="Balance" class="col-sm-2 control-label">Balance</label>
            <div class="col-sm-10">
                @php
                $balances=App\Balance::pluck('name', 'id');
                @endphp
                {!! Form::select('balance_id', $balances , $user->balance_id , ['class' => 'form-control','placeholder'
                =>
                'Please select ...']) !!}
            </div>
        </div>
        <div class="form-group row">
            <div class="col-sm-offset-2 col-sm-10">
                <div class="form-check">
                    {{Form::hidden('is_manager',0)}}
                    {{ Form::checkbox('is_manager' , "1" , $user->is_manager=="1"?true:false, ['class' => 'form-check-input'] ) }}
                    <label class="form-check-label" for="exampleCheck2">Is Manager</label>
                </div>
            </div>
        </div>
    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        <button type="submit" class="btn btn-info">Update</button>
        <button type="submit" class="btn btn-default float-right">Cancel</button>
    </div>
    <!-- /.card-footer -->
    </form>
</div>





@endsection