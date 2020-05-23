{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Training Sessions')
@section('content_header')
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 form-title">
		<h3>add training session</h3>
	</div>
	<div class="col-12 offset-md-3 col-md-6 box">
		<div class="form-box">
			<form class="form-horizontal" method="post" action="/pages/admin/training/trainingSessions" enctype="multipart/form-data">
				@csrf
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="name">Name: <span>*</span></label>
							<input class="form-control" type="text" name="name" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="course">Course: <span>*</span></label>
							<select class="form-control select2" name="course_id" required>
								@foreach($courses as $course)
								<option value="{{$course->id}}">{{$course->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="details">Details</label>
					<textarea class="form-control" name="details"></textarea>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="scheduled_time">Scheduled Time: <span>*</span></label>
							<input class="form-control" type="datetime-local" name="scheduled_time" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="assignment_due_date">Assignment Due Date: </label>
							<input class="form-control" type="date" name="assignment_due_date" required>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="delivery_method">Delivery Method: <span>*</span></label>
							<select class="form-control select2" name="delivery_method">
								<option value="Classroom">Classroom</option>
								<option value="Self Study">Self Study</option>
								<option value="Online">Online</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="delivery_location">Delivery Location: </label>
							<input class="form-control" type="text" name="delivery_location">
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="attendance_type">Attendance Type: <span>*</span></label>
							<select class="form-control select2" name="attendance_type">
								<option value="Sign Up">Sign Up</option>
								<option value="Assign">Assign</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="attachment">Attachment: </label>
							<input class="form-control" type="file" name="attachment">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="training_cert_required">Training Certificate Required: <span>*</span></label>
					<select class="form-control select2" name="training_cert_required">
						<option value="Yes">Yes</option>
						<option value="No">No</option>
					</select>
				</div>
				<a href="/pages/admin/training/trainingSessions/index">Back</a>
				<button type="submit">submit</button>
			</form>
		</div>
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