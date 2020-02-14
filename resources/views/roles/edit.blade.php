@extends('layouts.master')

@section('content')

<div class="card card-info">
    <div class="card-header">
        <h3 class="card-title">{{$role->name}}</h3>
    </div>
    <!-- /.card-header -->
    <!-- form start -->
    {!! Form::open(['action' => ['RolesController@update', $role->id], 'method' => 'POST']) !!}
    @csrf
    <div class="card-body">

        <div class="form-group row">
            @foreach($users as $user)
            <div class="col-sm-3">
                <label class="checkbox-inline " for="perm[{{ $user->id }}]">
                    <input class="" id="perm[{{ $user->id }}]" name="perm[{{ $user->id }}]" type="checkbox"
                        value="{{ $user->id }}" @if($role->users->contains($user->id)) checked=checked @endif
                    > {{ $user->name }}
                </label>
            </div>
            @endforeach
        </div>

        <div class="form-group row">
            @foreach($permissions as $permission)
            <div class="col-sm-3">
                <label class="checkbox-inline " for="perm1[{{ $permission->id }}]">
                    <input id="perm1[{{ $permission->id }}]" name="perm1[{{ $permission->id }}]" type="checkbox"
                        value="{{ $permission->id }}" @if($role->permissions->contains($permission->id))
                    checked=checked @endif
                    > {{ $permission->route }}
                </label>
            </div>
            @endforeach
        </div>


    </div>
    <!-- /.card-body -->
    <div class="card-footer">
        {!! Form::hidden('_method', 'PUT' ) !!}
        <button type="submit" class="btn btn-info">Update</button>
    </div>
    <!-- /.card-footer -->
    </form>
</div>


@endsection