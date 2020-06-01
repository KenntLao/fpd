@csrf
<div class="row no-gutters">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="code">Code: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter course code</p>
				<input class="form-control required" type="text" name="code" value="{{old('code') ?? $course->code}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter course name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $course->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="coordinator">Coordinator: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="coordinator" required>
				<option value="SocialConz Digital" {{ $course->coordinator == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="trainer">Trainer: </label>
			<div class="input">
				<p class="placeholder">Enter trainer name</p>
				<input class="form-control required" type="text" name="trainer" value="{{old('trainer') ?? $course->trainer}}">
			</div>
		</div>
	</div>
</div>
<div class="row no-gutters">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="trainer_details">Trainer Details: </label>
			<div class="input">
				<p class="placeholder">Enter trainer details</p>
				<textarea class="form-control required" name="trainer_details">{{old('trainer_details') ?? $course->trainer_details}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="payment_type">Payment Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="payment_type" required>
				<option value="Company Sponsored" {{ $course->payment_type == 'Company Sponsored'  ? 'selected' : '' }}>Company Sponsored</option>
				<option value="Paid by Employee" {{ $course->payment_type == 'Paid by Employee'  ? 'selected' : '' }}>Paid by Employee</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="currency">Currency: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="currency" required>
				<option value="Philippine Peso" {{ $course->currency == 'Philippine Peso'  ? 'selected' : '' }}>Philippine Peso</option>
			</select>
		</div>
	</div>
</div>
<div class="row no-gutters">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="cost">Cost: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter cost</p>
				<input class="form-control required" type="text" name="cost" value="{{old('cost') ?? $course->cost}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="status" required>
				<option value="Active" {{ $course->status == 'Active'  ? 'selected' : '' }}>Active</option>
				<option value="Inactive" {{ $course->status == 'Inactive'  ? 'selected' : '' }}>Inactive</option>
			</select>
		</div>
	</div>
</div>