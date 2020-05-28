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
		<h3 class="card-title">edit work week</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/leave/workWeeks/update/{{$workWeek->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="day">Day: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="day" required>
							<option value="Monday" {{ $workWeek->day == 'Monday'  ? 'selected' : '' }}>Monday</option>
							<option value="Tuesday" {{ $workWeek->day == 'Tuesday'  ? 'selected' : '' }}>Tuesday</option>
							<option value="Wednesday" {{ $workWeek->day == 'Wednesday'  ? 'selected' : '' }}>Wednesday</option>
							<option value="Thursday" {{ $workWeek->day == 'Thursday'  ? 'selected' : '' }}>Thursday</option>
							<option value="Friday" {{ $workWeek->day == 'Friday'  ? 'selected' : '' }}>Friday</option>
							<option value="Saturday" {{ $workWeek->day == 'Saturday'  ? 'selected' : '' }}>Saturday</option>
							<option value="Sunday" {{ $workWeek->day == 'Sunday'  ? 'selected' : '' }}>Sunday</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Full Day" {{ $workWeek->status == 'Full Day'  ? 'selected' : '' }}>Full Day</option>
							<option value="Half Day" {{ $workWeek->status == 'Half Day'  ? 'selected' : '' }}>Half Day</option>
							<option value="Non-working Day" {{ $workWeek->status == 'Non-working Day'  ? 'selected' : '' }}>Non-working Day</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="country">Country: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="country" required>
							@if(count($countries) > 0)
							@foreach($countries as $country)
							<option value="For All Countries" {{ $workWeek->country == 'For All Countries'  ? 'selected' : '' }}>For All Countries</option>
							<option value="{{$country->name}}" {{ $workWeek->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
							@endforeach
							@else
							<option value="For All Countries" {{ $workWeek->country == 'For All Countries'  ? 'selected' : '' }}>For All Countries</option>
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