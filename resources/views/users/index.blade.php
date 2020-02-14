@extends('layouts.master')
@section('title','User')

@section('content')


<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Responsive Hover Table</h3>
                <div class="card-tools">
                    <form action="{{ url('users/create') }}">
                        <input class="btn btn-primary" type="submit" value="+" />
                    </form>
                </div>

            </div>

            <div class="card-body table-responsive">
                <table id="example1" class="table table-hover">
                    <thead>
                        <tr>
                            <th>Name</th>
                            <th>Email</th>
                            <th>Department</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($users as $user)
                        <tr>
                            <td><a href="{{ url('users/'.$user->id.'/edit') }}"> {{ $user->name }}
                                </a> </td>
                            <td> {{ $user->email }} </td>
                            <td> {{ $user->department->name }} </td>
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