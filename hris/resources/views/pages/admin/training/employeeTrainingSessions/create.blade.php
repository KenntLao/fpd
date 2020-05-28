{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Employee Training Sessions')
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
		<h3 class="card-title">add employee training session</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/training/employeeTrainingSessions" id="form">
			@csrf
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="employee">Employee: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="employee" required>
							<option value="SocialConz Digital">SocialConz Digital</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="training_session">Training Session: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="training_session" required>
						@if (count($trainingSessions) > 0)
							@foreach($trainingSessions as $trainingSession)
							<option value="{{$trainingSession->name}}">{{$trainingSession->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Scheduled">Scheduled</option>
							<option value="Attended">Attended</option>
							<option value="Not Attended">Not Attended</option>
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/training/employeeTrainingSessions/index">Back</a>
		<button class="btn btn-success" type="submit" form="form">save employee training</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop