@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="name">Pay Grade Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter pay grade</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $payGrade->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="currency">Currency: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="currency" required>
				<option value="Philippine Peso" selected>Philippine Peso</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="min_salary">Min Salary: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter minimum salary</p>
				<input class="form-control required" type="text" name="min_salary" value="{{old('min_salary') ?? $payGrade->min_salary}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="max_salary">Max Salary: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter maximum salary</p>
				<input class="form-control required" type="text" name="max_salary" value="{{old('max_salary') ?? $payGrade->max_salary}}" required>
			</div>
		</div>
	</div>
</div>