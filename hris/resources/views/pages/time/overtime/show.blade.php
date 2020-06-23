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
    <div class="card-header">
        <h3 class="card-title">overtime request</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-3 col-sm-2">
                <div class="profile-image">
                    <img src="{{ URL::asset('assets/images/employees/employee_photos/') }}/{{$overtime->employee->employee_photo}}">
                </div>
            </div>
            <div class="col-6 col-sm-10">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Employee number:</label>
                            <p class="form-data">{{$overtime->employee->employee_number}}</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Employee name:</label>
                            <p class="form-data">{{$overtime->employee->firstname}} {{$overtime->employee->lastname}}</p>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <label class="form-label">Work phone:</label>
                            <p class="form-data">{{$overtime->employee->work_phone}}</p>
                        </div>
                        <div class="form-group">
                            <label class="form-label">Private mail address:</label>
                            <p class="form-data">{{$overtime->employee->private_email}}</p>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-12">
                <div class="form-group">
                    <h3 style="width: 100%;">Overtime information</h3>
                </div>
            </div>
        </div> <div class="row">
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="created_at">Request date and time: </label>
                <p class="form-data">{{date("M d, Y - h:i:sa", strtotime($overtime->created_at))}}</p>
            </div>
        </div>
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="ot_date">Overtime Date: </label>
                <p class="form-data">{{date_format(date_create_from_format('m-d-Y', $overtime->ot_date), 'M d, Y')}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="ot_date">Approved by: </label>
                <p class="form-data">{{$user}}</p>
            </div>
        </div>
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="ot_date">Approved Date and Time: </label>
                <p class="form-data">{{date("M d, Y - h:i:sa", strtotime($overtime->approved_date))}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="ot_time_in">Overtime Time In: </label>
                <p class="form-data">{{$overtime->ot_time_in}}</p>
            </div>
        </div>
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="ot_time_out">Overtime Time out: </label>
                <p class="form-data">{{$overtime->ot_time_out}}</p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="type">Type: </label>
                <p class="form-data">{{$overtime->type}}</p>
            </div>
        </div>
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="status">Status: </label>
                <p class="form-data">
                    @if($overtime->status == '1')
                    Approved
                    @else
                    Rejected
                    @endif
                </p>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="ot_time_in">Employee remarks: </label>
                <p class="form-data">{{$overtime->employee_remarks}}</p>
            </div>
        </div>
        <div class="col-6 col-sm-6">
            <div class="form-group">
                <label class="form-label mr-2" for="ot_time_in">Supervisor remarks: </label>
                <p class="form-data">{{$overtime->supervisor_remarks}}</p>
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