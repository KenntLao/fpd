@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Asset Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter asset name</p>
				<input class="form-control required" type="text" name="name" value="{{ old('name') ?? $type->name }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="description">Description: </label>
			<div class="input">
				<p class="placeholder">Enter asset name</p>
				<textarea class="form-control" name="description">{{ old('description') ?? $type->description }}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="attachment">Attachment: </label>
			<input class="form-control" type="file" name="attachment">
		</div>
	</div>
</div>