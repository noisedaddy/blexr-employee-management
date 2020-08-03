@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">

            <div class="panel panel-default">
                <div class="panel-heading">Notifications</div>
                @role('administrator')
                <div class="panel-body">
                    {!! Form::open(['method' => 'POST', 'route' => ['admin.notification.store']]) !!}
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('content', 'Content*', ['class' => 'control-label']) !!}
                            {!! Form::text('content', old('content'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('content'))
                                <p class="help-block">
                                    {{ $errors->first('content') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('roles', 'Roles*', ['class' => 'control-label']) !!}
                            {!! Form::select('roles[]', $roles, old('roles'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('roles'))
                                <p class="help-block">
                                    {{ $errors->first('roles') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    <div class="row">
                        <div class="col-xs-12 form-group">
                            {!! Form::label('ships', 'Ships', ['class' => 'control-label']) !!}
                            {!! Form::select('ships[]', $ships, old('ships'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}
                            <p class="help-block"></p>
                            @if($errors->has('ships'))
                                <p class="help-block">
                                    {{ $errors->first('ships') }}
                                </p>
                            @endif
                        </div>
                    </div>
                    {!! Form::submit(trans('global.app_send'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
                @else
                        <div class="panel-body table-responsive">
                            <table class="table table-bordered table-striped {{ count($notifications) > 0 ? 'datatable' : '' }} dt-select">
                                <thead>
                                <tr>
                                    <th style="text-align:center;"><input type="checkbox" id="select-all" /></th>
                                    <th>Content</th>
                                    <th>Date</th>
                                    <th>By</th>

                                </tr>
                                </thead>

                                <tbody>
                                @if (count($notifications) > 0)
                                    @foreach ($notifications as $notification)
                                        <tr data-entry-id="{{ $notification->id }}">
                                            <td></td>

                                            <td>{{ $notification->content }}</td>
                                            <td>{{ $notification->created_at }}</td>
                                            <td>{{ $notification->created_by }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="9">@lang('global.app_no_entries_in_table')</td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>

                @endrole
            </div>

        </div>
    </div>
@endsection
