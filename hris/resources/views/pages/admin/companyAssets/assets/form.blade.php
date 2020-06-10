@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="code">Code: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter code</p>
				<input class="form-control required" type="text" name="code" value="{{ old('code') ?? $asset->code }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="type_id">Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="type_id" required>
				@if(count($types) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($types as $type)
				<option value="{{$type->id}}" {{ $asset->type_id == $type->id  ? 'selected' : '' }}>{{$type->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_id">Employee: </label>
			<select class="form-control select2" name="employee_id">
				@if(count($employees) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $asset->employee_id == $employee->id  ? 'selected' : '' }}>{{$employee->firstname}} {{$employee->lastname}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="department_id">Department: </label>
			<select class="form-control select2" name="department_id">
				@if(count($departments) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($departments as $department)
				<option value="{{$department->id}}" {{ $asset->department_id == $department->id  ? 'selected' : '' }}>{{$department->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
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
				<textarea class="form-control required" name="description">{{ old('description') ?? $asset->description }}</textarea>
			</div>
		</div>
	</div>
</div>