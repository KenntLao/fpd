@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $leaveGroup->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="mr-2" for="job_title">Job Title</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select-job-title" name="job_title[]" multiple="multiple" required>
				@if(count($job_titles) > 0)
				@foreach($job_titles as $job_title)
				<option value="{{$job_title->id}}" {{in_array($job_title->id, $job_title_ids) ? 'selected' : ''}}>
					{{$job_title->name}}
				</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Details: </label>
			<div class="input">
				<p class="placeholder">Enter details</p>
				<textarea class="form-control" name="details">{{old('details') ?? $leaveGroup->details}}</textarea>
			</div>
		</div>
	</div>
</div>