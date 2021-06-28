@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="job_title_code">Job Title Code: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter job title code</p>
				<input class="form-control required" type="text" name="code" value="{{old('code') ?? $jobTitle->code}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="job_title">Job Title: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter job title</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $jobTitle->name}}" required>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="description">Description: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter description</p>
				<textarea class="form-control required" name="description" required>{{old('description') ?? $jobTitle->description}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="specification">Specification: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter specification</p>
				<textarea class="form-control required" name="specification" required>{{old('specification') ?? $jobTitle->specification}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="job_title">Job Grade</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required" name="job_grade" required>
				<option value="1" {{ $jobTitle->job_grade == 1 ? 'selected' : '' }}>Rank and File</option>
				<option value="2" {{ $jobTitle->job_grade == 2 ? 'selected' : '' }}>Manager</option>
				<option value="3" {{ $jobTitle->job_grade == 3 ? 'selected' : '' }}>Director</option>
			</select>
		</div>
	</div>
</div>