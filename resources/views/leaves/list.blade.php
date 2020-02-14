@extends('layouts.master')
@section('title','List')
@section('content')

<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">List</h3>
                
            </div>

            <div class="card-body table-responsive">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
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
                            <td> {{ App\User::find($leave->user_id)->name }} </td>
                            <td>{{$leave->type}} </td>
                            @if($leave->type == 'Hour Leave')
                            <td> {{ $startTime->format('Y-m-d H:i:s')  }} </td>
                            <td> {{ $endTime->format('H:i:s')  }} </td>
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
                                <td> <span class="{!! $color !!}"> {{ $leave->status  }}</span>
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
<script>
    $(function() {
        $('input[name="start"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
        format: 'YYYY-MM-DD hh:mm A'
        }
        });
        });
</script>

<script>
    $(function() {
        $('input[name="end"]').daterangepicker({
        singleDatePicker: true,
        timePicker: true,
        startDate: moment().startOf('hour'),
        endDate: moment().startOf('hour').add(32, 'hour'),
        locale: {
        format: 'YYYY-MM-DD hh:mm A'
        }
        });
        });
</script>
@include('layouts.datatables')
@endsection