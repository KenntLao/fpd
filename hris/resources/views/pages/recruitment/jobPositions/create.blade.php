{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - Job Positions')
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
<div class="card" id="create">
	<div class="card-header">
		<h3 class="card-title">add job position</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/jobPositions" enctype="multipart/form-data" id="form">
			@csrf
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="job_code">Job Code: </label>
						<span class="badge right badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter job code</p>
							<input class="form-control required" type="text" name="job_code" required>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="job_title">Job Title: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter job title</p>
							<input class="form-control required" type="text" name="job_title" required>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="company_name">Company Name: </label>
						<div class="input">
							<p class="placeholder">Enter company name</p>
							<input class="form-control required" type="text" name="company_name">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<div class="form-group">
						<label class="mr-2" for="hiring_manager">Hiring Manager: </label>
						<select class="form-control required select2" name="hiring_manager">
							<option value="Not selected">Not selected</option>
							<option value="John Doe">John Doe</option>
							<option value="Jane Doe">Jane Doe</option>
						</select>
					</div>
				</div>
				<div class="col-5">
					<div class="form-group">
						<label class="mr-2" for="show_hiring_manager_name">Show Hiring Manager Name: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="show_hiring_manager_name" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="short_description">Short Description: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter short description</p>
							<textarea class="form-control required" name="short_description" required></textarea>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="job_description">Job Description: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter job description</p>
							<textarea class="form-control required" name="job_description" required></textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="requirements">Requirements: </label>
						<div class="input">
							<p class="placeholder">Enter job description</p>
							<textarea class="form-control required" name="requirements"></textarea>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="benefits">Benefits: </label>
						<span class="badge badge-danger">Required</span>
						@if (count($benefits) > 0)
						<select class="form-control required select2" name="benefits" required>
							@foreach($benefits as $benefit)
							<option value="{{$benefit->name}}">{{$benefit->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control required select2" name="benefits">
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="country">Country: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="country" required>
							@foreach($countries as $country)
							<option value='{{$country->name}}'>{{$country->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="city">City: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter city</p>
							<input class="form-control required" type="text" name="city" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="postal_code">Postal Code: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter postal code</p>
							<input class="form-control required" type="text" name="postal_code" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="department">Department: </label>
						<select class="form-control required" name="department">
							<option value="Selected">Select</option>
							<option value="Lorem Ipsum 1">Lorem Ipsum 1</option>
							<option value="Lorem Ipsum 2">Lorem Ipsum 2</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="employment_type">Employment Type: </label>
						@if (count($employmentTypes) > 0)
						<select class="form-control required" name="employment_type">
							@foreach($employmentTypes as $employmentType)
							<option value="{{$employmentType->name}}">{{$employmentType->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control required" name="employment_type">
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="experience_level">Experience Level: </label>
						@if (count($experienceLevels) > 0)
						<select class="form-control required" name="exp_level">
							@foreach($experienceLevels as $experienceLevel)
							<option value="{{$experienceLevel->name}}">{{$experienceLevel->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control required" name="exp_level">
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="job_function">Job Function: </label>
						@if (count($jobFunctions) > 0)
						<select class="form-control required" name="job_function">
							@foreach($jobFunctions as $jobFunction)
							<option value="{{$jobFunction->name}}">{{$jobFunction->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control required" name="job_function">
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="education_level">Education Level: </label>
						@if (count($educationLevels) > 0)
						<select class="form-control required" name="education_level">
							@foreach($educationLevels as $educationLevel)
							<option value="{{$educationLevel->name}}">{{$educationLevel->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control required" name="education_level">
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="show_salary">Show Salary: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required" name="show_salary" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="currency">Currency: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required" name="currency" required>
							<option value="Not selected">Not Selected</option>
							@foreach($currencies as $currency)
							<option value='{{$currency->name}}'>{{$currency->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="salary_min">Salary Min: </label>
						<div class="input">
							<p class="placeholder">Enter salary minimum</p>
							<input class="form-control required" type="text" name="salary_min">
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="salary_max">Salary Max: </label>
						<div class="input">
							<p class="placeholder">Enter salary maximum</p>
							<input class="form-control required" type="text" name="salary_max">
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="keywords">Keywords: </label>
						<div class="input">
							<p class="placeholder">Enter keywords</p>
							<input class="form-control required" type="text" name="keywords">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="status">Status: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required" name="status" required>
							<option value="Active">Active</option>
							<option value="On hold">On Hold</option>
							<option value="Closed">Closed</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="closing_date">Closing Date: </label>
						<input class="form-control required" type="date" name="closing_date">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="image">Image: </label>
						<input type="file" name="image" class="form-control required">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="display_type">Display Type: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required" name="display_type" required>
							<option value="Text Only">Text Only</option>
							<option value="Image Only">Image Only</option>
							<option value="Image and Full Text">Image and Full Text</option>
							<option value="Image and Other Details">Image and Other Details</option>
						</select>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/jobPositions/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
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