@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="education_id">Qualifications: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="education_id" required>
				@if (count($educations) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($educations as $education)
				<option value="{{$education->id}}" {{ $employeeEducation->education_id == $education->id  ? 'selected' : '' }}>{{$education->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Institute: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter institute</p>
				<input class="form-control required" type="text" name="institute" value="{{ old('institute') ?? $employeeEducation->institute }}" required>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="education_id">Start Date: </label>
			<input class="form-control" type="date" name="start_date" value="{{ old('start_date') ?? $employeeEducation->start_date }}">
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Completed On: </label>
			<input class="form-control" type="date" name="completed" value="{{ old('completed') ?? $employeeEducation->completed }}">
		</div>
	</div>
</div>