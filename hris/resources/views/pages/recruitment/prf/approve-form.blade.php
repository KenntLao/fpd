@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="first_name">Control No: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Control No.</p>
				<input class="form-control required" name="control_no" type="text" required value="{{old('control_no') ?? $prf->control_no}}" />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="first_name">Education: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Education</p>
				<textarea class="form-control required" name="education" required>{{$prf->education ?? ''}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="first_name">Work Experience: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Work Experience</p>
				<textarea class="form-control required" name="work_exp" required>{{$prf->work_exp ?? ''}}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="first_name">Skills: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Skills</p>
				<textarea class="form-control required" name="skills" required>{{$prf->skills ?? ''}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-12">
		<div class="form-group">
			<label class="mr-2" for="first_name">Duty Description: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Duty Description</p>
				<textarea rows="4" class="form-control required" name="duty_desc" required>{{$prf->duty_desc ?? ''}}</textarea>
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="gender">Reason: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="reason" required>
				<option default hidden disabled selected>-- Choose Reason --</option>
				<option {{ $prf->reason == 'Replacement of Reisgnation'  ? 'selected' : '' }}>Replacement of Reisgnation</option>
				<option {{ $prf->reason == 'Replacement of Pull-out'  ? 'selected' : '' }}>Replacement of Pull-out</option>
				<option {{ $prf->reason == 'New/Additional'  ? 'selected' : '' }}>New/Additional</option>
				<option {{ $prf->reason == 'Reliever'  ? 'selected' : '' }}>Reliever</option>
				<option {{ $prf->reason == 'Others'  ? 'selected' : '' }}>Others</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="gender">Job Position: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="job_title_id" required>
				<option default hidden disabled selected>-- Choose Job Position --</option>
				@foreach($job_titles as $job_title)
					<option value="{{$job_title->id}}" @if($prf->job_title_id == $job_title->id) selected @endif>{{$job_title->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="basic_rate">Basic Rate (PHP): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Basic Rate (PHP)</p>
				<input class="form-control required" name="basic_rate" type="number" required value="{{old('basic_rate') ?? $prf->basic_rate}}" />
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="allowance">Allowance: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Allowance (PHP)</p>
				<input class="form-control required" name="allowance" type="number" required value="{{old('allowance') ?? $prf->allowance}}" />
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="gender">Project Based: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="project_based" id="project_based" required>
				<option value="0" default selected>No</option>
				<option value="As per Contract" {{ $prf->project_based == 'As per Contract'  ? 'selected' : '' }}>As per Contract</option>
				<option value="As per Actual: Retained Existing Rate/Budget" {{ $prf->project_based == 'As per Actual: Retained Existing Rate/Budget'  ? 'selected' : '' }}>As per Actual: Retained Existing Rate/Budget</option>
				<option value="As per Actual: With variance on rate" {{ $prf->project_based == 'As per Actual: With variance on rate'  ? 'selected' : '' }}>As per Actual: With variance on rate</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="gender">CMO Based: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" id="cmo_based" name="cmo_based" required>
				<option value="0" default selected>No</option>
				<option value="With Available Approved Budget" {{ $prf->cmo_based == 'With Available Approved Budget'  ? 'selected' : '' }}>With Available Approved Budget</option>
				<option value="No Available Approved Budget" {{ $prf->cmo_based == 'No Available Approved Budget'  ? 'selected' : '' }}>No Available Approved Budget</option>
			</select>
		</div>
	</div>
</div>

<div class="row" id="cmo_based_remarks">
	<div class="col-12 col-md-6 col-xl-5">
		<div class="form-group">
			<label class="mr-2" for="client_approval_file">Remarks </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="text" name="cmo_remarks" value="{{old('cmo_remarks') ?? $prf->cmo_remarks}}">
		</div>
	</div>
</div>

<div class="row" id="project_based_file">
	<div class="col-12 col-md-6 col-xl-5">
		<div class="form-group">
			<label class="mr-2" for="client_approval_file">Client’s Approval on increase/decrease Attachment: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="file" name="client_approval_file">
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-5">
		<div class="form-group">
			<label class="mr-2" for="labor_approval_file">Approved Labor cost from Operations Department Attachment: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="file" name="labor_approval_file">
		</div>
	</div>
</div>