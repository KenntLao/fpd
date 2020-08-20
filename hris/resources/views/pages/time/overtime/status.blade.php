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
        <h3 class="card-title">overtime request - {{$overtime->employee->firstname}} {{$overtime->employee->lastname}}</h3>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="/hris/pages/time/overtime/update/{{$status}}/{{$overtime->id}}" id="form">
            @method('PATCH')
            @csrf
            <div class="row">
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="mr-2" for="type">Type: </label>
                        <span class="badge">Required</span>
                        <select class="form-control select2 required" name="type" required>
                            <option disabled default selected>--select one--</option>
                            @foreach( $types as $type )
                            <option value="{{$type->id}}">{{$type->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <div class="col-12 col-md-6">
                    <div class="form-group">
                        <label class="mr-2" for="supervisor_remarks">Supervisor Remarks: </label>
                        <span class="badge badge-danger">Required</span>
                        <div class="input">
                            <p class="placeholder">Enter supervisor remarks</p>
                            <textarea class="form-control required" name="supervisor_remarks" required>{{ old('supervisor_remarks') ?? $overtime->supervisor_remarks }}</textarea>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="/hris/pages/time/overtime/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
        <button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> @if($status == 1) Approve @endif @if($status == 2) Deny @endif  overtime request</button>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop

