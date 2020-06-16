{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Employees - Employee')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-users"></i> Employee Management</h1>
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
		<h3 class="card-title">Create Employee</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/employees/employee" enctype="multipart/form-data" id="form">
			@csrf
			@include('pages.employees.employee.form')
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/employees/employee/index"><i class="fa fa-arrow-left"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload"></i> save employee record</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script>
	//preview image
	var loadFile = function(event) {
		var output = document.getElementById('image-preview');
		output.src = URL.createObjectURL(event.target.files[0]);
		output.onload = function() {
			URL.revokeObjectURL(output.src) // free memory
		}
	};
	$("body").on("click", ".select-role label", function(e) {
		var getLabel = $(this);
		var getLabelFor = $(this).attr("for");
		var goToParent = $(this).parents(".select-role");
		var getCheckbox = goToParent.find("input[id = " + getLabelFor + "]");
		
		getCheckbox.attr('checked', 'checked');

		if (getCheckbox.is(":checked")) {
			getLabel.addClass('role-checked');
		} else {
			getLabel.removeClass('role-checked');
		}
		console.log(getCheckbox.attr("id"));

	});
</script>
@stop