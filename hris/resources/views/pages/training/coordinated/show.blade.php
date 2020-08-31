@extends('adminlte::page')
@section('title', 'HRIS | Training Management - My Training Session')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i> Training Management</h1>
    </div>
</div>
@stop
@section('content')
@if (count($errors))
<div class="alert alert-danger">
    <strong>Whoops!</strong> There were some problems with your input.
    <ul>
        @foreach ($errors->all() as $error)
        <li>{{ $error }}</li>
        @endforeach
    </ul>
</div>
@endif
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Training Session</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-3 col-sm-2">
                <div class="profile-image">
                    <img src="{{ URL::asset('assets/images/employees/employee_photos') }}/{{$employee->employee_photo}}">
                </div>
            </div>
            <div class="col-9 col-sm-10">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Employee number:</label>
                            <p>{{$employee->employee_number}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Department:</label>
                            <p>
                                @if($employee->department_id)
                                {{$employee->department->name}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Work phone:</label>
                            <p>
                                @if($employee->work_phone)
                                {{$employee->work_phone}}
                                @else
                                ----
                                @endif</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Employee name:</label>
                            <p>{{$employee->firstname}} {{$employee->lastname}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Private email address:</label>
                            <p>{{$employee->private_email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row no-gutters section">
            <div class="col-12 section-title">
                <h5>information</h5>
            </div>
            <div class="col-12 section-info">
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Training Session</label>
                            <p>{{$employeeTrainingSession->name}}</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Course</label>
                            <p>
                                @if($employeeTrainingSession->course)
                                {{$employeeTrainingSession->course->name}} {{$employeeTrainingSession->course->code}}
                                @else
                                ERROR
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Scheduled Time</label>
                            <p>
                                @if($employeeTrainingSession->scheduled_time)
                                {{$employeeTrainingSession->scheduled_time}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Assignment Due Date</label>
                            <p>
                                @if($employeeTrainingSession->assignment_due_date)
                                {{$employeeTrainingSession->assignment_due_date}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Delivery Method</label>
                            <p>
                                @if($employeeTrainingSession->delivery_method)
                                {{$employeeTrainingSession->delivery_method}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Delivery Location</label>
                            <p>
                                @if($employeeTrainingSession->delivery_location)
                                {{$employeeTrainingSession->delivery_location}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Attendance Type</label>
                            <p>
                                @if($employeeTrainingSession->attendance_type)
                                {{$employeeTrainingSession->attendance_type}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Attachment</label>
                            <p>
                            @if($employeeTrainingSession->attachment)
                            <a class="download-link" href="/hris/pages/training/coordinated/download/{{$employeeTrainingSession->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$employeeTrainingSession->attachment}}</a>
                            @else
                            ----
                            @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label>Training Certificate Required</label>
                            <p>{{$employeeTrainingSession->attendance_type}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="{{URL::previous()}}"><i class="fa fa-arrow-left mr-1"></i> back</a>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop



