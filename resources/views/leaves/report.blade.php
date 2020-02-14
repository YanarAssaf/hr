@extends('layouts.master')
@section('title','Report')

@section('content')

<div class="row">
    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-success"><i class="fa fa-check"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Accepted</span>
                <span class="info-box-number">{{$leaves->where('status','Accepted')->count()}}</span>
            </div>

        </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-danger"><i class="fa fa-ban"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Rejected</span>
                <span class="info-box-number">{{$leaves->where('status','Rejected')->count()}}</span>
            </div>

        </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-warning"><i class="fa fa-cog"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">pending</span>
                <span class="info-box-number">{{$leaves->where('status','Pending')->count()}}</span>
            </div>

        </div>

    </div>

    <div class="col-md-3 col-sm-6 col-12">
        <div class="info-box">
            <span class="info-box-icon bg-info"><i class="fa fa-fw fa-balance-scale"></i></span>

            <div class="info-box-content">
                <span class="info-box-text">Balance</span>
                <span class="info-box-number">{{$user->balance->days ?? '0'}} / {{$balance / 8}}</span>
            </div>

        </div>

    </div>

</div>

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Results</h3>
                <div class="card-tools">
                    <form action="{{ action('LeavesController@report') }}" method="get" enctype="multipart/form-data">
                        <div class="input-group input-group-sm" style="width: 300px;">
                            <input type="text" name="id" class="form-control float-right" placeholder="Name">
                            <input type="text" name="mm" class="form-control float-right" placeholder="MM">
                            <div class="input-group-append">
                                <button type="submit" class="btn btn-default"><i class="fas fa-search"></i></button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>

            <div class="card-body table-responsive">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th class="text-center">Name</th>
                            <th class="text-center">Type</th>
                            <th class="text-center">Start</th>
                            <th class="text-center">End</th>
                            <th class="text-center">Duration</th>
                            <th class="text-center">Status</th>
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
                            <td class="text-center"> {{ App\User::find($leave->user_id)->name }} </td>
                            <td class="text-center">{{$leave->type}} </td>
                            @if($leave->type == 'Hour Leave')
                            <td class="text-center"> {{ $startTime->format('Y-m-d H:i:s A')  }} </td>
                            <td class="text-center"> {{ $endTime->format('H:i:s A')  }} </td>
                            <td class="text-center"> {{ $endTime->diffInHours($startTime) }} </td>
                            @else
                            <td class="text-center"> {{ $startDate->format('Y-m-d') }} </td>
                            <td class="text-center"> {{ $endDate->format('Y-m-d') }} </td>
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
                            <td class="text-center"> {{ $days }} </td>
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
                                <td class="text-center"> <span class="{!! $color !!}"> {{ $leave->status  }}</span>
                                </td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

@stop

@section('script')
    @include('layouts.datatables') 
@endsection