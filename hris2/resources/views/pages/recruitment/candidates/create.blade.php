{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - Candidates')
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
		<h3 class="card-title">add candidate</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/candidates" enctype="multipart/form-data" id="form">
			@csrf
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="position_applied">Position Applied</label>
						<span class="badge badge-danger">Required</span>
						@if (count($jobPositions) > 0)
						<select class="form-control select2" name="position_applied" required>
							@foreach($jobPositions as $jobPosition)
							<option value="{{$jobPosition->job_title}}">{{$jobPosition->job_title}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="position_applied" required>
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="hiring_stage">Hiring Stage</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="hiring_stage" required>
							<option value="Sourced">Sourced</option>
							<option value="Hired">Hired</option>
							<option value="Archived">Archived</option>
							<option value="Not Qualified">Not Qualified</option>
							<option value="Offer Rejected">Offer Rejected</option>
							<option value="Offer Accepted">Offer Accepted</option>
							<option value="Offer Sent">Offer Sent</option>
							<option value="First Interview">First Interview</option>
							<option value="Second Interview">Second Interview</option>
							<option value="Final Interview">Final Interview</option>
							<option value="Assessment">Assessment</option>
							<option value="Phone Screen">Phone Screen</option>
							<option value="Applied">Applied</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="first_name">First Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="first_name" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="last_name" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="profile_image">Profile Image</label>
						<input class="form-control" type="file" name="profile_image">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="gender">Gender</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="gender" required>
							<option value="Female">Female</option>
							<option value="Male">Male</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="city">City:</label>
						<input class="form-control" type="text" name="city">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="country">Country</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="country" required>
							@foreach($countries as $country)
							<option value='{{$country->name}}'>{{$country->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="email">Email</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="email" name="email" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="telephone">Telephone</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="telephone" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="resume">Resume</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="file" name="resume" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="resume_headline">Resume Headline</label>
						<textarea class="form-control" name="resume_headline"></textarea>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="profile_summary">Profile Summary:</label>
						<textarea class="form-control" name="profile_summary"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="total_years_exp">Total Years of Experience:</label>
						<textarea class="form-control" name="total_years_exp"></textarea>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="work_history">Work History:</label>
						<textarea class="form-control" name="work_history"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="education">Education:</label>
						<textarea class="form-control" name="education"></textarea>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="skills">Skills:</label>
						<textarea class="form-control" name="skills"></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="referees">Referees:</label>
						<textarea class="form-control" name="referees"></textarea>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="prefered_industry">Prefered Industry</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="prefered_industry" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="expected_salary">Expected Salary:</label>
						<input class="form-control" type="text" name="expected_salary">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/candidates/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save candidate</button>
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