{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Document Management - Company Documents')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-file"></i> Company Documents</h1>
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
		<h3 class="card-title">add company document</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/employees/documents/companyDocuments" enctype="multipart/form-data" id="form">
            @include('pages.employees.documents.companyDocuments.form')
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/employees/documents/companyDocuments/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save company document</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script type="text/javascript">
	$('#department_dropdown').on('change', function() {
		if ( $(this).val() == '' ) {
			var department_id = 0;
			var _token = $('input[name="_token"]').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('getEmployee.fetch')}}",
				method: "POST",
				data: {
					_token: _token,
					department_id: department_id,
				},
				success: function(response) {
					$('#employee').html(response);
				}
			});
		}
		if ($(this).val() != '') {
			var department_id = $(this).val();
			var _token = $('input[name="_token"]').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('getEmployee.fetch')}}",
				method: "POST",
				data: {
					_token: _token,
					department_id: department_id,
				},
				success: function(response) {
					$('#employee').html(response);
				}
			});
		}
	});
</script>
@stop