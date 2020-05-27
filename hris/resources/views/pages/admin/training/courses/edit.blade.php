{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Courses')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-list-alt"></i> Training Setup</h1>
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
		<h3 class="card-title">edit course</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/training/courses/update/{{$course->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row no-gutters">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="code">Code: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter course code</p>
							<input class="form-control required" type="text" name="code" value="{{$course->code}}" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter course name</p>
							<input class="form-control required" type="text" name="name" value="{{$course->name}}" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="coordinator">Coordinator: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="coordinator" required>
							<option value="SocialConz Digital" {{ $course->coordinator == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="trainer">Trainer: </label>
						<div class="input">
							<p class="placeholder">Enter trainer name</p>
							<input class="form-control required" type="text" name="trainer" value="{{$course->trainer}}">
						</div>
					</div>
				</div>
			</div>
			<div class="row no-gutters">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="trainer_details">Trainer Details: </label>
						<div class="input">
							<p class="placeholder">Enter trainer details</p>
							<textarea class="form-control required" name="trainer_details">{{$course->trainer_details}}</textarea>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="payment_type">Payment Type: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="payment_type" required>
							<option value="Company Sponsored" {{ $course->payment_type == 'Company Sponsored'  ? 'selected' : '' }}>Company Sponsored</option>
							<option value="Paid by Employee" {{ $course->payment_type == 'Paid by Employee'  ? 'selected' : '' }}>Paid by Employee</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="currency">Currency: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="currency" required>
							<option value="Philippine Peso" {{ $course->currency == 'Philippine Peso'  ? 'selected' : '' }}>Philippine Peso</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row no-gutters">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="cost">Cost: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter cost</p>
							<input class="form-control required" type="text" name="cost" value="{{$course->cost}}" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Active" {{ $course->status == 'Active'  ? 'selected' : '' }}>Active</option>
							<option value="Inactive" {{ $course->status == 'Inactive'  ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/training/courses/index"><i class="fa fa-arrow-left"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save course</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop