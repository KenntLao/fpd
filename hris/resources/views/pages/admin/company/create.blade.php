{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Administration - Company Structure')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-building "></i> Company Structure</h1>
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
		<h3 class="card-title">add company structure</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/company" id="form">
			@csrf
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter name</p>
							<input class="form-control required" type="text" name="name" required>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="details">Details</label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter details</p>
							<textarea class="form-control required" name="details" required></textarea>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="name">Address: </label>
						<div class="input">
							<p class="placeholder">Enter address</p>
							<textarea class="form-control required" name="address"></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="type">Type</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="type" required>
							@if(count($types) > 0)
							@foreach($types as $type)
							<option value='{{$type->name}}'>{{$type->name}}</option>
							@endforeach
							@else
							<option value='None'>None</option>
							@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="country">Country</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="country" required>
							@if(count($countries) > 0)
							@foreach($countries as $country)
							<option value='{{$country->name}}'>{{$country->name}}</option>
							@endforeach
							@else
							<option value='None'>None</option>
							@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="timezone">Time Zone</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="timezone" required>
							@if(count($timezones) > 0)
							@foreach($timezones as $timezone)
							<option value="{{$timezone->name}}">{{$timezone->utc}} {{$timezone->name}}</option>
							@endforeach
							@else
							<option value='None'>None</option>
							@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="type">Parent Structure</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="parent_structure" required>
							@if (count($companies) > 0)
							@foreach($companies as $company)
							<option value="{{$company->name}}">{{$company->name}}</option>
							@endforeach
							@else
							<option value='None'>None</option>
							@endif
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/company/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save company structure</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop