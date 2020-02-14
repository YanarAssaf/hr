@extends('layouts.master')
@section('title','Leaves')

@section('content')

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-check"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Accepted</span>
                <span class="info-box-number">{{$user->leaves()->accepted()->count()}}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fa fa-ban"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Rejected</span>
                <span class="info-box-number">{{$user->leaves()->rejected()->count()}}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fa fa-cog"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">pending</span>
                <span class="info-box-number">{{$user->leaves()->pending()->count()}}</span>
            </div>
        </div>
    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fa fa-fw fa-balance-scale"></i></span>
            <div class="info-box-content">
                <span class="info-box-text">Balance</span>
                <span class="info-box-number">{{Auth::user()->balance->days ?? '0'}} / {{$balance / 8}}</span>
            </div>
        </div>
    </div>

</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Leaves</h3>
                <div class="card-tools">
                    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modal-default">
                        +
                    </button>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Type</th>
                            <th>Start</th>
                            <th>End</th>
                            <th>Duration</th>
                            <th>Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($leaves as $leave)
                        <tr>
                            @php
                            $startDate = \Carbon\Carbon::parse($leave->start);
                            $endDate = \Carbon\Carbon::parse($leave->end);
                            $startTime = \Carbon\Carbon::parse($leave->start);
                            $endTime = \Carbon\Carbon::parse($leave->end);
                            @endphp
                            
                            <td> {{$leave->id}}</td>
                            <td>{{$leave->type}} </td>
                            @if($leave->type == 'Hour Leave')
                            <td> {{ $startTime->format('Y-m-d H:i:s A') }} </td>
                            <td> {{ $endTime->format('H:i:s A') }} </td>
                            <td> {{ $endTime->diffInHours($startTime) }} </td>
                            @else
                            <td> {{ $startDate->format('Y-m-d') }} </td>
                            <td> {{ $endDate->format('Y-m-d') }} </td>
                            @php
                            $days = 0;
                            $endDate->modify('+1 day');
        
                            $interval = $endDate->diff($startDate);
                            
                            // total days
                            $days = $interval->days;
                            $period = new DatePeriod($startDate, new DateInterval('P1D'), $endDate);
                            $holidays = array('2019-12-25');
                            foreach($period as $dt) {
                            $curr = $dt->format('D');

                            // substract if Saturday or Sunday
                            if ($curr == 'Sat' || $curr == 'Fri') {
                            $days--;
                            }

                            // (optional) for the updated question
                            elseif (in_array($dt->format('Y-m-d'), $holidays)) {
                            $days--;
                            }
                            }

                            
                            @endphp
                            <td> {{ $days }} </td>
                            @endif
                            @php
                            if($leave->status == 'Accepted'){
                            $color = "badge bg-success" ;
                            }elseif($leave->status == 'Rejected'){
                            $color = "badge bg-danger" ;
                            }else{
                            $color = "badge bg-warning" ;
                            }
                            @endphp
                            <td> <span class="{!! $color !!}"> {{ $leave->status  }}</span> </td>
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
                <h4 class="modal-title">New Leave</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                {!! Form::open(['action' => ['LeavesController@store'], 'method' => 'POST']) !!}
                {!! Form::label('type', 'Type') !!}
                {!! Form::select('type', ['0' => 'Paid leave', '1' => 'Hour Leave', '2' => 'Sick Leave', '3' => 'UnPaid
                leave'] , null, ['class' => 'form-control',
                'placeholder' => ' ', 'required' => 'required']) !!}
                </br>
                {!! Form::label('start', 'Start ') !!}
                <div class="input-group">
                    <div class="input-group-addon">
                    </div>
                    <input type="text" class="form-control pull-right" id="start" name="start">
                </div>
                </br>
                {!! Form::label('start', 'End ') !!}
                <div class="input-group">
                    <div class="input-group-addon">

                    </div>
                    <input type="text" class="form-control pull-right" id="end" name="end">
                </div>
                </br>
                <div class="input-group">
                    <div class="input-group-addon">
                    </div>
                    {{ Form::hidden('user_id', Auth::user()->id) }}
                </div>
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

@section('script')

<script>
    $(function() {
        $('input[name="start"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour:true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
        format: 'YYYY-MM-DD H:mm'
        }
        });
        });
</script>

<script>
    $(function() {
        $('input[name="end"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        timePicker24Hour:true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
        format: 'YYYY-MM-DD H:mm'
        }
        });
        });
</script>

@include('layouts.datatables')
@stop