{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Leave Settings - Leave Groups')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-pause"></i> Leave Settings</h1>
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
		<h3 class="card-title">edit leave group</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/leave/leaveGroups/update/{{$leaveGroup->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="name">Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter name</p>
							<input class="form-control required" type="text" name="name" value="{{$leaveGroup->name}}" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="details">Details: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter details</p>
							<textarea class="form-control required" name="details">{{$leaveGroup->details}}</textarea>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/leave/leaveGroups/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save leave group</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop