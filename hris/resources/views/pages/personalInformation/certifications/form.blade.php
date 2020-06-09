@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="certification_id">Qualifications: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="certification_id" required>
				@if (count($certifications) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($certifications as $certification)
				<option value="{{$certification->id}}" {{ $employeeCertification->certification_id == $certification->id  ? 'selected' : '' }}>{{$certification->name}}</option>
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
				<input class="form-control required" type="text" name="institute" value="{{ old('institute') ?? $employeeCertification->institute }}" required>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="education_id">Granted On: </label>
			<input class="form-control" type="date" name="granted_on" value="{{ old('granted_on') ?? $employeeCertification->granted_on }}">
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Valid Thru: </label>
			<input class="form-control" type="date" name="valid_thru" value="{{ old('valid_thru') ?? $employeeCertification->valid_thru }}">
		</div>
	</div>
</div>