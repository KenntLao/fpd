@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-6">
		<div class="form-group">
			<label class="mr-2" for="name">Department Code: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="text" value="{{old('department_code') ?? $department->department_code}}" name="department_code" required>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-6">
		<div class="form-group">
			<label class="mr-2" for="name">Department Name: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="text" value="{{old('department_name') ?? $department->department_name}}" name="department_name" required>
		</div>
	</div>
</div>