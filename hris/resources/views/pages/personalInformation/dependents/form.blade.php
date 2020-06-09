@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{ old('name') ?? $dependent->name }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="relationship">Relationship: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="relationship" required>
				<option value="Child" {{ $dependent->relationship == 'Child'  ? 'selected' : '' }}>Child</option>
				<option value="Spouse" {{ $dependent->relationship == 'Spouse'  ? 'selected' : '' }}>Spouse</option>
				<option value="Parent" {{ $dependent->relationship == 'Parent'  ? 'selected' : '' }}>Parent</option>
				<option value="Other" {{ $dependent->relationship == 'Other'  ? 'selected' : '' }}>Other</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="dependent">Date of Birth: </label>
			<input class="form-control" type="date" name="birthday" value="{{ old('birthday') ?? $dependent->birthday }}">
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="id_number">Id Number: </label>
			<div class="input">
				<p class="placeholder">Enter Id Number</p>
				<input class="form-control" type="text" name="id_number" value="{{ old('id_number') ?? $dependent->id_number }}">
			</div>
		</div>
	</div>
</div>