{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Properties Setup - Clients')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-list-alt"></i> Properties Setup</h1>
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
		<h3 class="card-title">edit client</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/properties/clients/update/{{$client->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter name</p>
							<input class="form-control required" type="text" name="name" value="{{$client->name}}" required>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="details">Details: </label>
						<div class="input">
							<p class="placeholder">Enter details</p>
							<textarea class="form-control required" name="details">{{$client->details}}</textarea>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="details">Address: </label>
						<div class="input">
							<p class="placeholder">Enter address</p>
							<textarea class="form-control required" name="address">{{$client->address}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="contact_number">Contact Number: </label>
						<div class="input">
							<p class="placeholder">Enter contact number</p>
							<input class="form-control required" type="text" name="contact_number" value="{{$client->contact_number}}">
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="email">Contact Email: </label>
						<div class="input">
							<p class="placeholder">Enter email address</p>
							<input class="form-control required" type="email" name="email" value="{{$client->email}}">
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="company_url">Company URL: </label>
						<div class="input">
							<p class="placeholder">Enter company URL</p>
							<input class="form-control required" type="text" name="company_url" value="{{$client->company_url}}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Active" {{ $client->status == 'Active'  ? 'selected' : '' }}>Active</option>
							<option value="Inactive" {{ $client->status == 'Inactive'  ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="first_contact_date">First Contact Date: </label>
						<input class="form-control required" type="date" name="first_contact_date" value="{{$client->first_contact_date}}">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/properties/clients/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save client</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop