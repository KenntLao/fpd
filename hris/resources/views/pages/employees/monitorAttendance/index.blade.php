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
    </div>
    <div class="card-body">
        @if(count($attendances) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>employee</th>
                        <th>Time In</th>
                        <th>Time Out</th>
                        <th>Actions</th>
                    </tr>
                    
                </thead>
                <tbody>

                </tbody>
            </table>
        </div>
        @else
        <h4>No data available.</h4>
        @endif()
    </div>

</div>

@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
@stop