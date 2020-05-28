{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Leave Settings - Holidays')
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
		<h3 class="card-title">edit holiday</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/leave/holidays/update/{{$holiday->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter holiday name</p>
							<input class="form-control required" type="text" name="name" value="{{$holiday->name}}" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="holiday_date">Date: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control required" type="date" name="holiday_date" value="{{$holiday->holiday_date}}" required>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Full Day" {{ $holiday->status == 'Full Day'  ? 'selected' : '' }}>Full Day</option>
							<option value="Half Day" {{ $holiday->status == 'Half Day'  ? 'selected' : '' }}>Half Day</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="country">Country: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="country">
							@if(count($countries) > 0)
							@foreach($countries as $country)
							<option value="For All Countries" {{ $holiday->country == 'For All Countries'  ? 'selected' : '' }}>For All Countries</option>
							<option value="{{$country->name}}">{{$country->name}}</option>
							@endforeach
							@else
							<option value="For All Countries" {{ $holiday->country == 'For All Countries'  ? 'selected' : '' }}>For All Countries</option>
							@endif
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/leave/holidays/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save holiday</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop