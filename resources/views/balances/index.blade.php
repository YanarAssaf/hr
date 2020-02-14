@extends('layouts.master')
@section('title','Balances')

@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Balances</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                        +
                    </button>
                </div>

            </div>

            <div class="card-body table-responsive p-0">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Year</th>
                            <th>Days</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($balances as $balance)
                        <tr>
                            <td><a href="{{ url('balances/'.$balance->id.'/edit') }}"> {{ $balance->name }}
                                </a> </td>
                            <td> {{ $balance->year }} </td>
                            <td> {{ $balance->days }} </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>


<div class="modal fade" id="modal-default">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title">New Balance</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['action' => ['BalancesController@store'], 'method' => 'POST']) !!}
                {!! Form::text('name', null, ['class' => 'form-control', 'placeholder' => ' Name', 'required' =>
                'required']) !!}</br>
                {!! Form::text('year', null, ['class' => 'form-control', 'placeholder' => ' Year', 'required' =>
                'required']) !!}</br>
                {!! Form::text('days', null, ['class' => 'form-control', 'placeholder' => 'Days', 'required' =>
                'required']) !!}
            </div>
            <div class="modal-footer justify-content-between">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary">Save changes</button>
                {!! Form::close() !!}
            </div>
        </div>
    </div>
</div>
@stop