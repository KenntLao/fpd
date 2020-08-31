{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Management - My Training Sessions')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-briefcase"></i> Training Management</h1>
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
		<h3 class="card-title">Training Session</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/completed" enctype="multipart/form-data" id="form">
			@method('PATCH')
			@csrf
			<div class="row">
				<div class="col-12 col-sm-6">
					<div class="form-group">
						<label for="proof" class="mr-2">Proof of completion: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control required" type="file" name="proof">
					</div>
				</div>
				<div class="col-12 col-sm-6">
					<div class="form-group">
						<label for="feedback" class="mr-2">Feedback: </label>
						<div class="input">
							<p class="placeholder">Enter feedback</p>
							<textarea class="form-control" name="feedback"></textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="{{URL::previous()}}"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> Submit</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop