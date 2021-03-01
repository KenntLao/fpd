@extends('adminlte::page')
@section('title', 'HRIS | Monitor Attendance')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Monitor Attendance</h1>
    </div>
</div>
@stop
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <p><i class="fas fa-fw fa-check-circle"></i>{{ $message }}</p>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <p><i class="fas fa-fw fa-exclamation-circle"></i>{{$errors->first()}}</p>
</div>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Monitor Attendance</h3>
        @if($hr_officer)
        <div class="card-tools">
            <button class="btn add-button btn-md" data-toggle="modal" data-target="#export-modal"><i class="far fa-file-excel mr-1"></i> Export</button>
        </div>
        @endif
    </div>
    <div class="card-body">
        @if(!empty($attendances))
        <!--<div class="row">
            <div class="col-md-8"></div>
            <div class="col-md-4">
                <div class="search-bar mb-3">
                    <input class="form-control" type="text" placeholder="Search">
                </div>
            </div>
        </div> -->
        <div class="table-responsive">

            <table class="table table-hover table-bordered table-striped table-condensed table-data">
                <thead>
                    <tr>
                        <th>employee</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>

                </thead>
                <tbody>
                    @foreach($attendances as $attendance)
                    <tr>
                        <td>
                            @if($attendance->id)
                            <a href="/hris/pages/employees/monitorAttendance/show/{{$attendance->id}}">{{$attendance->firstname.' '.$attendance->lastname}}</a>
                            @else
                            {{$attendance->firstname.' '.$attendance->lastname}}
                            @endif
                        </td>
                        <td>
                            @if($attendance->time_in)
                            {{date("Y-m-d h:i:s", $attendance->time_in)}}
                            @else
                            --
                            @endif

                        </td>
                        <td>
                            @if($attendance->time_out)
                            {{date("Y-m-d h:i:s", $attendance->time_out)}}
                            @else
                            --
                            @endif
                        </td>
                        <td>
                            @if($attendance->status == 1)
                            <span class="badge badge-success p-1">Clocked in</span>
                            @else
                            <span class="badge badge-secondary p-1">Clocked out</span>
                            @endif
                        </td>
                        <td><a class="show-snap btn btn-warning btn-xs" data-name="{{$attendance->firstname.' '.$attendance->lastname}}" data-time-in-snap="{{$attendance->time_in_photo}}" data-time-out-snap="{{$attendance->time_out_photo}}" data-toggle="modal" data-target="#snapshotModal-{{$attendance->id}}" title="Show Snapshots"><i class="fa fa-eye" aria-hidden="true"></i></a></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        <div id="snapshotModal" class="snap-modal modal fade" role="dialog">
            <div class="modal-dialog">

                <!-- Modal content-->
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="white snap-owner-name"></h5>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-md-6">
                                <img class="time-in-snap" src="">
                                <p>Time in Snapshot</p>
                            </div>
                            <div class="col-md-6">
                                <img class="time-out-snap" src="">
                                <p>Time out Snapshot</p>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                    </div>
                </div>

            </div>
        </div>
        @else
        <h4>No data available.</h4>
        @endif
    </div>
</div>
<div class="modal fade" id="export-modal" tabindex="-1" role="dialog" aria-labelledby="export-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="export-label">Download Excel File</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="/hris/pages/employees/monitorAttendance/download" id="form">
                @csrf
                    <div class="form-group">
                        <label for="date_from">Date from: </label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <input type="date" name="date_from" class="form-control required" required>
                        </div>
                    </div>
                    <div class="form-group">
                        <label for="date_to">Date To: </label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <input type="date" name="date_to" class="form-control required" required>
                        </div>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-success" type="submit" form="form"><i class="far fa-file-excel mr-1"></i> Download Excel File</button>
            </div>
        </div>
    </div>
</div>

@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
    $(function() {
        $('.table-data').DataTable({
            "paging": true,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
        });
    });
    $('.show-snap').on("click", function() {
        var emp_name = $(this).attr("data-name");
        var time_in_snap = $(this).attr("data-time-in-snap");
        var time_out_snap = $(this).attr("data-time-out-snap");
        var data_target = $(this).attr("data-target");
        var modal_id = data_target.replace('#', '');
        $('.snap-modal').attr("id", modal_id);
        $('.snap-owner-name').text(emp_name + "'s attendance details");
        $('.time-in-snap').attr("src", "{{asset('assets/images/employees/employee_time_in/')}}/" + time_in_snap);
        if (time_in_snap) {
            $('.time-in-snap').attr("src", "{{asset('assets/images/employees/employee_time_in/')}}/" + time_in_snap);
        } else {
            $('.time-in-snap').attr("src", "{{asset('assets/images/default.jpg')}}");
        }
        if (time_out_snap) {
            $('.time-out-snap').attr("src", "{{asset('assets/images/employees/employee_time_out/')}}/" + time_out_snap);
        } else {
            $('.time-out-snap').attr("src", "{{asset('assets/images/default.jpg')}}");
        }
    });
</script>

@stop