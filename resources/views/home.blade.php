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
{{--                    <div class="row">--}}
{{--                        <div class="col-xs-12 form-group">--}}
{{--                            {!! Form::label('ships', 'Ships', ['class' => 'control-label']) !!}--}}
{{--                            {!! Form::select('ships[]', $ships, old('ships'), ['class' => 'form-control select2', 'multiple' => 'multiple', 'required' => '']) !!}--}}
{{--                            <p class="help-block"></p>--}}
{{--                            @if($errors->has('ships'))--}}
{{--                                <p class="help-block">--}}
{{--                                    {{ $errors->first('ships') }}--}}
{{--                                </p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    {!! Form::submit(trans('global.app_send'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}
                </div>
                @else
                        <div class="panel-body table-responsive">
                            <table id="notification-table" class="display table table-striped dt-select dataTable select" style="width:100%">
                                <thead>
                                <tr>
                                    <th>seen</th>
                                    <th>Content</th>
                                    <th>Date</th>
                                    <th>By</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
                @endrole
            </div>

        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">

            var time = 0;

            var table = $('#notification-table').DataTable( {
                ajax: "{{ route('admin.notification.reload') }}",
                        "columns": [
                            { "data": "id" },
                            { "data": "content" },
                            { "data": "created_at" },
                            { "data": "created_by" }
                        ],
                'columnDefs': [{
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta){
                        return '<input type="checkbox" name="id[]" value="' + $('<div/>').text(data).html() + '">';
                    }
                }],
                'order': [[1, 'asc']]
            } );

        setInterval(function()
        {
            time++;
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': window._token
                }
            });
            $.ajax({
                url: "{{ route('admin.notification.reload') }}",
                dataType: "json",
                beforeSend: function () {

                },
                success: function(response) {
                    table.ajax.reload( null, false );
                },
                complete: function (xhr) {
                    console.log('done');
                }
            });
        }, 3000);//time in milliseconds

            // Handle click on checkbox to set state of "Select all" control
            $('#notification-table tbody').on('change', 'input[type="checkbox"]', function(){

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': window._token
                    }
                });
                $.ajax({
                    url: "{{ route('admin.notification.seen') }}",
                    method: "POST",
                    data: { id: this.value} ,
                    beforeSend: function () {

                    },
                    success: function(response) {
                        console.log(response);
                    },
                    complete: function (xhr) {
                        console.log('end');
                    }
                });

            });


    </script>
@endsection
