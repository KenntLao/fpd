{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Employment Status')
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
		<h3 class="card-title">add employment status</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/jobDetails/employmentStatuses" id="form">
			@csrf
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="name">Employment Status: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter employment status</p>
							<input class="form-control required" type="text" name="name" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="description">Description: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter description</p>
							<textarea class="form-control required" name="description" required></textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/jobDetails/employmentStatuses/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save employment status</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop