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
		<h3 class="card-title">edit candidate</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/candidates/update/{{$candidate->id}}" enctype="multipart/form-data" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="position_applied">Position Applied</label>
						<span class="badge badge-danger">Required</span>
						@if (count($jobPositions) > 0)
						<select class="form-control select2" name="position_applied" required>
							@foreach($jobPositions as $jobPosition)
							<option value='{{$jobPosition->job_title}}' {{ $jobPosition->job_title == $candidate->position_applied  ? 'selected' : '' }}>{{$jobPosition->job_title}}</option>
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
							<option value="Sourced" {{ $candidate->hiring_stage == 'Sourced'  ? 'selected' : '' }}>Sourced</option>
							<option value="Hired" {{ $candidate->hiring_stage == 'Hired'  ? 'selected' : '' }}>Hired</option>
							<option value="Archived" {{ $candidate->hiring_stage == 'Archived'  ? 'selected' : '' }}>Archived</option>
							<option value="Not Qualified" {{ $candidate->hiring_stage == 'Not Qualified'  ? 'selected' : '' }}>Not Qualified</option>
							<option value="Offer Rejected" {{ $candidate->hiring_stage == 'Offer Rejected'  ? 'selected' : '' }}>Offer Rejected</option>
							<option value="Offer Accepted" {{ $candidate->hiring_stage == 'Offer Accepted'  ? 'selected' : '' }}>Offer Accepted</option>
							<option value="Offer Sent" {{ $candidate->hiring_stage == 'Offer Sent'  ? 'selected' : '' }}>Offer Sent</option>
							<option value="First Interview" {{ $candidate->hiring_stage == 'First Interview'  ? 'selected' : '' }}>First Interview</option>
							<option value="Second Interview" {{ $candidate->hiring_stage == 'Second Interview'  ? 'selected' : '' }}>Second Interview</option>
							<option value="Final Interview" {{ $candidate->hiring_stage == 'Final Interview'  ? 'selected' : '' }}>Final Interview</option>
							<option value="Assessment" {{ $candidate->hiring_stage == 'Assessment'  ? 'selected' : '' }}>Assessment</option>
							<option value="Phone Screen" {{ $candidate->hiring_stage == 'Phone Screen'  ? 'selected' : '' }}>Phone Screen</option>
							<option value="Applied" {{ $candidate->hiring_stage == 'Applied'  ? 'selected' : '' }}>Applied</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="first_name">First Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="first_name" value="{{ $candidate->first_name }}" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="last_name">Last Name</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="last_name" value="{{ $candidate->last_name }}" required>
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
							<option value="Female" {{ $candidate->gender == 'Female'  ? 'selected' : '' }}>Female</option>
							<option value="Male" {{ $candidate->gender == 'Male'  ? 'selected' : '' }}>Male</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="city">City</label>
						<input class="form-control" type="text" name="city" value="{{ $candidate->city }}">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="country">Country</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="country" required>
							@foreach($countries as $country)
							<option value='{{$country->name}}' {{ $candidate->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
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
						<input class="form-control" type="email" name="email" value="{{ $candidate->email }}" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="telephone">Telephone</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="telephone" value="{{ $candidate->telephone }}" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="resume">Resume</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="file" name="resume">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="resume_headline">Resume Headline</label>
						<textarea class="form-control" name="resume_headline">{{ $candidate->resume_headline }}</textarea>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="profile_summary">Profile Summary</label>
						<textarea class="form-control" name="profile_summary">{{ $candidate->profile_summary }}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="total_years_exp">Total Years of Experience</label>
						<textarea class="form-control" type="text" name="total_years_exp">{{ $candidate->total_years_exp }}</textarea>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="work_history">Work History</label>
						<textarea class="form-control" name="work_history">{{ $candidate->work_history }}</textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="education">Education</label>
						<textarea class="form-control" name="education">{{ $candidate->education }}</textarea>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="skills">Skills</label>
						<textarea class="form-control" name="skills">{{ $candidate->skills }}</textarea>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label for="referees">Referees</label>
						<textarea class="form-control" name="referees">{{ $candidate->referees }}</textarea>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="prefered_industry">Prefered Industry</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="prefered_industry" value="{{ $candidate->prefered_industry }}">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="expected_salary">Expected Salary</label>
						<input class="form-control" type="text" name="expected_salary" value="{{ $candidate->expected_salary }}">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/candidates/index"><i class="fa fa-arrow-left mr-1"></i> Back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save candidate</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop