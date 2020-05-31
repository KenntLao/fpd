@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="project">Project: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="project" required>
				@if(count($projects) > 0)
				@foreach($projects as $project)
				<option value="None" {{ $timeProject->project == 'None'  ? 'selected' : '' }}>None</option>
				<option value="{{$project->name}}" {{ $timeProject->project == $project->name  ? 'selected' : '' }}>{{$project->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Details: </label>
			<div class="input">
				<p class="placeholder">Enter project details</p>
				<textarea class="form-control required" name="details">{{old('details') ?? $timeProject->details}}</textarea>
			</div>
		</div>
	</div>
</div>