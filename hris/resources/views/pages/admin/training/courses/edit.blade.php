{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Courses')
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
		<h3 class="card-title">edit course</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/training/courses/update/{{$course->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row no-gutters">
				<div class="col-3">
					<div class="form-group">
						<label for="code">Code</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="code" value="{{$course->code}}" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="name">Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="name" value="{{$course->name}}" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="coordinator">Coordinator</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="coordinator" required>
							<option value="SocialConz Digital" {{ $course->coordinator == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="trainer">Trainer: </label>
						<input class="form-control" type="text" name="trainer" value="{{$course->trainer}}">
					</div>
				</div>
			</div>
			<div class="row no-gutters">
				<div class="col-6">
					<div class="form-group">
						<label for="trainer_details">Trainer Details: </label>
						<textarea class="form-control" name="trainer_details">{{$course->trainer_details}}</textarea>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="payment_type">Payment Type</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="payment_type" required>
							<option value="Company Sponsored" {{ $course->payment_type == 'Company Sponsored'  ? 'selected' : '' }}>Company Sponsored</option>
							<option value="Paid by Employee" {{ $course->payment_type == 'Paid by Employee'  ? 'selected' : '' }}>Paid by Employee</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="currency">Currency</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="currency" required>
							<option value="Philippine Peso" {{ $course->currency == 'Philippine Peso'  ? 'selected' : '' }}>Philippine Peso</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row no-gutters">
				<div class="col-3">
					<div class="form-group">
						<label for="cost">Cost</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="cost" value="{{$course->cost}}" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="status">Status</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="status" required>
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
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save course</button>
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