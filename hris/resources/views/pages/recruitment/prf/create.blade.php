{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - PRF')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-columns"></i> recruitment</h1>
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
<div class="card" id="create">
	<div class="card-header">
		<h3 class="card-title">PRF Request</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/prf" enctype="multipart/form-data" id="form">
			@include('pages.recruitment.prf.form')
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/prf/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> submit</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script>
	$(function() {
		$('#project_based_file').hide();
		$('#cmo_based_remarks').hide();
		$('#project_based').change(function() {
			if ($(this).find("option:selected").attr('value') == "As per Actual: With variance on rate") {
				$('#project_based_file').show();
			} else {
				$('#project_based_file').hide();
			}
		});
		$('#cmo_based').change(function() {
			if ($(this).find("option:selected").attr('value') != "0") {
				$('#cmo_based_remarks').show();
			} else {
				$('#cmo_based_remarks').hide();
			}
		});
	});
</script>
@stop