{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Courses')
@section('content_header')
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 form-title">
		<h3>edit course</h3>
	</div>
	<div class="col-12 offset-md-3 col-md-6 box">
		<div class="form-box">
			<form class="form-horizontal" method="post" action="/pages/admin/training/courses/update/{{$course->id}}">
				@csrf
				@method('PATCH')
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="code">Code: <span>*</span></label>
							<input class="form-control" type="text" name="code" value="{{$course->code}}" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="name">Name: <span>*</span></label>
							<input class="form-control" type="text" name="name" value="{{$course->name}}" required>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="coordinator">Coordinator: <span>*</span></label>
							<select class="form-control select2" name="coordinator" required>
								<option value="SocialConz Digital" {{ $course->coordinator == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="trainer">Trainer: </label>
							<input class="form-control" type="text" name="trainer" value="{{$course->trainer}}">
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="trainer_details">Trainer Details: </label>
					<textarea class="form-control" name="trainer_details">{{$course->trainer_details}}</textarea>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="payment_type">Payment Type: <span>*</span></label>
							<select class="form-control select2" name="payment_type" required>
								<option value="Company Sponsored" {{ $course->payment_type == 'Company Sponsored'  ? 'selected' : '' }}>Company Sponsored</option>
								<option value="Paid by Employee" {{ $course->payment_type == 'Paid by Employee'  ? 'selected' : '' }}>Paid by Employee</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="currency">Currency: <span>*</span></label>
							<select class="form-control select2" name="currency" required>
								<option value="Philippine Peso" {{ $course->currency == 'Philippine Peso'  ? 'selected' : '' }}>Philippine Peso</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="cost">Cost: <span>*</span></label>
							<input class="form-control" type="text" name="cost" value="{{$course->cost}}" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="status">Status: <span>*</span></label>
							<select class="form-control select2" name="status" required>
								<option value="Active" {{ $course->status == 'Active'  ? 'selected' : '' }}>Active</option>
								<option value="Inactive" {{ $course->status == 'Inactive'  ? 'selected' : '' }}>Inactive</option>
							</select>
						</div>
					</div>
				</div>
				<a href="/pages/admin/training/courses/index">Back</a>
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