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
        @if(\Request::route()->getName() == 'editStatus')
        <form class="form-horizontal" method="post" action="/hris/pages/time/overtime/update/{{$status}}/{{$overtime->id}}" id="form">
        @else
        <form class="form-horizontal" method="post" action="/hris/pages/time/overtime/update/{{$overtime->id}}" id="form">
        @endif
            @method('PATCH')
            @include('pages.time.overtime.form')
        </form>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="/hris/pages/time/overtime/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
        <button class="btn btn-success" type="submit" form="form"  {{ $overtime->status == '1' ? 'disabled' : '' ?? $overtime->status == '2' ? 'disabled' : '' }} ><i class="fa fa-upload mr-1"></i> save overtime request</button>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>

@stop