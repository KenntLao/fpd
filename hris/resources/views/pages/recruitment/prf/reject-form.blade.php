{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - PRF')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-columns"></i> recruitment</h1>
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
<div class="card" id="create">
    <div class="card-header">
        <h3 class="card-title">REJECT {{$employee->firstname}} {{$employee->lastname}} - PRF Request</h3>
    </div>
    <div class="card-body">
        <form class="form-horizontal" method="post" action="/hris/pages/recruitment/prf/reject-submit/{{$prf->id}}" enctype="multipart/form-data" id="form">
            @csrf
            @method('PATCH')
            <div class="row">
                <div class="col-12 col-md-6 col-xl-5">
                    <div class="form-group">
                        <label class="mr-2" for="client_approval_file">Remarks </label>
                        <span class="badge badge-danger">Required</span>
                        <input class="form-control required" type="text" name="reject_remarks" value="{{old('reject_remarks') ?? $prf->reject_remarks}}" required>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="/hris/pages/recruitment/prf/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
        <button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> submit</button>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop