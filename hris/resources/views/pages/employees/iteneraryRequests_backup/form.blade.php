<div class="row">
	<div class="col-12 col-sm-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="travel_from">Travel From: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter location</p>
				<input class="form-control required" type="text" name="travel_from" value="{{old('travel_from') ?? $iteneraryRequest->travel_from}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="travel_to">Travel To: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter location</p>
				<input class="form-control required" type="text" name="travel_to" value="{{old('travel_from') ?? $iteneraryRequest->travel_to}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="travel_date">Travel Date: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required travel_date" type="text" name="travel_date" value="{{old('travel_from') ?? $iteneraryRequest->travel_date}}" required>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="return_date">Return Date: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required travel_date" type="text" name="return_date" value="{{old('travel_from') ?? $iteneraryRequest->return_date}}" required>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="transportation">Transportation: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="transportation" required>
				<option disabled default selected>--select one--</option>
				<option value="Plane" {{$iteneraryRequest->transportation == 'Plane' ? 'selected' : ''}}>Plane</option>
				<option value="Rail" {{$iteneraryRequest->transportation == 'Rail' ? 'selected' : ''}}>Rail</option>
				<option value="Taxi" {{$iteneraryRequest->transportation == 'Taxi' ? 'selected' : ''}}>Taxi</option>
				<option value="Own Vehicle" {{$iteneraryRequest->transportation == 'Own Vehicle' ? 'selected' : ''}}>Own Vehicle</option>
				<option value="Rented Vehicle" {{$iteneraryRequest->transportation == 'Rented Vehicle' ? 'selected' : ''}}>Rented Vehicle</option>
				<option value="Other" {{$iteneraryRequest->transportation == 'Other' ? 'selected' : ''}}>Other</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="currency_id">Currency: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="currency_id" required>
				@if(count($currencies) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($currencies as $currency)
				<option value="{{$currency->id}}" {{$currency->id == $iteneraryRequest->currency_id ? 'selected' : ''}}>{{$currency->name}} ({{$currency->code}})</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-sm-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="total_funding_proposed">Total Funding Proposed: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter amount</p>
				<input class="form-control required" type="text" name="total_funding_proposed" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required maxlength="13" value="{{old('total_funding_proposed') ?? $iteneraryRequest->total_funding_proposed}}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-6">
		<div class="form-group">
			<label for="notes">Notes: </label>
			<div class="input">
				<p class="placeholder">Enter notes</p>
				<textarea class="form-control" name="notes">{{old('notes') ?? $iteneraryRequest->notes}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-sm-6">
		<div class="form-group">
			<label class="mr-2" for="purpose">Purpose: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter purpose</p>
				<textarea class="form-control required" name="purpose" required>{{old('purpose') ?? $iteneraryRequest->purpose}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-sm-4">
		<div class="form-group">
			<label for="attachment_1">Attachment #1: </label>
			<input class="form-control" type="file" name="attachment_1">
		</div>
	</div>
	<div class="col-12 col-sm-4">
		<div class="form-group">
			<label for="attachment_2">Attachment #2: </label>
			<input class="form-control" type="file" name="attachment_2">
		</div>
	</div>
	<div class="col-12 col-sm-4">
		<div class="form-group">
			<label for="attachment_3">Attachment #3: </label>
			<input class="form-control" type="file" name="attachment_3">
		</div>
	</div>
</div>