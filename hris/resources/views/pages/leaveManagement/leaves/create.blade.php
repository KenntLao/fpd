@extends('adminlte::page')
@section('title', 'HRIS | Leave Management - Apply Leave')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-columns"></i> Leaves</h1>
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
		<h3 class="card-title">Apply Leave</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/leaveManagement/leaves" id="form">
			@include('pages.leaveManagement.leaves.form')
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/leaveManagement/leaves/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> Submit</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script>
	$('.short_leave_date').hide();
	$('.short_leave_date > .form-group > .input').children(":input").prop("disabled", true);


	$('.half_day').on('change', function() {
		var half_day_val = $('.half_day').val();
		if (half_day_val == 0) {
			$('.long_leave_date > .form-group > .input').children(":input").prop("disabled", false);
			$('.short_leave_date > .form-group > .input').children(":input").prop("disabled", true);
		} else {
			$('.long_leave_date').hide();
			$('.long_leave_date > .form-group > .input').children(":input").prop("disabled", true);


			$('.short_leave_date').show();
			$('.short_leave_date > .form-group > .input').children(":input").prop("disabled", false);
		}
	});
</script>
@stop