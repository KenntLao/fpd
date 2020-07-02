@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				@if (count($employees) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $employeeProject->employee_id == $employee->id  ? 'selected' : '' }}>{{$employee->firstname}} {{$employee->lastname}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="project">Project: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="project_id" required>
				@if (count($projects) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($projects as $project)
				<option value="{{$project->id}}" {{ $employeeProject->project_id == $project->id  ? 'selected' : '' }}>{{$project->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
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