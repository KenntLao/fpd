@extends('adminlte::page')
@section('title', 'HRIS | Work Shift Management')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Work Shift Management</h1>
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
        <h3 class="card-title">Work Shift List</h3>
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/time/workshiftManagement/create"><i class="fa fa-plus mr-1"></i> Create Work Shift</a>
        </div>
    </div>
    <div class="card-body">
        @if(count($work_shift) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($work_shift as $shift)
                    @php
                    $monday_time_in = date('G:i A',$shift->monday_time_in);
                    $monday_time_out = date('G:i A',$shift->monday_time_out);
                    $tuesday_time_in = date('G:i A',$shift->tuesday_time_in);
                    $tuesday_time_out = date('G:i A',$shift->tuesday_time_out);
                    $wednesday_time_in = date('G:i A',$shift->wednesday_time_in);
                    $wednesday_time_out = date('G:i A',$shift->wednesday_time_out);
                    $thursday_time_in = date('G:i A',$shift->thursday_time_in);
                    $thursday_time_out = date('G:i A',$shift->thursday_time_out);
                    $friday_time_in = date('G:i A',$shift->friday_time_in);
                    $friday_time_out = date('G:i A',$shift->friday_time_out);
                    $saturday_time_in = date('G:i A',$shift->saturday_time_in);
                    $saturday_time_out = date('G:i A',$shift->saturday_time_out);
                    $sunday_time_in = date('G:i A',$shift->sunday_time_in);
                    $sunday_time_out = date('G:i A',$shift->sunday_time_out);

                    if($monday_time_in == '0:00 AM' && $monday_time_out == '0:00 AM' ) {
                    $monday_time_in = '-';
                    $monday_time_out = '-';
                    }
                    if($tuesday_time_in == '0:00 AM' && $tuesday_time_out == '0:00 AM' ) {
                    $tuesday_time_in = '-';
                    $tuesday_time_out = '-';
                    }
                    if($wednesday_time_in == '0:00 AM' && $wednesday_time_out == '0:00 AM' ) {
                    $wednesday_time_in = '-';
                    $wednesday_time_out = '-';
                    }
                    if($thursday_time_in == '0:00 AM' && $thursday_time_out == '0:00 AM' ) {
                    $thursday_time_in = '-';
                    $thursday_time_out = '-';
                    }
                    if($friday_time_in == '0:00 AM' && $friday_time_out == '0:00 AM' ) {
                    $friday_time_in = '-';
                    $friday_time_out = '-';
                    }
                    if($saturday_time_in == '0:00 AM' && $saturday_time_out == '0:00 AM' ) {
                    $saturday_time_in = '-';
                    $saturday_time_out = '-';
                    }
                    if($sunday_time_in == '0:00 AM' && $sunday_time_out == '0:00 AM' ) {
                    $sunday_time_in = '-';
                    $sunday_time_out = '-';
                    }

                    @endphp
                    <tr>
                        <td>{{$shift->workshift_name}}</td>
                        <td>{{$monday_time_in}} - {{$monday_time_out}}</td>
                        <td>{{$tuesday_time_in}} - {{$tuesday_time_out}}</td>
                        <td>{{$wednesday_time_in}} - {{$wednesday_time_out}}</td>
                        <td>{{$thursday_time_in}} - {{$thursday_time_out}}</td>
                        <td>{{$friday_time_in}} - {{$friday_time_out}}</td>
                        <td>{{$saturday_time_in}} - {{$saturday_time_out}}</td>
                        <td>{{$sunday_time_in}} - {{$sunday_time_out}}</td>
                        <td></td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h4>No data available.</h4>
        @endif()
    </div>
    <div class="card-footer">
        {{$work_shift->links()}}
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
    console.log('Hi!');
</script>
@stop