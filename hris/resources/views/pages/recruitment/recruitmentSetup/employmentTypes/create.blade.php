{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment Setup - Employment Types')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-random"></i> recruitment setup</h1>
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
		<h3 class="card-title">add employment type</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/recruitmentSetup/employmentTypes" id="form">
			@include('pages.recruitment.recruitmentSetup.employmentTypes.form')
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/recruitmentSetup/employmentTypes/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save employment type</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop