{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Job Titles')
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
		<h3 class="card-title">add job title</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/jobDetails/jobTitles" id="form">
			@csrf
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="job_title_code">Job Title Code</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="code" required>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="job_title">Job Title</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="name" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="description">Description</label>
						<span class="badge badge-danger">Required</span>
						<textarea class="form-control" name="description" required></textarea>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="specification">Specification</label>
						<span class="badge badge-danger">Required</span>
						<textarea class="form-control" name="specification" required></textarea>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/jobDetails/jobTitles/index"><i class="fa fa-arrow-left"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload"></i> save job title</button>
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