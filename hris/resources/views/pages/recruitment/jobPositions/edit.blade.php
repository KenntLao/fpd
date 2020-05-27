{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - Job Positions')
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
		<h3 class="card-title">edit job position</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/jobPositions/update/{{$jobPosition->id}}" enctype="multipart/form-data" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="job_code">Job Code</label>
						<span class="badge right badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter job code</p>
							<input class="form-control required" type="text" name="job_code" value="{{$jobPosition->job_code}}" required>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="job_title">Job Title</label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter job title</p>
							<input class="form-control required" type="text" name="job_title" value="{{$jobPosition->job_title}}" required>
						</div>
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label class="mr-2" for="company_name">Company Name:</label>
						<div class="input">
							<p class="placeholder">Enter company name</p>
							<input class="form-control required" type="text" name="company_name" value="{{$jobPosition->company_name}}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-5">
					<div class="form-group">
						<label class="mr-2" for="hiring_manager">Hiring Manager:</label>
						<select class="form-control required select2" name="hiring_manager">
							<option value="Not Selected" {{ $jobPosition->hiring_manager == 'Not Selected'  ? 'selected' : '' }}>Not Selected</option>
							<option value="John Doe" {{ $jobPosition->hiring_manager == 'John Doe'  ? 'selected' : '' }}>John Doe</option>
							<option value="Jane Doe"{{ $jobPosition->hiring_manager == 'Jane Doe'  ? 'selected' : '' }}>Jane Doe</option>
						</select>
					</div>
				</div>
				<div class="col-5">
					<div class="form-group">
						<label class="mr-2" for="show_hiring_manager_name">Show Hiring Manager Name</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="show_hiring_manager_name" required>
							<option value="Yes" {{ $jobPosition->show_hiring_manager_name == 'Yes'  ? 'selected' : '' }}>Yes</option>
							<option value="No" {{ $jobPosition->show_hiring_manager_name == 'No'  ? 'selected' : '' }}>No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="job_description">Job Description</label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter job description</p>
							<textarea class="form-control required" name="job_description" required>{{$jobPosition->job_description}}</textarea>
						</div>
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="short_description">Short Description</label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter short description</p>
							<textarea class="form-control required" name="short_description" required>{{$jobPosition->short_description}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-6">
					<div class="form-group">
						<label class="mr-2" for="requirements">Requirements</label>
						<div class="input">
							<p class="placeholder">Enter requirements</p>
							<textarea class="form-control required" name="requirements">{{$jobPosition->requirements}}</textarea>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="benefits">Benefits</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="benefits" required>
							@if (count($benefits) > 0)
								@foreach($benefits as $benefit)
								<option value="{{$benefit->name}}"  {{ $jobPosition->benefits == $benefit->name  ? 'selected' : '' }}>{{$benefit->name}}</option>
								@endforeach
							@else
								<option value="None">None</option>
							@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="country">Country</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="country" required>
							@if(count($countries) > 0)
								@foreach($countries as $country)
								<option value='{{$country->name}}' {{ $jobPosition->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
								@endforeach
							@else
								<option value="None">None</option>
							@endif
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="city">City</label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter city</p>
							<input class="form-control required" type="text" name="city" value="{{$jobPosition->city}}" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="postal_code">Postal Code</label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							 <p class="placeholder">Enter postal code</p>
							<input class="form-control required" type="text" name="postal_code" value="{{$jobPosition->postal_code}}" required>
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="department">Department</label>
						<select class="form-control required select2" name="department">
							<option value="None" {{ $jobPosition->department == 'None'  ? 'selected' : '' }}>None</option>
							<option value="Lorem Ipsum 1" {{ $jobPosition->department == 'Lorem Ipsum 1'  ? 'selected' : '' }}>Lorem Ipsum 1</option>
							<option value="Lorem Ipsum 2" {{ $jobPosition->department == 'None'  ? 'Lorem Ipsum 2' : '' }}>Lorem Ipsum 2</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="employment_type">Employment Type</label>
						<select class="form-control required select2" name="employment_type">
						@if (count($employmentTypes) > 0)
							@foreach($employmentTypes as $employmentType)
							<option value='{{$employmentType->name}}' {{ $jobPosition->employment_type == $employmentType->name  ? 'selected' : '' }}>{{$employmentType->name}}</option>
							@endforeach
						@else
							<option value="None">None</option></option>
						@endif
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="experience_level">Experience Level</label>
						<select class="form-control required select2" name="exp_level">
						@if (count($experienceLevels) > 0)
							@foreach($experienceLevels as $experienceLevel)
							<option value='{{$experienceLevel->name}}' {{ $jobPosition->exp_level == $experienceLevel->name  ? 'selected' : '' }}>{{$experienceLevel->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="job_function">Job Function</label>
						<select class="form-control required select2" name="job_function">
						@if (count($jobFunctions) > 0)
							@foreach($jobFunctions as $jobFunction)
							<option value='{{$jobFunction->name}}' {{ $jobPosition->job_function == $jobFunction->name  ? 'selected' : '' }}>{{$jobFunction->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="education_level">Education Level</label>
						<select class="form-control required select2" name="education_level">	
						@if (count($educationLevels) > 0)
							@foreach($educationLevels as $educationLevel)
							<option value='{{$educationLevel->name}}' {{ $jobPosition->education_level == $educationLevel->name  ? 'selected' : '' }}>{{$educationLevel->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="show_salary">Show Salary</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="show_salary" required>
							<option value="Yes" {{ $jobPosition->show_salary == 'Yes'  ? 'selected' : '' }}>Yes</option>
							<option value="No" {{ $jobPosition->show_salary == 'No'  ? 'selected' : '' }}>No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="currency">Currency</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="currency" required>
							@if(count($currencies) > 0)
								@foreach($currencies as $currency)
								<option value='{{$currency->name}}' {{ $jobPosition->currency == $currency->name  ? 'selected' : '' }}>{{$currency->name}}</option>
								@endforeach
							@else
								<option value="None">None</option>
							@endif
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="salary_min">Salary Min</label>
						<div class="input">
							<p class="placeholder">Enter salary mimimum</p>
							<input class="form-control required" type="text" name="salary_min"  value="{{$jobPosition->salary_min}}">
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="salary_max">Salary Max</label>
						<div class="input">
							<p class="placeholder">Enter salary maximum</p>
							<input class="form-control required" type="text" name="salary_max"   value="{{$jobPosition->salary_max}}">
						</div>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="keywords">Keywords</label>
						<div class="input">
							<p class="placeholder">Enter keywords</p>
							<input class="form-control required" type="text" name="keywords"  value="{{$jobPosition->keywords}}">
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="status">Status</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="status" required>
							<option value="Active" {{ $jobPosition->status == 'Active' ? 'selected' : '' }}>Active</option>
							<option value="On hold" {{ $jobPosition->status == 'On hold' ? 'selected' : '' }}>On Hold</option>
							<option value="Closed" {{ $jobPosition->status == 'Closed' ? 'selected' : '' }}>Closed</option>
						</select>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="closing_date">Closing Date</label>
						<input class="form-control required" type="date" name="closing_date"  value="{{$jobPosition->closing_date}}">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="image">Image</label>
						<input type="file" name="image" class="form-control required">
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label class="mr-2" for="display_type">Display Type</label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="display_type" required>
							<option value="Text Only" {{ $jobPosition->display_type == 'Text Only' ? 'selected' : '' }}>Text Only</option>
							<option value="Image Only" {{ $jobPosition->display_type == 'Image Only' ? 'selected' : '' }}>Image Only</option>
							<option value="Image and Full Text" {{ $jobPosition->display_type == 'Image and Full Text' ? 'selected' : '' }}>Image and Full Text</option>
							<option value="Image and Other Details" {{ $jobPosition->display_type == 'Image and Other Details' ? 'selected' : '' }}>Image and Other Details</option>
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