@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee" required>
				<option value="SocialConz Digital" {{ $overtimeRequest->employee == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee">Category: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="category" required>
				@if(count($overtimeCategories) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($overtimeCategories as $overtimeCategory)
				<option value="{{$overtimeCategory->name}}" {{ $overtimeRequest->category == $overtimeCategory->name  ? 'selected' : '' }}>{{$overtimeCategory->name}}</option>
				@endforeach
				@else 
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="start_time">Start Time: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="datetime-local" name="start_time" value="{{old('start_time') ?? $overtimeRequest->start_time}}" required>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="end_time">End Time: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="datetime-local" name="end_time" value="{{old('end_time') ?? $overtimeRequest->end_time}}" required>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee">Project: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="project" required>
				@if(count($projects) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($projects as $project)
				<option value="{{$project->name}}" {{ $overtimeRequest->project == $project->name  ? 'selected' : '' }}>{{$project->name}}</option>
				@endforeach
				@else 
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="notes">Notes: </label>
			<div class="input">
				<p class="placeholder">Enter notes</p>
				<textarea class="form-control required" name="notes">{{old('notes') ?? $overtimeRequest->notes}}</textarea>
			</div>
		</div>
	</div>
</div>