@extends('adminlte::page')
@section('title', 'HRIS | Employee Management - Itenerary Requests')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i>Itenerary Requests</h1>
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
        <h3 class="card-title">Itenerary Request</h3>
    </div>
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-12 col-sm-2">
                <div class="profile-image mb-4">
                    <img src="{{ URL::asset('assets/images/employees/employee_photos/') }}/{{$iteneraryRequest->employee->employee_photo}}">
                </div>
            </div>
            <div class="col-12 col-sm-10">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Employee number:</label>
                            <p>{{$iteneraryRequest->employee->employee_number}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Department:</label>
                            <p>{{$iteneraryRequest->employee->department->name}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Work phone:</label>
                            <p>{{$iteneraryRequest->employee->work_phone}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Employee name:</label>
                            <p>{{$iteneraryRequest->employee->firstname}} {{$iteneraryRequest->employee->lastname}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Private mail address:</label>
                            <p>{{$iteneraryRequest->employee->private_email}}</p>
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
                    <div class="col-6">
                        <div class="form-group">
                            <label>Travel Date: </label>
                            <p>{{date_format(date_create_from_format('m-d-Y h:i A', $iteneraryRequest->travel_date), 'M d, Y h:i A')}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Return Date: </label>
                            <p>{{date_format(date_create_from_format('m-d-Y h:i A', $iteneraryRequest->return_date), 'M d, Y h:i A')}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Travel From: </label>
                            <p>{{$iteneraryRequest->travel_from}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Travel To: </label>
                            <p>{{$iteneraryRequest->travel_to}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Transportation: </label>
                            <p>{{$iteneraryRequest->transportation}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Purpose: </label>
                            <p>{{$iteneraryRequest->purpose}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Currency: </label>
                            <p>{{$iteneraryRequest->currency->name}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Total Funding Proposed: </label>
                            <p>{{$iteneraryRequest->total_funding_proposed}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Notes: </label>
                            <p>
                                @if($iteneraryRequest->notes)
                                {{$iteneraryRequest->notes}}
                                @else
                                None
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Status: </label>
                            <p>
                                @if($iteneraryRequest->status == '0')
                                Pending
                                @endif
                                @if($iteneraryRequest->status == '1')
                                Approved
                                @endif
                                @if($iteneraryRequest->status == '2')
                                Denied
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Attachments: </label>
                            <p><a class="download-link" href="/hris/pages/employees/iteneraryRequests/download/1/{{$iteneraryRequest->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$iteneraryRequest->attachment_1}}</a></p>
                            <p><a class="download-link" href="/hris/pages/employees/iteneraryRequests/download/2/{{$iteneraryRequest->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$iteneraryRequest->attachment_2}}</a></p>
                            <p><a class="download-link" href="/hris/pages/employees/iteneraryRequests/download/3/{{$iteneraryRequest->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$iteneraryRequest->attachment_3}}</a></p>
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