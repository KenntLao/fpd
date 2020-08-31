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
    @if ($employeeTrainingSession->status == 0)
    <div class="card-header">
        <h3 class="card-title">Training Session - Scheduled</h3>
    </div>
    @endif
    @if ($employeeTrainingSession->status == 1)
    <div class="card-header" style="background: #28a745">
        <h3 class="card-title">Training Session - Attended</h3>
    </div>
    @endif
    @if ($employeeTrainingSession->status == 2)
    <div class="card-header" style="background: #dc3545">
        <h3 class="card-title">Training Session - Not Attended</h3>
    </div>
    @endif
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-3 col-sm-2">
                <div class="profile-image">
                    <img src="{{ URL::asset('assets/images/employees/employee_photos/') }}/{{$employeeTrainingSession->employee->employee_photo}}">
                </div>
            </div>
            <div class="col-9 col-sm-10">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Employee number:</label>
                            <p>{{$employeeTrainingSession->employee->employee_number}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Department:</label>
                            <p>
                                @if($employeeTrainingSession->employee->department_id)
                                {{$employeeTrainingSession->employee->department->name}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Work phone:</label>
                            <p>{{$employeeTrainingSession->employee->work_phone}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Employee name:</label>
                            <p>{{$employeeTrainingSession->employee->firstname}} {{$employeeTrainingSession->employee->lastname}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Private mail address:</label>
                            <p>{{$employeeTrainingSession->employee->private_email}}</p>
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
                            <label class="mr-2" for="training_session_id">Training Session: </label>
                            <p>{{$employeeTrainingSession->training_session->name}}</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="course">Course: </label>
                            <p>{{$employeeTrainingSession->training_session->course->name}} {{$employeeTrainingSession->training_session->course->code}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="training_session_id">Scheduled Time: </label>
                            <p>{{$employeeTrainingSession->training_session->scheduled_time}}</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="training_session_id">Coordinator: </label>
                            <p>{{$employeeTrainingSession->training_session->course->coordinator->firstname}} {{$employeeTrainingSession->training_session->course->coordinator->lastname}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="training_session_id">Proof of Completion: </label>
                            @if($employeeTrainingSession->proof)
                            <p><a class="download-link" href="/hris/pages/training/myTraining/download/{{$employeeTrainingSession->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$employeeTrainingSession->proof}}</a></p>
                            @endif
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



