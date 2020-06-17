@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_id">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				@if(count($employees) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $document->employee_id == $employee->id ? 'selected' : '' }}>{{ $employee->firstname }} {{ $employee->lastname }}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="type_id">Document: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="type_id" required>
				@if(count($types) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($types as $type)
				<option value="{{$type->id}}" {{ $document->type_id == $type->id ? 'selected' : '' }}>{{ $type->name }}</option>
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
			<label class="mr-2" for="date_added">Date Added: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="date" name="date_added" value="{{ old('date_added') ?? $document->date_added }}" required>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="date_added">Valid Until: </label>
			<input class="form-control" type="date" name="valid_until" value="{{ old('valid_until') ?? $document->valid_until }}">
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="status">Status</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="status" required>
				<option disabled default selected>--select one--</option>
				<option value="Active" {{ $document->status == 'Active' ? 'selected' : '' }}>Active</option>
				<option value="Inactive" {{ $document->status == 'Inactive' ? 'selected' : '' }}>Inactive</option>
				<option value="Draft" {{ $document->status == 'Draft' ? 'selected' : '' }}>Draft</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Details</label>
			<div class="input">
				<p class="placeholder">Enter details</p>
				<textarea class="form-control" name="details">{{ old('details') ?? $document->details }}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="attachment">Attachment: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="file" name="attachment" required>
		</div>
	</div>
</div>