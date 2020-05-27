{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Properties Setup - Employee Projects')
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
		<h3 class="card-title">edit employee project</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/properties/employeeProjects/update/{{$employeeProject->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="employee">Employee: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="employee" required>
							<option value="SocialConz Digital" {{ $employeeProject->employee == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="project">Project: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="project" required>
						@if (count($projects) > 0)
							@foreach($projects as $project)
							<option value="{{$project->name}}" {{ $employeeProject->project == $project->name  ? 'selected' : '' }}>{{$project->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="details">Details: </label>
						<div class="input">
							<p class="placeholder">Enter details</p>
							<textarea class="form-control required" name="details">{{$employeeProject->details}}</textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/properties/employeeProjects/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save employee project</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop