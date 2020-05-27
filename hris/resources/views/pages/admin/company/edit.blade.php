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
		<h3 class="card-title">edit company structure</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/company/update/{{$company->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" value="{{$company->name}}" name="name" required>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="details">Details</label>
						<span class="badge badge-danger">Required</span>
						<textarea class="form-control" name="details"required>{{$company->details}}</textarea>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="name">Address: </label>
						<textarea class="form-control" name="address">{{$company->address}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="type">Type</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="type" required>
							@foreach($types as $type)
							<option value='{{$type->name}}' {{ $company->type == $type->name  ? 'selected' : '' }}>{{$type->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="country">Country</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="country" required>
							@foreach($countries as $country)
							<option value='{{$country->name}}' {{ $company->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="timezone">Time Zone</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="timezone" required>
							@foreach($timezones as $timezone)
							<option value="{{$timezone->name}}" {{ $company->timezone == $timezone->name  ? 'selected' : '' }}>{{$timezone->utc}} {{$timezone->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="type">Parent Structure</label>
						<span class="badge badge-danger">Required</span>
						@if (count($companies) > 0)
						<select class="form-control select2" name="parent_structure">
							@foreach($companies as $company)
							<option value="{{$company->name}}">{{$company->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="parent_structure">
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/company/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save company structure</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop