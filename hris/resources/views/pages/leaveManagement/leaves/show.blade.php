@extends('adminlte::page')
@section('title', 'HRIS | Time Management - Leave Management')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i> Leave</h1>
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
        <h3 class="card-title">
            leave request
            @if(isset($leaves->employee->firstname))
            - {{$leaves->employee->firstname}} {{$leaves->employee->lastname}}
            @endif
        </h3>
        <div class="card-tools">
            @if($leaves->status == 0)
            <span class="badge-warning p-1">Pending</span>
            @elseif($leaves->status == 1)
            <span class="badge-success p-1">Approved</span>
            @else
            <span class="badge-danger p-1">Denied</span>
            @endif
        </div>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="start_date">Leave Type</label>
                    <p>
                        @if(isset($leaves->leave_types->name))
                        {{$leaves->leave_types->name}}
                        @else
                        ---
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="start_date">Start Date: </label>
                    <p>
                        {{date("Y-m-d", strtotime($leaves->leave_start_date))}}
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="end_date">End Date: </label>
                    <p>
                        {{date("Y-m-d", strtotime($leaves->leave_end_date))}}
                    </p>
                </div>
            </div>

        </div>
        <div class="row">
            <div class="col-12 col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="end_date">Reason</label>
                    <p>
                        {{$leaves->reason}}
                    </p>
                </div>
            </div>
            @if($leaves->approved_by_id != NULL)
                @if(isset($leaves->supervisor->firstname))
                <div class="col-12 col-md-4">
                    <div class="form-group">
                        <label class="mr-2">Approved By</label>
                        <p>
                            {{$leaves->supervisor->firstname}} {{$leaves->supervisor->lastname}}
                        </p>
                    </div>
                </div>
                @endif
            @endif
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