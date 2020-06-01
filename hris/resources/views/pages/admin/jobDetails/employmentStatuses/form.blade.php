@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Employment Status: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter employment status</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $employmentStatus->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="description">Description: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter description</p>
				<textarea class="form-control required" name="description" required>{{old('description') ?? $employmentStatus->description}}</textarea>
			</div>
		</div>
	</div>
</div>