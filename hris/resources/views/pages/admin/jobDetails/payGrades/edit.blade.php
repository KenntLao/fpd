{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Pay Grades')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-columns"></i> Job Details Setup</h1>
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
		<h3 class="card-title">edit pay grade</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/jobDetails/payGrades/update/{{$payGrade->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="name">Pay Grade Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter pay grade</p>
							<input class="form-control required" type="text" name="name" value="{{$payGrade->name}}" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="currency">Currency: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="currency" required>
							<option value="Philippine Peso" selected>Philippine Peso</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="min_salary">Min Salary: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter minimum salary</p>
							<input class="form-control required" type="text" name="min_salary" value="{{$payGrade->min_salary}}" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="max_salary">Max Salary: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter maximum salary</p>
							<input class="form-control required" type="text" name="max_salary" value="{{$payGrade->max_salary}}" required>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/jobDetails/payGrades/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save pay grade</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop