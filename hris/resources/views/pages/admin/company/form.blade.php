@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="text" value="{{old('name') ?? $company->name}}" name="name" required>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="details">Details: </label>
			<span class="badge badge-danger">Required</span>
			<textarea class="form-control required" name="details"required>{{old('details') ?? $company->details}}</textarea>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="name">Address: </label>
			<textarea class="form-control required" name="address">{{old('address') ?? $company->address}}</textarea>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="type">Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="type" required>
					<option disabled default selected>--select one--</option>
					<option value="Company">Company</option>
					<option value="Head Office">Head Office</option>
					<option value="Regional Office">Regional Office</option>
					<option value="Department">Department</option>
					<option value="Unit">Unit</option>
					<option value="Sub Unit">Sub Unit</option>
					<option value="Other">Other</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="country">Country: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="country" required>
				@if(count($countries) > 0)
					<option disabled default selected>--select one--</option>
					@foreach($countries as $country)
					<option value='{{$country->name}}' {{ $company->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
					@endforeach
				@else
					<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="timezone">Time Zone: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="timezone" required>
				@if(count($timezones) > 0)
					<option disabled default selected>--select one--</option>
					@foreach($timezones as $timezone)
					<option value="{{$timezone->name}}" {{ $company->timezone == $timezone->name  ? 'selected' : '' }}>{{$timezone->utc}} {{$timezone->name}}</option>
					@endforeach
				@else
					<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="type">Parent Structure: </label>
			<select class="form-control select2" name="parent_structure">
			@if (count($companies) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($companies as $company_structure)
				<option value="{{$company_structure->name}}" {{ $company->parent_structure == $company_structure->name  ? 'selected' : '' }}>{{$company_structure->name}}</option>
				@endforeach
			</select>
			@else
				<option disabled default selected>--select one--</option>
			@endif
			</select>
		</div>
	</div>
</div>