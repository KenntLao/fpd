@csrf
<div class="row">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="job_code">Job Code: </label>
			<span class="badge right badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter job code</p>
				<input class="form-control required" type="text" name="job_code" value="{{old('job_code') ?? $jobPosition->job_code}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="job_title">Job Title: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter job title</p>
				<input class="form-control required" type="text" name="job_title" value="{{old('job_title') ?? $jobPosition->job_title}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="company_name">Company Name: </label>
			<div class="input">
				<p class="placeholder">Enter company name</p>
				<input class="form-control required" type="text" name="company_name" value="{{old('company_name') ?? $jobPosition->company_name}}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-5">
		<div class="form-group">
			<label class="mr-2" for="hiring_manager">Hiring Manager: </label>
			<select class="form-control required select2" name="hiring_manager">
				<option value="Not selected" {{ $jobPosition->hiring_manager == 'Not Selected'  ? 'selected' : '' }}>Not selected</option>
				<option value="John Doe" {{ $jobPosition->hiring_manager == 'John Doe'  ? 'selected' : '' }}>John Doe</option>
				<option value="Jane Doe" {{ $jobPosition->hiring_manager == 'Jane Doe'  ? 'selected' : '' }}>Jane Doe</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-5">
		<div class="form-group">
			<label class="mr-2" for="show_hiring_manager_name">Show Hiring Manager Name: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="show_hiring_manager_name" required>
				<option value="Yes" {{ $jobPosition->show_hiring_manager_name == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $jobPosition->show_hiring_manage_name == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="short_description">Short Description: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter short description</p>
				<textarea class="form-control required" name="short_description" required>{{old('short_description') ?? $jobPosition->short_description}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="job_description">Job Description: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter job description</p>
				<textarea class="form-control required" name="job_description" required>{{old('job_description') ?? $jobPosition->job_description}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="requirements">Requirements: </label>
			<div class="input">
				<p class="placeholder">Enter requirements</p>
				<textarea class="form-control required" name="requirements">{{old('requirements') ?? $jobPosition->requirements}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-3">
		<div class="form-group">
			<label class="mr-2" for="benefits">Benefits: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="benefit_id" required>
				@if(count($benefits) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($benefits as $benefit)
				<option value="{{$benefit->id}}" {{ $jobPosition->benefit_id == $benefit->id  ? 'selected' : '' }}>{{$benefit->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-3">
		<div class="form-group">
			<label class="mr-2" for="country">Country: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="country" required>
				@if(count($countries) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($countries as $country)
				<option value='{{$country->name}}' {{ $jobPosition->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="city">City: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter city</p>
				<input class="form-control required" type="text" name="city" value="{{old('city') ?? $jobPosition->city}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="postal_code">Postal Code: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter postal code</p>
				<input class="form-control required" type="text" name="postal_code" value="{{old('postal_code') ?? $jobPosition->postal_code}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="department">Department: </label>
			<select class="form-control required select2" name="department_id">
				@if(count($departments) > 0)
				<option value="None" {{ $jobPosition->department_id == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($departments as $department)
				<option value="{{$department->id}}" {{ $jobPosition->department_id == $department->id  ? 'selected' : '' }}>{{$department->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="employment_type">Employment Type: </label>
			<select class="form-control required select2" name="employment_type_id">
				@if(count($employmentTypes) > 0)
				<option value="None" {{ $jobPosition->employment_type_id == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($employmentTypes as $employmentType)
				<option value="{{$employmentType->id}}" {{ $jobPosition->employment_type_id == $employmentType->id  ? 'selected' : '' }}>{{$employmentType->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="experience_level">Experience Level: </label>
			<select class="form-control required" name="exp_level_id">
				@if (count($experienceLevels) > 0)
				<option value="None" {{ $jobPosition->exp_level_id == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($experienceLevels as $experienceLevel)
				<option value="{{$experienceLevel->id}}" {{ $jobPosition->exp_level_id == $experienceLevel->id  ? 'selected' : '' }}>{{$experienceLevel->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="job_function">Job Function: </label>
			<select class="form-control required" name="job_function_id">
				@if (count($jobFunctions) > 0)
				<option value="None" {{ $jobPosition->job_function_id == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($jobFunctions as $jobFunction)
				<option value="{{$jobFunction->id}}" {{ $jobPosition->job_function_id == $jobFunction->id  ? 'selected' : '' }}>{{$jobFunction->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="education_level">Education Level: </label>
			<select class="form-control required" name="education_level_id">
				@if (count($educationLevels) > 0)
				<option value="None" {{ $jobPosition->education_level_id == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($educationLevels as $educationLevel)
				<option value="{{$educationLevel->id}}" {{ $jobPosition->education_level_id == $educationLevel->id  ? 'selected' : '' }}>{{$educationLevel->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="show_salary">Show Salary: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required" name="show_salary" required>
				<option value="Yes" {{ $jobPosition->show_salary == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $jobPosition->show_salary == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="currency">Currency: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required" name="currency" required>
				@if(count($currencies) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($currencies as $currency)
				<option value='{{$currency->name}}' {{ $jobPosition->currency == $currency->name  ? 'selected' : '' }}>{{$currency->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="salary_min">Salary Min: </label>
			<div class="input">
				<p class="placeholder">Enter salary minimum</p>
				<input class="form-control required" type="text" name="salary_min" value="{{old('salary_min' ?? $jobPosition->salary_min)}}">
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="salary_max">Salary Max: </label>
			<div class="input">
				<p class="placeholder">Enter salary maximum</p>
				<input class="form-control required" type="text" name="salary_max" value="{{old('salary_max') ?? $jobPosition->salary_max}}">
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="keywords">Keywords: </label>
			<div class="input">
				<p class="placeholder">Enter keywords</p>
				<input class="form-control required" type="text" name="keywords" value="{{old('keywords') ?? $jobPosition->keywords}}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required" name="status" required>
				<option value="Active" {{ $jobPosition->status == 'Active'  ? 'selected' : '' }}>Active</option>
				<option value="On Hold" {{ $jobPosition->status == 'On Hold'  ? 'selected' : '' }}>On Hold</option>
				<option value="Closed"  {{ $jobPosition->status == 'Closed'  ? 'selected' : '' }}>Closed</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="closing_date">Closing Date: </label>
			<input class="form-control required" type="date" name="closing_date" value="{{old('closing_date') ?? $jobPosition->closing_date}}">
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="image">Image: </label>
			<input type="file" name="image" class="form-control required">
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="display_type">Display Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required" name="display_type" required>
				<option value="Text Only" {{ $jobPosition->display_type == 'Text Only'  ? 'selected' : '' }}>Text Only</option>
				<option value="Image Only" {{ $jobPosition->display_type == 'Image Only'  ? 'selected' : '' }}>Image Only</option>
				<option value="Image and Full Text" {{ $jobPosition->display_type == 'Image and Full Text'  ? 'selected' : '' }}>Image and Full Text</option>
				<option value="Image and Other Details" {{ $jobPosition->display_type == 'Image and Other Details'  ? 'selected' : '' }}>Image and Other Details</option>
			</select>
		</div>
	</div>
</div>