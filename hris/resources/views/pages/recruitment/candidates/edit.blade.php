{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - Candidates')
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
<div class="card">
	<div class="card-header">
		<h3 class="card-title">edit candidate</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/candidates/update/{{$candidate->id}}" enctype="multipart/form-data" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="position_applied">Position Applied: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="position_applied" required>
						@if (count($jobPositions) > 0)
							@foreach($jobPositions as $jobPosition)
							<option value='{{$jobPosition->job_title}}' {{ $jobPosition->job_title == $candidate->position_applied  ? 'selected' : '' }}>{{$jobPosition->job_title}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="hiring_stage">Hiring Stage: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="hiring_stage" required>
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
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="first_name">First Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter first name</p>
							<input class="form-control required" type="text" name="first_name" value="{{ $candidate->first_name }}" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="last_name">Last Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter last name</p>
							<input class="form-control required" type="text" name="last_name" value="{{ $candidate->last_name }}" required>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="profile_image">Profile Image: </label>
						<input class="form-control required" type="file" name="profile_image">
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="gender">Gender: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="gender" required>
							<option value="Female" {{ $candidate->gender == 'Female'  ? 'selected' : '' }}>Female</option>
							<option value="Male" {{ $candidate->gender == 'Male'  ? 'selected' : '' }}>Male</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="city">City: </label>
						<div class="input">
							<p class="placeholder">Enter city</p>
							<input class="form-control required" type="text" name="city" value="{{ $candidate->city }}">
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="country">Country: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="country" required>
							@if(count($countries) > 0)
								@foreach($countries as $country)
								<option value='{{$country->name}}' {{ $candidate->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
								@endforeach
							@else
								<option value="None">None</option>
							@endif
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="email">Email Address: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter email address</p>
							<input class="form-control required" type="email" name="email" value="{{ $candidate->email }}" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="telephone">Telephone: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter telephone number</p>
							<input class="form-control required" type="text" name="telephone" value="{{ $candidate->telephone }}" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="resume">Resume: </label>
						<input class="form-control required" type="file" name="resume">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="resume_headline">Resume Headline: </label>
						<div class="input">
							<p class="placeholder">Enter resume headline</p>
							<textarea class="form-control required" name="resume_headline">{{ $candidate->resume_headline }}</textarea>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="profile_summary">Profile Summary: </label>
						<div class="input">
							<p class="placeholder">Enter profile summary</p>
							<textarea class="form-control required" name="profile_summary">{{ $candidate->profile_summary }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="total_years_exp">Total Years of Experience: </label>
						<div class="input">
							<p class="placeholder">Enter total years of experience</p>
							<textarea class="form-control required" type="text" name="total_years_exp">{{ $candidate->total_years_exp }}</textarea>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="work_history">Work History: </label>
						<div class="input">
							<p class="placeholder">Enter work history</p>
							<textarea class="form-control required" name="work_history">{{ $candidate->work_history }}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="education">Education: </label>
						<div class="input">
							<p class="placeholder">Enter education</p>
							<textarea class="form-control required" name="education">{{ $candidate->education }}</textarea>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="skills">Skills: </label>
						<div class="input">
							<p class="placeholder">Enter skills</p>
							<textarea class="form-control required" name="skills">{{ $candidate->skills }}</textarea>
						</div>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="referees">Referees: </label>
						<div class="input">
							<p class="placeholder">Enter referees</p>
							<textarea class="form-control required" name="referees">{{ $candidate->referees }}</textarea>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="prefered_industry">Prefered Industry: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter prefered industry</p>
							<input class="form-control required" type="text" name="prefered_industry" value="{{ $candidate->prefered_industry }}">
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="expected_salary">Expected Salary: </label>
						<div class="input">
							<p class="placeholder">Enter expected salary</p>
							<input class="form-control required" type="text" name="expected_salary" value="{{ $candidate->expected_salary }}">
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/candidates/index"><i class="fa fa-arrow-left mr-1"></i> Back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save candidate</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop