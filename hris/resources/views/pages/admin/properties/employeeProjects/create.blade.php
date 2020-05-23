{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Properties Setup - Employee Projects')
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
		<h3 class="card-title">add employee project</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/properties/employeeProjects" id="form">
			@csrf
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="employee">Employee</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="employee" required>
							<option value="SocialConz Digital">SocialConz Digital</option>
						</select>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="project">Project</label>
						<span class="badge badge-danger">Required</span>
						@if (count($projects) > 0)
						<select class="form-control select2" name="project" required>
							@foreach($projects as $project)
							<option value="{{$project->name}}">{{$project->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="project" disabled>
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="details">Details</label>
						<textarea class="form-control" name="details"></textarea>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/properties/employeeProjects/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save employee project</button>
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