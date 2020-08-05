@extends('layouts.app')
<style>
    img {
        border: 1px solid #ddd; /* Gray border */
        border-radius: 4px;  /* Rounded border */
        padding: 5px; /* Some padding */
        width: 150px; /* Set a small width */
    }

    /* Add a hover effect (blue shadow) */
    img:hover {
        box-shadow: 0 0 2px 1px rgba(0, 140, 186, 0.5);
    }
</style>
@section('content')
    <h3 class="page-title">@lang('global.app_ships')</h3>
    {!! Form::open(['method' => 'POST', 'route' => ['admin.ships.store'], 'files'=>'true']) !!}

    <div class="panel panel-default">
        <div class="panel-heading">
            @lang('global.app_create')
        </div>
        
        <div class="panel-body">
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('name', 'Name*', ['class' => 'control-label']) !!}
                    {!! Form::text('name', old('name'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('name'))
                        <p class="help-block">
                            {{ $errors->first('name') }}
                        </p>
                    @endif
                </div>
            </div>
            <div class="row">
                <div class="col-xs-6 form-group">
                    <a target="_blank" href="#">
                        <img src="{{ asset('adminlte/img/default-50x50.gif') }}" alt="Forest" style="width:150px">
                    </a>
                </div>
                <div class="col-xs-6 form-group">
                    {!! Form::label('file', 'image*', ['class' => 'control-label']) !!}
                    {!! Form::file('file') !!}
                </div>
            </div>
            <div class="row">
                <div class="col-xs-12 form-group">
                    {!! Form::label('users', 'users*', ['class' => 'control-label']) !!}
                    {!! Form::select('users[]', $users, old('users'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
                    <p class="help-block"></p>
                    @if($errors->has('users'))
                        <p class="help-block">
                            {{ $errors->first('users') }}
                        </p>
                    @endif
                </div>
            </div>
        </div>
    </div>

    {!! Form::submit(trans('global.app_save'), ['class' => 'btn btn-danger']) !!}
    {!! Form::close() !!}
@stop

