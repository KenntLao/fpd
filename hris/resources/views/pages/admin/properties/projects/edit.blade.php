{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Properties Setup - Projects')
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
		<h3 class="card-title">edit project</h3>
	</div>
	<div class="card-body">
		
		<form class="form-horizontal" method="post" action="/hris/pages/admin/properties/projects/update/{{$project->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter name</p>
							<input class="form-control required" type="text" name="name" value="{{$project->name}}" required>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="client">Client: </label>
						<select class="form-control required select2" name="client">
						@if (count($clients) > 0)
							@foreach($clients as $client)
							<option value="{{$client->name}}" {{ $project->client == $client->name  ? 'selected' : '' }}>{{$client->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Active" {{ $project->client == 'Active'  ? 'selected' : '' }}>Active</option>
							<option value="On Hold" {{ $project->client == 'On Hold'  ? 'selected' : '' }}>On Hold</option>
							<option value="Completed" {{ $project->client == 'Completed'  ? 'selected' : '' }}>Completed</option>
							<option value="Dropped" {{ $project->client == 'Dropped'  ? 'selected' : '' }}>Dropped</option>
						</select>
					</div>
				</div>
			</div>
			<div class="form-group">
				<label class="mr-2" for="details">Details: </label>
				<div class="input">
					<p class="placeholder">Enter details</p>
					<textarea class="form-control required" name="details">{{$project->details}}</textarea>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/properties/projects/index"><i class="fa fa-arrow-left"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save project</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop