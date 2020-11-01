@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-md-10">
            @role('employee')
            <div class="panel panel-default">
                <div class="panel-heading">Work From Home Requests</div>
                <div class="panel-body">


                    {!! Form::open(['method' => 'POST', 'route' => ['admin.notification.store']]) !!}
{{--                    <div class="row">--}}
{{--                        <div class="col-xs-12 form-group">--}}
{{--                            {!! Form::label('content', 'Content*', ['class' => 'control-label']) !!}--}}
{{--                            {!! Form::text('content', old('content'), ['class' => 'form-control', 'placeholder' => '', 'required' => '']) !!}--}}
{{--                            <p class="help-block"></p>--}}
{{--                            @if($errors->has('content'))--}}
{{--                                <p class="help-block">--}}
{{--                                    {{ $errors->first('content') }}--}}
{{--                                </p>--}}
{{--                            @endif--}}
{{--                        </div>--}}
{{--                    </div>--}}
                    <div class="row">
                        <div class='col-md-5'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker6'>
                                    <input type='text' class="form-control" id="start_timedate" name="start_timedate" placeholder="Start date/time"/>
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                        <div class='col-md-5'>
                            <div class="form-group">
                                <div class='input-group date' id='datetimepicker7'>
                                    <input type='text' class="form-control" id="end_timedate" name="end_timedate" placeholder="End date/time"/>
                                    <span class="input-group-addon">
                                    <span class="glyphicon glyphicon-calendar"></span>
                                    </span>
                                </div>
                            </div>
                        </div>
                    </div>

                    {!! Form::submit(trans('global.app_send'), ['class' => 'btn btn-primary']) !!}
                    {!! Form::close() !!}

                </div>
                @endrole
                        <div class="panel-body table-responsive">
                            <table id="notification-table" class="display table table-striped dt-select dataTable select" style="width:100%">
                                <thead>
                                <tr>
                                    <th>Action</th>
                                    <th>Content</th>
                                    <th>Date Created</th>
                                    <th>By</th>
                                    <th>Request Status</th>
                                    <th>Cancel Request</th>

                                </tr>
                                </thead>
                            </table>
                        </div>
            </div>

        </div>
    </div>
@stop

@section('javascript')
    <script type="text/javascript">

        $(function () {
            $('#datetimepicker6').datetimepicker();
            $('#datetimepicker7').datetimepicker({
                useCurrent: false //Important! See issue #1075
            });
            $("#datetimepicker6").on("dp.change", function (e) {
                $('#datetimepicker7').data("DateTimePicker").minDate(e.date);
            });
            $("#datetimepicker7").on("dp.change", function (e) {
                $('#datetimepicker6').data("DateTimePicker").maxDate(e.date);
            });

            console.log();
        });

            var role = {!! json_encode($role) !!};

            var time = 0;

            var table = $('#notification-table').DataTable( {
                ajax: "{{ route('admin.notification.reload') }}",
                        "columns": [
                            { "data": "id" , "bVisible": role == 'administrator' ? true : false },
                            { "data": "content" },
                            { "data": "created_at" },
                            { "data": "created_by" },
                            { "data": "status" },
                            { "data": "id", "bVisible": role == 'administrator' ? false : true }
                        ],
                'columnDefs': [
                    {
                    'targets': 0,
                    'searchable': false,
                    'orderable': false,
                    'className': 'dt-body-center',
                    'render': function (data, type, full, meta){
                            if (full.status != 'cancel') {
                                return '<button id="accepted_'+$('<div/>').text(data).html()+'" name="accepted" onclick="actionRequest(this)" class="btn btn-xs btn-info">Accept</button>' +
                                    '<button id="rejected_'+$('<div/>').text(data).html()+'" name="rejected" onclick="actionRequest(this)" class="btn btn-xs btn-danger' +
                                    '">Reject</button>';
                            } else {
                                return '';
                            }
                        }
                    },
                    {
                        'targets': 5,
                        'searchable': false,
                        'orderable': false,
                        'className': 'dt-body-center',
                        'render': function (data, type, full, meta){
                            return '<button id="cancel_'+$('<div/>').text(data).html()+'" name="cancel" onclick="actionRequest(this)" class="btn btn-xs btn-danger">Cancel</button>';
                        }
                    }
                ],
                'order': [[1, 'asc']]
            } );

            // set interval for reloading datatable source
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

                }
            });
        }, 3000);//time in milliseconds

            /**
             * Change request status field in Notification table. Used in button onclick event
             * @param data
             */
            function actionRequest(data) {

                var rowID = data.id;
                rowID = rowID.match(/\d+/)[0];
                var requestStatus = data.name;

                $.ajaxSetup({
                    headers: {
                        'X-CSRF-TOKEN': window._token
                    }
                });
                $.ajax({
                    url: "{{ route('admin.notification.status') }}",
                    method: "POST",
                    data: { id: rowID, status: requestStatus} ,
                    beforeSend: function () {

                    },
                    success: function(response) {
                        console.log(response);
                    },
                    complete: function (xhr) {

                    }
                });

            }

    </script>
@endsection
