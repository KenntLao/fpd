{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Employee Management - Itenerary Request')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users"></i> Itenerary Request</h1>
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
        <h3 class="card-title">Update Itenerary Request</h3>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="/hris/pages/employees/iteneraryRequests/update/{{$iteneraryRequest->id}}" enctype="multipart/form-data" id="form">
            @method('PATCH')
            @csrf
            @include('pages.employees.iteneraryRequests.form')
        </form>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="{{ URL::previous() }}"><i class="fa fa-arrow-left"></i>
            back</a>
        <button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload"></i> save employee
            record</button>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop