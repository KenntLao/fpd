{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Properties Setup - Projects')
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
		<h3 class="card-title">add project</h3>
	</div>
	<div class="card-body">
		
		<form class="form-horizontal" method="post" action="/hris/pages/admin/properties/projects" id="form">
			@csrf
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="name">Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="name" required>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="client">Client: </label>
						@if (count($clients) > 0)
						<select class="form-control select2" name="client">
							@foreach($clients as $client)
							<option value="{{$client->name}}">{{$client->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="client" disabled>
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
							<option value="Active">Active</option>
							<option value="On Hold">On Hold</option>
							<option value="Completed">Completed</option>
							<option value="Dropped">Dropped</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label for="details">Details: </label>
				<textarea class="form-control" name="details"></textarea>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/properties/projects/index"><i class="fa fa-arrow-left"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save project</button>
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