{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Employee Training Sessions')
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
		<h3 class="card-title">edit employee training session</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/training/employeeTrainingSessions/update/{{$employeeTrainingSession->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="employee">Employee</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="employee" required>
							<option value="SocialConz Digital" {{ $employeeTrainingSession->employee == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="training_session">Training Session</label>
						<span class="badge badge-danger">Required</span>
						@if (count($trainingSessions) > 0)
						<select class="form-control select2" name="training_session" required>
							@foreach($trainingSessions as $trainingSession)
							<option value="{{$trainingSession->name}}" {{ $employeeTrainingSession->training_session == $trainingSession->name  ? 'selected' : '' }}>{{$trainingSession->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="training_session" required disabled>
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="status">Status</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="status" required>
							<option value="Scheduled" {{ $employeeTrainingSession->status == 'Scheduled'  ? 'selected' : '' }}>Scheduled</option>
							<option value="Attended" {{ $employeeTrainingSession->status == 'Attended'  ? 'selected' : '' }}>Attended</option>
							<option value="Not Attended" {{ $employeeTrainingSession->status == 'Not Attended'  ? 'selected' : '' }}>Not Attended</option>
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/training/employeeTrainingSessions/index">Back</a>
		<button class="btn btn-primary" type="submit" form="form">save employee training</button>
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