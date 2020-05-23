{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Properties Setup - Clients')
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
		<h3 class="card-title">edit client</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/properties/clients/update/{{$client->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="name">Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="name" value="{{$client->name}}" required>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="details">Details</label>
						<textarea class="form-control" name="details">{{$client->details}}</textarea>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="details">Address</label>
						<textarea class="form-control" name="address">{{$client->address}}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="contact_number">Contact Number</label>
						<input class="form-control" type="text" name="contact_number" value="{{$client->contact_number}}">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="email">Contact Email</label>
						<input class="form-control" type="email" name="email" value="{{$client->email}}">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="company_url">Company URL</label>
						<input class="form-control" type="text" name="company_url" value="{{$client->company_url}}">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="status">Status</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="status" required>
							<option value="Active" {{ $client->status == 'Active'  ? 'selected' : '' }}>Active</option>
							<option value="Inactive" {{ $client->status == 'Inactive'  ? 'selected' : '' }}>Inactive</option>
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="first_contact_date">First Contact Date</label>
						<input class="form-control" type="date" name="first_contact_date" value="{{$client->first_contact_date}}">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/properties/clients/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save client</button>
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