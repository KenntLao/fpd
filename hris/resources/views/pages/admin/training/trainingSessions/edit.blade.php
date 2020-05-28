{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Training Sessions')
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
		<h3 class="card-title">edit training session</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/training/trainingSessions/update/{{$trainingSession->id}}" enctype="multipart/form-data" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter name</p>
							<input class="form-control required" type="text" name="name" value="{{$trainingSession->name}}" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="course">Course: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="course_id" required>
						@if(count($courses) > 0)
							@foreach($courses as $course)
							<option value="{{$course->id}}" {{ $course->id == $trainingSession->course_id  ? 'selected' : '' }}>{{$course->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="details">Details: </label>
						<div class="input">
							<p class="placeholder">Enter details</p>
							<textarea class="form-control required" name="details">{{$trainingSession->details}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="scheduled_time">Scheduled Time: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control required" type="datetime-local" name="scheduled_time" value="{{ date('Y-m-d\TH:i', strtotime($trainingSession->scheduled_time)) }}" required>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="assignment_due_date">Assignment Due Date: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control required" type="date" value="{{$trainingSession->assignment_due_date}}" name="assignment_due_date" required>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="delivery_method">Delivery Method: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="delivery_method">
							<option value="Classroom" {{ $trainingSession->delivery_method == 'Classroom'  ? 'selected' : '' }}>Classroom</option>
							<option value="Self Study" {{ $trainingSession->delivery_method == 'Self Study'  ? 'selected' : '' }}>Self Study</option>
							<option value="Online" {{ $trainingSession->delivery_method == 'Online'  ? 'selected' : '' }}>Online</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="delivery_location">Delivery Location: </label>
						<div class="input">
							<p class="placeholder">Enter delivery location</p>
							<input class="form-control required" type="text" name="delivery_location" value="{{$trainingSession->delivery_location}}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="attendance_type">Attendance Type: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="attendance_type">
							<option value="Sign Up" {{ $trainingSession->attendance_type == 'Sign Up'  ? 'selected' : '' }}>Sign Up</option>
							<option value="Assign" {{ $trainingSession->attendance_type == 'Assign'  ? 'selected' : '' }}>Assign</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="attachment">Attachment: : </label>
						<input class="form-control required" type="file" name="attachment">
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="training_cert_required">Training Certificate Required: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="training_cert_required">
							<option value="Yes" {{ $trainingSession->training_cert_required == 'Yes'  ? 'selected' : '' }}>Yes</option>
							<option value="No" {{ $trainingSession->training_cert_required == 'No'  ? 'selected' : '' }}>No</option>
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/training/trainingSessions/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save training session</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop