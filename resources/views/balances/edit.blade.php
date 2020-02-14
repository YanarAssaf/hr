@extends('layouts.master')
@section('title','Update Balance')

@section('content')

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">{{$balance->name}}</h3>
    </div>

    {!! Form::open(['action' => ['BalancesController@update', $balance->id], 'method' => 'POST']) !!}
    @csrf
    <div class="card-body">

        <div class="form-group row">
            @foreach($users as $user)
            <div class="col-sm-3">
                <label class="checkbox-inline " for="perm[{{ $user->id }}]">
                    <input id="perm[{{ $user->id }}]" name="perm[{{ $user->id }}]" type="checkbox"
                        value="{{ $user->id }}" @if($balance->users->contains($user->id)) checked=checked @endif
                    > {{ $user->name }}
                </label>
            </div>
            @endforeach
        </div>

    </div>

    <div class="card-footer">
        {!! Form::hidden('_method', 'PUT' ) !!}
        <button type="submit" class="btn btn-info">Update</button>
        <button type="submit" class="btn btn-default float-right">Cancel</button>
    </div>

    </form>
</div>

@endsection