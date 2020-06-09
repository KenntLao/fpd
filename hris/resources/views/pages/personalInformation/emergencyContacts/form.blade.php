@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{ old('name') ?? $emergency->name }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="relationship">Relationship: </label>
			<div class="input">
				<p class="placeholder">Enter relationship</p>
				<input class="form-control" type="text" name="relationship" value="{{ old('relationship') ?? $emergency->relationship }}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="home_phone">Home Phone: </label>
			<div class="input">
				<p class="placeholder">Enter home phone</p>
				<input class="form-control" type="text" name="home_phone" value="{{ old('home_phone') ?? $emergency->home_phone }}">
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="work_phone">Work Phone: </label>
			<div class="input">
				<p class="placeholder">Enter work phone</p>
				<input class="form-control" type="text" name="work_phone" value="{{ old('work_phone') ?? $emergency->work_phone }}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="mobile_phone">Mobile Phone: </label>
			<div class="input">
				<p class="placeholder">Enter mobile phone</p>
				<input class="form-control" type="text" name="mobile_phone" value="{{ old('mobile_phone') ?? $emergency->mobile_phone }}">
			</div>
		</div>
	</div>
</div>