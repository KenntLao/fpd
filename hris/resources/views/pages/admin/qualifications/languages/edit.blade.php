{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Qualifications Setup - Languages')
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
		<h3 class="card-title">edit language</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/qualifications/languages/update/{{$language->id}}" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="name">Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="name" value="{{$language->name}}"  required>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="description">Description</label>
						<span class="badge badge-danger">Required</span>
						<textarea class="form-control" name="description" required>{{$language->description}}</textarea>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default" href="/hris/pages/admin/qualifications/languages/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save language</button>
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