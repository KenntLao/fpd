@extends('adminlte::page')
@section('title', 'HRIS | Time Management - Overtime')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i> Overtime</h1>
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
    @if ($overtime->status == 0)
    <div class="card-header">
        <h3 class="card-title">overtime request - pending</h3>
    </div>
    @endif
    @if ($overtime->status == 1)
    <div class="card-header" style="background: #28a745">
        <h3 class="card-title">overtime request - approved</h3>
    </div>
    @endif
    @if ($overtime->status == 2)
    <div class="card-header" style="background: #dc3545">
        <h3 class="card-title">overtime request - denied</h3>
    </div>
    @endif
    <div class="card-body">
        <div class="row mb-4">
            <div class="col-3 col-sm-2">
                <div class="profile-image">
                    <img src="{{ URL::asset('assets/images/employees/employee_photos/') }}/{{$overtime->employee->employee_photo}}">
                </div>
            </div>
            <div class="col-9 col-sm-10">
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Employee number:</label>
                            <p>{{$overtime->employee->employee_number}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Department:</label>
                            <p>{{$overtime->employee->department->name}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Work phone:</label>
                            <p>{{$overtime->employee->work_phone}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-4">
                        <div class="form-group">
                            <label>Employee name:</label>
                            <p>{{$overtime->employee->firstname}} {{$overtime->employee->lastname}}</p>
                        </div>
                    </div>
                    <div class="col-4">
                        <div class="form-group">
                            <label>Private mail address:</label>
                            <p>{{$overtime->employee->private_email}}</p>
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
                            <label class="mr-2" for="created_at">Date and Time: </label>
                            <p>{{date("M d, Y - h:i:sa", strtotime($overtime->created_at))}}</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="type">Type: </label>
                            <p>
                                @if($overtime->overtime_type_id)
                                {{$overtime->overtime_type->name}}
                                @else
                                ---
                                @endif
                            </p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="overtime_category_id">Category: </label>
                            <p>{{$overtime->overtime_category->name}}</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="ot_date">Approved by: </label>
                            <p>{{$user}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="ot_date">Approved Date and Time: </label>
                            <p>{{date("M d, Y - h:i:sa", strtotime($overtime->approved_date))}}</p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="ot_date">Overtime Request Date and Time: </label>
                            <p>{{date('M d, Y', strtotime($overtime->ot_date)).' '.substr($overtime->ot_time_in, 0, 2) . ':' . substr($overtime->ot_time_in, 2).' - '.substr($overtime->ot_time_out, 0, 2) . ':' . substr($overtime->ot_time_out, 2)}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="status">Status: </label>
                            <p>
                                @if($overtime->status == '0')
                                Pending
                                @endif
                                @if($overtime->status == '1')
                                Approved
                                @endif
                                @if($overtime->status == '2')
                                Denied
                                @endif
                            </p>
                        </div>
                    </div>
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="ot_time_in">Employee remarks: </label>
                            <p>{{$overtime->employee_remarks}}</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-6 col-sm-6">
                        <div class="form-group">
                            <label class="mr-2" for="ot_time_in">Supervisor remarks: </label>
                            <p>{{$overtime->supervisor_remarks}}</p>
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
