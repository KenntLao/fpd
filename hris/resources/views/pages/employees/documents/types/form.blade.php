@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{ old('name') ?? $type->name }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="notify_expiry">Notify Expiry: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="notify_expiry" required>
				<option disabled default selected>--select one--</option>
				<option value="Yes" {{ $type->notify_expiry == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $type->nofitfy_expiry == 'No' ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="expire_notification_month">Notify Expiry Before One Month: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="expire_notification_month" required>
				<option disabled default selected>--select one--</option>
				<option value="Yes" {{ $type->expire_notification_month == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $type->expire_notification_month == 'No' ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="expire_notification_week">Notify Expiry Before One Week: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="expire_notification_week" required>
				<option disabled default selected>--select one--</option>
				<option value="Yes" {{ $type->expire_notification_week == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $type->expire_notification_week == 'No' ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="expire_notification_day">Notify Expiry Before One Day: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="expire_notification_day" required>
				<option disabled default selected>--select one--</option>
				<option value="Yes" {{ $type->expire_notification_day == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $type->expire_notification_day == 'No' ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Details: </label>
			<div class="input">
				<p class="placeholder">Enter Details</p>
				<textarea class="form-control" name="details">{{ old('details') ?? $type->details }}</textarea>
			</div>
		</div>
	</div>
</div>