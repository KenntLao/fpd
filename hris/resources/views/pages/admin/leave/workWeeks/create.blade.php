{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Leave Settings - Work Weeks')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-pause"></i> Leave Settings</h1>
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
		<h3 class="card-title">add work week</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/leave/workWeeks" id="form">
			@csrf
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="day">Day: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="day" required>
							<option value="Monday">Monday</option>
							<option value="Tuesday">Tuesday</option>
							<option value="Wednesday">Wednesday</option>
							<option value="Thursday">Thursday</option>
							<option value="Friday">Friday</option>
							<option value="Saturday">Saturday</option>
							<option value="Sunday">Sunday</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Full Day">Full Day</option>
							<option value="Half Day">Half Day</option>
							<option value="Non-working Day">Non-working Day</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="country">Country: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="country">
							@if(count($countries) > 0)
							@foreach($countries as $country)
							<option value="For All Countries">For All Countries</option>
							<option value="{{$country->name}}">{{$country->name}}</option>
							@endforeach
							@else
							<option value="For All Countries">For All Countries</option>
							@endif
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/leave/workWeeks/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save work week</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop