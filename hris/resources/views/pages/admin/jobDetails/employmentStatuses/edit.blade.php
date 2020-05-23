{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Employment Status')
@section('content_header')
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 form-title">
		<h3>edit employment status</h3>
	</div>
	<div class="col-12 offset-md-3 col-md-6 box">
		<div class="form-box">
			<form class="form-horizontal" method="post" action="/pages/admin/jobDetails/employmentStatuses/update/{{$employmentStatus->id}}">
				@csrf
				@method('PATCH')
				<div class="form-group">
					<label for="name">Employment Status: <span>*</span></label>
					<input class="form-control" type="text" name="name" value="{{$employmentStatus->name}}" required>
				</div>
				<div class="form-group">
					<label for="description">Description: <span>*</span></label>
					<textarea class="form-control" name="description" required>{{$employmentStatus->description}}</textarea>
				</div>
				<a href="/pages/admin/jobDetails/employmentStatuses/index">Back</a>
				<button type="submit">submit</button>
			</form>
		</div>
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