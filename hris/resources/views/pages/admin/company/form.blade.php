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
				@if(count($types) > 0)
					<option value="None" {{ $company->type == 'None'  ? 'selected' : '' }}>None</option>
					@foreach($types as $type)
					<option value='{{$type->name}}' {{ $company->type == $type->name  ? 'selected' : '' }}>{{$type->name}}</option>
					@endforeach
				@else
					<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="country">Country: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="country" required>
				@if(count($countries) > 0)
					<option value="None" {{ $company->country == 'None'  ? 'selected' : '' }}>None</option>
					@foreach($countries as $country)
					<option value='{{$country->name}}' {{ $company->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
					@endforeach
				@else
					<option value="None">None</option>
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
					<option value="None" {{ $company->timezone == 'None'  ? 'selected' : '' }}>None</option>
					@foreach($timezones as $timezone)
					<option value="{{$timezone->name}}" {{ $company->timezone == $timezone->name  ? 'selected' : '' }}>{{$timezone->utc}} {{$timezone->name}}</option>
					@endforeach
				@else
					<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="type">Parent Structure: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="parent_structure">
			@if (count($companies) > 0)
				<option value="None" {{ $company->parent_structure == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($companies as $company_structure)
				<option value="{{$company_structure->name}}" {{ $company->parent_structure == $company_structure->name  ? 'selected' : '' }}>{{$company_structure->name}}</option>
				@endforeach
			</select>
			@else
				<option value="None">None</option>
			@endif
			</select>
		</div>
	</div>
</div>