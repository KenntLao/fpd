{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - Job Positions')
@section('content_header')
@stop
@section('content')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 form-title">
		<h3>edit job position</h3>
	</div>
	<div class="col-12 offset-md-3 col-md-6 box">
		<div class="form-box">
			<form class="form-horizontal" method="post" action="/pages/recruitment/jobPositions/update/{{$jobPosition->id}}" enctype="multipart/form-data">
				@csrf
				@method('PATCH')
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="job_code">Job Code:</label>
							<input class="form-control" type="text" name="job_code" value="{{$jobPosition->job_code}}" required>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="job_title">Job Title:</label>
							<input class="form-control" type="text" name="job_title" value="{{$jobPosition->job_title}}" required>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="company_name">Company Name:</label>
					<input class="form-control" type="text" name="company_name" value="{{$jobPosition->company_name}}">
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="hiring_manager">Hiring Manager:</label>
							<select class="form-control" name="hiring_manager">
								<option value="{{$jobPosition->hiring_manager}}">{{$jobPosition->hiring_manager}}</option>
								<option value="Not Selected">Not Selected</option>
								<option value="John Doe">John Doe</option>
								<option value="Jane Doe">Jane Doe</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="show_hiring_manager_name">Show Hiring Manager Name:</label>
							<select class="form-control" name="show_hiring_manager_name" required>
								<option value="{{$jobPosition->show_hiring_manager_name}}">{{$jobPosition->show_hiring_manager_name}}</option>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
							</select>
						</div>
					</div>
				</div>
				<div class="form-group">
					<label for="short_description">Short Description:</label>
					<textarea class="form-control" name="short_description" required>{{$jobPosition->short_description}}</textarea>
				</div>
				<div class="form-group">
					<label for="job_description">Job Description:</label>
					<textarea class="form-control" name="job_description" required>{{$jobPosition->job_description}}</textarea>
				</div>
				<div class="form-group">
					<label for="requirements">Requirements:</label>
					<textarea class="form-control" name="requirements">{{$jobPosition->requirements}}</textarea>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="benefits">Benefits:</label>
							@if (count($benefits) > 0)
							<select class="form-control" name="benefits">
								@foreach($benefits as $benefit)
								<option value="None">None</option>
								<option value="{{$benefit->name}}">{{$benefit->name}}</option>
								<option value="{{$jobPosition->benefits}}">{{$jobPosition->benefits}}</option>
								@endforeach
							</select>
							@else
							<select class="form-control" name="benefits">
								<option value="None">None</option>
								<option value="{{$jobPosition->benefits}}">{{$jobPosition->benefits}}</option>
							</select>
							@endif
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="country">Country:</label>
							<select class="form-control" name="country" required>
								@foreach($countries as $country)
								<option value='{{$country->name}}' {{ $jobPosition->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="city">City:</label>
							<input class="form-control" type="text" name="city" value="{{$jobPosition->city}}">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="postal_code">Postal Code:</label>
							<input class="form-control" type="text" name="postal_code" value="{{$jobPosition->postal_code}}">
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="department">Department:</label>
							<select class="form-control" name="department">
								<option value="Selected">Select</option>
								<option value="{{$jobPosition->department}}" selected>{{$jobPosition->department}}</option>
								<option value="Lorem Ipsum 1">Lorem Ipsum 1</option>
								<option value="Lorem Ipsum 2">Lorem Ipsum 2</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="employment_type">Employment Type:</label>
							@if (count($employmentTypes) > 0)
							<select class="form-control" name="employment_type">
								@foreach($employmentTypes as $employmentType)
								<option value="None">None</option>
								<option value='{{$employmentType->name}}' {{ $jobPosition->employment_type == $employmentType->name  ? 'selected' : '' }}>{{$employmentType->name}}</option>
								@endforeach
							</select>
							@else
							<select class="form-control" name="employment_type">
								<option value="None">None</option></option>
							</select>
							@endif
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="experience_level">Experience Level:</label>
							@if (count($experienceLevels) > 0)
							<select class="form-control" name="exp_level">
								@foreach($experienceLevels as $experienceLevel)
								<option value="None">None</option>
								<option value='{{$experienceLevel->name}}' {{ $jobPosition->exp_level == $experienceLevel->name  ? 'selected' : '' }}>{{$experienceLevel->name}}</option>
								@endforeach
							</select>
							@else
							<select class="form-control" name="exp_level">
								<option value="None">None</option>
							</select>
							@endif
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="job_function">Job Function:</label>
							@if (count($jobFunctions) > 0)
							<select class="form-control" name="job_function">
								@foreach($jobFunctions as $jobFunction)
								<option value="None">None</option>
								<option value='{{$jobFunction->name}}' {{ $jobPosition->job_function == $jobFunction->name  ? 'selected' : '' }}>{{$jobFunction->name}}</option>
								@endforeach
							</select>
							@else
							<select class="form-control" name="job_function">
								<option value="None">None</option>
							</select>
							@endif
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="education_level">Education Level:</label>
							@if (count($educationLevels) > 0)
							<select class="form-control" name="education_level">
								@foreach($educationLevels as $educationLevel)
								<option value="None">None</option>
								<option value='{{$educationLevel->name}}' {{ $jobPosition->education_level == $educationLevel->name  ? 'selected' : '' }}>{{$educationLevel->name}}</option>
								@endforeach
							</select>
							@else
							<select class="form-control" name="education_level">
								<option value="None">None</option>
							</select>
							@endif
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="show_salary">Show Salary:</label>
							<select class="form-control" name="show_salary" required>
								<option value="Yes">Yes</option>
								<option value="No">No</option>
								<option value="{{$jobPosition->show_salary}}" selected>{{$jobPosition->show_salary}}</option>
							</select>
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="currency">Currency:</label>
							<select class="form-control" name="currency" required>
								@foreach($currencies as $currency)
								<option value='{{$currency->name}}' {{ $jobPosition->currency == $currency->name  ? 'selected' : '' }}>{{$currency->name}}</option>
								@endforeach
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="salary_min">Salary Min:</label>
							<input class="form-control" type="text" name="salary_min"  value="{{$jobPosition->salary_min}}">
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="salary_max">Salary Max:</label>
							<input class="form-control" type="text" name="salary_max"   value="{{$jobPosition->salary_max}}">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="keywords">Keywords:</label>
							<input class="form-control" type="text" name="keywords"  value="{{$jobPosition->keywords}}">
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="status">Status:</label>
							<select class="form-control" name="status">
								<option value="Active">Active</option>
								<option value="On hold">On Hold</option>
								<option value="Closed">Closed</option>
								<option value="{{$jobPosition->status}}" selected>{{$jobPosition->status}}</option>
							</select>
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="closing_date">Closing Date:</label>
							<input class="form-control" type="date" name="closing_date"  value="{{$jobPosition->closing_date}}">
						</div>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-6">
						<div class="form-group">
							<label for="image">Image:</label>
							<input type="file" name="image" class="form-control">
						</div>
					</div>
					<div class="col-6">
						<div class="form-group">
							<label for="display_type">Display Type:</label>
							<select class="form-control" name="display_type" required>
								<option value="Text Only">Text Only</option>
								<option value="Image Only">Image Only</option>
								<option value="Image and Full Text">Image and Full Text</option>
								<option value="Image and Other Details">Image and Other Details</option>
								<option value="{{$jobPosition->display_type}}" selected>{{$jobPosition->display_type}}</option>
							</select>
						</div>
					</div>
				</div>
				<a href="/pages/recruitment/jobPositions/index">Back</a>
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
console.log('Hi!');
</script>
@stop