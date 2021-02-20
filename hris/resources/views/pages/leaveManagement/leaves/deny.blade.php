@extends('adminlte::page')
@section('title', 'HRIS | Leave Management - Deny Leave Application')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i> Leaves</h1>
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
        <h3 class="card-title">{{$employee->firstname .' '. $employee->lastname}} Leave Request</h3>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="/hris/pages/leaveManagement/leaves/{{$leaves->id}}/denySubmit" id="form">
            @method('PATCH')
            @csrf
            <div class="row">
                <input type="hidden" value="{{$employee->id}}" placeholder="" name="employee_id" readonly>
                <input type="hidden" value="{{$supervisor_id}}" name="supervisor_id">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2" for="start_date">Leave Type</label>
                        <select class="form-control select2" name="leave_type">
                            <option value="{{$leave_type_id}}" selected>{{$leave_name->name}}</option>
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2" for="half_day">Half-Day</label>
                        <span class="badge badge-danger">Required</span>
                        <select class="form-control half_day required" name="half_day" readonly>
                            <option default value="{{$half_day}}">No</option>
                        </select>
                    </div>
                </div>
                @if($half_day == 0)
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2" for="start_date">Start Date: </label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <input class="form-control required leave_date" type="text" name="start_date" value="{{date("Y-m-d", strtotime($start_date))}}" required readonly>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2" for="end_date">End Date: </label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <input class="form-control required leave_date" type="text" name="end_date" value="{{date("Y-m-d", strtotime($end_date))}}" required readonly>
                        </div>
                    </div>
                </div>
                @else
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2" for="end_date">Date: </label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <input class="form-control required leave_date" type="text" name="short_date" value="{{date("Y-m-d", strtotime($short_date))}}" required readonly>
                        </div>
                    </div>
                </div>
                @endif

            </div>
            <div class="row">
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2" for="end_date">Reason</label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <textarea class="form-control required" name="reason" required readonly>{{$reason}}</textarea>
                        </div>
                    </div>
                </div>
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2" for="end_date">Supervisor Remarks</label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <textarea class="form-control required" name="remarks" required></textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="/hris/pages/leaveManagement/leaves/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
        <button class="btn btn-danger" type="submit" form="form"><i class="fa fa-times mr-1"></i> deny</button>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop