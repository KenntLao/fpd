@extends('adminlte::page')
@section('title', 'HRIS | Employee Management - Itinerary Requests')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i>Itinerary Requests</h1>
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
    @if ($itineraryRequest->status == 0)
    <div class="card-header">
        <h3 class="card-title">itinerary request - pending</h3>
    </div>
    @endif
    @if ($itineraryRequest->status == 1)
    <div class="card-header" style="background: #28a745">
        <h3 class="card-title">itinerary request - approved</h3>
    </div>
    @endif
    @if ($itineraryRequest->status == 2)
    <div class="card-header" style="background: #dc3545">
        <h3 class="card-title">itinerary request - denied</h3>
    </div>
    @endif
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-12 col-sm-2">
                <div class="profile-image mb-4">
                    <img src="{{ URL::asset('assets/images/employees/employee_photos/') }}/{{$itineraryRequest->employee->employee_photo}}">
                </div>
            </div>
            <div class="col-12 col-sm-10">
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Employee number:</label>
                            <p>{{$itineraryRequest->employee->employee_number}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Department:</label>
                            <p>{{$itineraryRequest->employee->department->name}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Work phone:</label>
                            <p>{{$itineraryRequest->employee->work_phone}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Employee name:</label>
                            <p>{{$itineraryRequest->employee->firstname}} {{$itineraryRequest->employee->lastname}}</p>
                        </div>
                    </div>
                    <div class="col-12 col-sm-4">
                        <div class="form-group">
                            <label>Private mail address:</label>
                            <p>{{$itineraryRequest->employee->private_email}}</p>
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
                            <p>{{date('M d, Y H:i A', strtotime($itineraryRequest->travel_date))}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Return Date: </label>
                            <p>{{date('M d, Y H:i A', strtotime($itineraryRequest->return_date))}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Travel From: </label>
                            <p>{{$itineraryRequest->travel_from}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Travel To: </label>
                            <p>{{$itineraryRequest->travel_to}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Transportation: </label>
                            <p>{{$itineraryRequest->transportation}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Purpose: </label>
                            <p>{{$itineraryRequest->purpose}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Currency: </label>
                            <p>{{$itineraryRequest->currency->name}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label>Total Funding Proposed: </label>
                            <p>{{$itineraryRequest->total_funding_proposed}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label>Notes: </label>
                            <p>
                                @if($itineraryRequest->notes)
                                {{$itineraryRequest->notes}}
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
                                @if($itineraryRequest->status == '0')
                                Pending
                                @endif
                                @if($itineraryRequest->status == '1')
                                Approved
                                @endif
                                @if($itineraryRequest->status == '2')
                                Denied
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="ot_date">Approved by: </label>
                            <p>{{$user}}</p>
                        </div>
                    </div>
                @if($itineraryRequest->attachment_1 != NULL ?? $itineraryRequest->attachment_2 != NULL ?? $itineraryRequest->attachment_3 != NULL)
                    <div class="col-6">
                        <div class="form-group">
                            <label>Attachments: </label>
                            @if($itineraryRequest->attachment_1)
                            <p><a class="download-link" href="/hris/pages/employees/itineraryRequests/download/1/{{$itineraryRequest->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$itineraryRequest->attachment_1}}</a></p>
                            @endif
                            @if($itineraryRequest->attachment_2)
                            <p><a class="download-link" href="/hris/pages/employees/itineraryRequests/download/2/{{$itineraryRequest->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$itineraryRequest->attachment_2}}</a></p>
                            @endif
                            @if($itineraryRequest->attachment_3)
                            <p><a class="download-link" href="/hris/pages/employees/itineraryRequests/download/3/{{$itineraryRequest->id}}" title="Download attachment"><i class="fas fa-cloud-download-alt mr-2"></i>{{$itineraryRequest->attachment_3}}</a></p>
                            @endif
                        </div>
                    </div>
                @endif
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