@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee" required>
				<option value="SocialConz Digital" {{ $employeeProject->employee == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="project">Project: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="project" required>
				@if (count($projects) > 0)
				<option value="None"{{ $employeeProject->project == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($projects as $project)
				<option value="{{$project->name}}" {{ $employeeProject->project == $project->name  ? 'selected' : '' }}>{{$project->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="details">Details: </label>
			<div class="input">
				<p class="placeholder">Enter details</p>
				<textarea class="form-control required" name="details">{{old('detials') ?? $employeeProject->details}}</textarea>
			</div>
		</div>
	</div>
</div>