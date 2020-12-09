@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter holiday name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $holiday->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="holiday_date">Date: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="date" name="holiday_date" value="{{old('holiday_date') ?? $holiday->holiday_date}}" required>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="status" required>
				<option value="Full Day" {{ $holiday->status == 'Full Day'  ? 'selected' : '' }}>Full Day</option>
				<option value="Half Day" {{ $holiday->status == 'Half Day'  ? 'selected' : '' }}>Half Day</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="country">Country: </label>
			<select class="form-control select2" name="country">
				@if(count($countries) > 0)
				<option value="For All Countries" {{ $holiday->country == 'For All Countries'  ? 'selected' : '' }}>For All Countries</option>
				@foreach($countries as $country)
				<option value="{{$country->name}}" {{ $holiday->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
				@endforeach
				@else
				<option value="For All Countries">For All Countries</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="ot_type">Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="ot_type" required>
				<option value="1" {{ $holiday->ot_type == 1  ? 'selected' : '' }}>Regular</option>
				<option value="2" {{ $holiday->ot_type == 2  ? 'selected' : '' }}>Special Non Working</option>
				<option value="3" {{ $holiday->ot_type == 3  ? 'selected' : '' }}>Special Working</option>
			</select>
		</div>
	</div>
</div>