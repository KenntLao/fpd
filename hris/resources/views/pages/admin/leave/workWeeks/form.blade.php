@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="day">Day: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="day" required>
				<option value="Monday" {{ $workWeek->day == 'Monday'  ? 'selected' : '' }}>Monday</option>
				<option value="Tuesday" {{ $workWeek->day == 'Tuesday'  ? 'selected' : '' }}>Tuesday</option>
				<option value="Wednesday" {{ $workWeek->day == 'Wednesday'  ? 'selected' : '' }}>Wednesday</option>
				<option value="Thursday" {{ $workWeek->day == 'Thursday'  ? 'selected' : '' }}>Thursday</option>
				<option value="Friday" {{ $workWeek->day == 'Friday'  ? 'selected' : '' }}>Friday</option>
				<option value="Saturday" {{ $workWeek->day == 'Saturday'  ? 'selected' : '' }}>Saturday</option>
				<option value="Sunday" {{ $workWeek->day == 'Sunday'  ? 'selected' : '' }}>Sunday</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="status" required>
				<option value="Full Day" {{ $workWeek->status == 'Full Day'  ? 'selected' : '' }}>Full Day</option>
				<option value="Half Day" {{ $workWeek->status == 'Half Day'  ? 'selected' : '' }}>Half Day</option>
				<option value="Non-working Day" {{ $workWeek->status == 'Non-working Day'  ? 'selected' : '' }}>Non-working Day</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="country">Country: </label>
			<select class="form-control select2" name="country">
				@if(count($countries) > 0)
				<option value="For All Countries" {{ $workWeek->country == 'For All Countries'  ? 'selected' : '' }}>For All Countries</option>
				@foreach($countries as $country)
				<option value="{{$country->name}}" {{ $workWeek->country == $country->name  ? 'selected' : '' }}>{{$country->name}}</option>
				@endforeach
				@else
				<option value="For All Countries">For All Countries</option>
				@endif
			</select>
		</div>
	</div>
</div>