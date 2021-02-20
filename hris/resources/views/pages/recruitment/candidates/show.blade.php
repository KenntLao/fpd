@extends('adminlte::page')
@section('title', 'HRIS | Employees - Employee')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-user"></i> Candidate Profile</h1>
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
<div class="card mb-5">
    <div class="card-header">
        <h3 class="card-title">Profile</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-3">
                <label>Name</label>
                <p>{{$candidate->careers_app_fname}} {{$candidate->careers_app_lname}}</p>
            </div>
            <div class="col-md-3">
                <label>Email</label>
                <p>{{$candidate->careers_app_email}}</p>
            </div>
            <div class="col-md-3">
                <label>Contact No.</label>
                <p>{{$candidate->careers_app_number}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Gender</label>
                <p>{{$candidate->careers_app_gender}}</p>
            </div>
            <div class="col-md-3">
                <label>Position</label>
                <p>{{$candidate->careers_app_position}}</p>
            </div>
            <div class="col-md-3">
                <label>Date Applied</label>
                <p>{{$candidate->date_apply}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Nationality</label>
                <p>{{$candidate->nationality}}</p>
            </div>
            <div class="col-md-3">
                <label>Marital Status</label>
                <p>{{$candidate->careers_app_marital}}</p>
            </div>

        </div>
        <div class="row mb-2">
            <h4>Professional Experience</h4>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Company</label>
                <p>{{$candidate->careers_app_company_name}}</p>
            </div>
            <div class="col-md-3">
                <label>Position Title</label>
                <p>{{$candidate->careers_app_company_position_title}}</p>
            </div>
            <div class="col-md-3">
                <label>Position Level</label>
                <p>{{$candidate->careers_app_position_level}}</p>
            </div>

        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Industry</label>
                <p>{{$candidate->careers_app_industry}}</p>
            </div>
            <div class="col-md-3">
                <label>Start Date</label>
                <p>{{$candidate->careers_app_company_date_from}}</p>
            </div>
            <div class="col-md-3">
                <label>End Date</label>
                <p>{{$candidate->careers_app_company_date_to}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Position Description</label>
                <p>{{$candidate->careers_app_position_desc}}</p>
            </div>
        </div>
        <div class="row mb-2">
            <h4>Educational Background</h4>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>University / Institute</label>
                <p>{{$candidate->careers_app_university}}</p>
            </div>
            <div class="col-md-3">
                <label>Major</label>
                <p>{{$candidate->careers_app_major}}</p>
            </div>
            <div class="col-md-3">
                <label>Qualification</label>
                <p>{{$candidate->careers_app_qualification}}</p>
            </div>
        </div>
        <div class="row">
            <div class="col-md-3">
                <label>Field of Study</label>
                <p>{{$candidate->careers_app_field}}</p>
            </div>
            <div class="col-md-3">
                <label>Start Date</label>
                <p>{{$candidate->careers_app_study_date_from}}</p>
            </div>
            <div class="col-md-3">
                <label>End Date</label>
                <p>{{$candidate->careers_app_study_date_to}}</p>
            </div>
        </div>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="/hris/pages/recruitment/candidates/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
    </div>
</div>

<div class="card">
    <div class="card-header">
        <h3 class="card-title">Candidate Logs</h3>
    </div>
    <div class="card-body">
        @foreach($candidate_log as $log)
        <div class="row">
            <div class="col-md-12">
                @if($log->date_type == "status")
                    @if(isset($log->hr->firstname))
                        <p>
                            <span class="badge-pill badge-primary">{{$log->hr->firstname}} {{$log->hr->lastname}}</span> changed the candidate status to
                            @if($log->status_val != NULL )
                                @if($log->status_val == 0)
                                <span class="badge-pill badge-dark">Pending</span>
                                @elseif($log->status_val == 1)
                                <span class="badge-pill badge-dark">Initial Interview</span>
                                @elseif($log->status_val == 2)
                                <span class="badge-pill badge-dark">Manager Interview</span>
                                @elseif($log->status_val == 3)
                                <span class="badge-pill badge-dark">Client Interview</span>
                                @elseif($log->status_val == 4)
                                <span class="badge-pill badge-dark">Pre-Employment</span>
                                @elseif($log->status_val == 5)
                                <span class="badge-pill badge-dark">Employment Request</span>
                                @elseif($log->status_val == 6)
                                <span class="badge-pill badge-dark">Failed</span>
                                @elseif($log->status_val == 7)
                                <span class="badge-pill badge-dark">Employed</span>
                                @endif
                            @endif
                            on <span class="badge-pill badge-success">{{$log->created_at}}</span>
                        </p>
                    @endif
                @elseif($log->date_type == "assign")
                    @if(isset($log->hr->firstname) && isset($log->manager->firstname))
                        <p>
                            <span class="badge-pill badge-primary">{{$log->hr->firstname}} {{$log->hr->lastname}}</span> assigned the candidate to
                            <span class="badge-pill badge-warning">{{$log->manager->firstname}} {{$log->manager->lastname}}</span>
                            on <span class="badge-pill badge-success">{{$log->created_at}}</span>
                        </p>
                    @endif
                @elseif($log->date_type == "result")
                    <p>
                        <span class="badge-pill badge-warning">{{$log->manager->firstname}} {{$log->manager->lastname}}</span> Interview Result: 
                        @if($log->candidate->manager_result != NULL )
                                @if($log->candidate->manager_result == 0)
                                <span class="badge-pill badge-dark">Pending</span>
                                @elseif($log->candidate->manager_result == 1)
                                <span class="badge-pill badge-dark">Qualified</span>
                                @else
                                <span class="badge-pill badge-dark">Not Qualified</span>
                                @endif
                        @endif
                        on <span class="badge-pill badge-success">{{$log->created_at}}</span>
                    </p>
                @endif
            </div>
        </div>
        @endforeach
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="/hris/pages/recruitment/candidates/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
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