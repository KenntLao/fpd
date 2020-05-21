{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Job Titles')
@section('content_header')
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 form-title">
		<h3>edit job title</h3>
	</div>
	<div class="col-12 offset-md-3 col-md-6 box">
		<div class="form-box">
			<form class="form-horizontal" method="post" action="/pages/admin/jobDetails/jobTitles/update/{{$jobTitle->id}}">
				@csrf
				@method('PATCH')
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="job_title_code">Job Title Code: <span>*</span></label>
							<input class="form-control" type="text" name="code" value="{{$jobTitle->code}}" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="job_title">Job Title: <span>*</span></label>
							<input class="form-control" type="text" name="name" value="{{$jobTitle->name}}" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="description">Description: <span>*</span></label>
					<textarea class="form-control" name="description" required>{{$jobTitle->description}}</textarea>
				</div>
				<div class="form-group">
					<label for="specification">Specification: <span>*</span></label>
					<textarea class="form-control" name="specification" required>{{$jobTitle->specification}}</textarea>
				</div>
				<a href="/pages/admin/jobDetails/jobTitles/index">Back</a>
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