{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Pay Grades')
@section('content_header')
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
		<h3 class="card-title">add pay grade</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/jobDetails/payGrades" id="form">
			@csrf
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="name">Pay Grade Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="name" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="currency">Currency</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="currency" required>
							<option value="Philippine Peso">Philippine Peso</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="min_salary">Min Salary</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="min_salary" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="max_salary">Max Salary</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="max_salary" required>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/jobDetails/payGrades/index"><i class="fa fa-arrow-left mr-1"></i> Back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save pay grade</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
$(document).ready(function() {
$('.select2').select2();
});
</script>
@stop