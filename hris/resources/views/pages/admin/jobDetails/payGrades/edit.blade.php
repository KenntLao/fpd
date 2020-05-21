{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Pay Grades')
@section('content_header')
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 form-title">
		<h3>add pay grade</h3>
	</div>
	<div class="col-12 offset-md-3 col-md-6 box">
		<div class="form-box">
			<form class="form-horizontal" method="post" action="/pages/admin/jobDetails/payGrades/update/{{$payGrade->id}}">
				@csrf
				@method('PATCH')
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="name">Pay Grade Name: <span>*</span></label>
							<input class="form-control" type="text" name="name" value="{{$payGrade->name}}" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="currency">Currency: <span>*</span></label>
							<select class="form-control select2" name="currency" required>
								<option value="Philippine Peso" selected>Philippine Peso</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="min_salary">Min Salary: <span>*</span></label>
							<input class="form-control" type="text" name="min_salary" value="{{$payGrade->min_salary}}" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="max_salary">Max Salary: <span>*</span></label>
							<input class="form-control" type="text" name="max_salary" value="{{$payGrade->max_salary}}" required>
						</div>
					</div>
				</div>
				<a href="/pages/admin/jobDetails/payGrades/index">Back</a>
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