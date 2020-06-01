@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $client->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="details">Details: </label>
			<div class="input">
				<p class="placeholder">Enter details</p>
				<textarea class="form-control required" name="details">{{old('details') ?? $client->details}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="details">Address: </label>
			<div class="input">
				<p class="placeholder">Enter address</p>
				<textarea class="form-control required" name="address">{{old('address') ?? $client->address}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="contact_number">Contact Number: </label>
			<div class="input">
				<p class="placeholder">Enter contact number</p>
				<input class="form-control required" type="text" name="contact_number" value="{{old('contact_number') ?? $client->contact_number}}">
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="email">Contact Email: </label>
			<div class="input">
				<p class="placeholder">Enter email address</p>
				<input class="form-control required" type="email" name="email" value="{{old('email') ?? $client->email}}">
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="company_url">Company URL: </label>
			<div class="input">
				<p class="placeholder">Enter company URL</p>
				<input class="form-control required" type="text" name="company_url" value="{{old('company_url') ?? $client->company_url}}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="status" required>
				<option value="Active" {{ $client->status == 'Active'  ? 'selected' : '' }}>Active</option>
				<option value="Inactive" {{ $client->status == 'Inactive'  ? 'selected' : '' }}>Inactive</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="first_contact_date">First Contact Date: </label>
			<input class="form-control required" type="date" name="first_contact_date" value="{{old('first_contact_date') ?? $client->first_contact_date}}">
		</div>
	</div>
</div>