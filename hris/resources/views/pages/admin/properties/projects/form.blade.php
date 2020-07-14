@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $project->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="client">Client: </label>
			<select class="form-control required select2" name="client_id">
				@if (count($clients) > 0)
				<option disabled default selected>--select one--</option>
				<option value="" {{ $project->client_id == NULL  ? 'selected' : '' }}>None</option>
				@foreach($clients as $client)
				<option value="{{$client->id}}" {{ $project->client_id == $client->id  ? 'selected' : '' }}>{{$client->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				<option value="" {{ $project->client_id == NULL  ? 'selected' : '' }}>None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="status" required>
				<option value="Active" {{ $project->status == 'Active'  ? 'selected' : '' }}>Active</option>
				<option value="On Hold" {{ $project->status == 'On Hold'  ? 'selected' : '' }}>On Hold</option>
				<option value="Completed" {{ $project->status == 'Completed'  ? 'selected' : '' }}>Completed</option>
				<option value="Dropped" {{ $project->status == 'Dropped'  ? 'selected' : '' }}>Dropped</option>
			</select>
		</div>
	</div>
</div>
<div class="form-group">
	<label class="mr-2" for="details">Details: </label>
	<div class="input">
		<p class="placeholder">Enter details</p>
		<textarea class="form-control required" name="details">{{old('details') ?? $project->details}}</textarea>
	</div>
</div>