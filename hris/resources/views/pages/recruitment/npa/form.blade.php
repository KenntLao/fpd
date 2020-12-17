@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="request_date">Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required" name="request_date" type="date" required value="{{old('request_date') ?? $npa->request_date}}" />
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="effectivity_date">Effectivity Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required" name="effectivity_date" type="date" required value="{{old('effectivity_date') ?? $npa->effectivity_date}}" />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="attention">Attention: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter attention</p>
				<input class="form-control required" name="attention" type="text" required value="{{old('attention') ?? $npa->attention}}" />
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="ref_no">Reference No: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter reference number</p>
				<input class="form-control required" name="ref_no" type="text" required value="{{old('ref_no') ?? $npa->ref_no}}" />
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="gender">Project: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="project_id" required>
				<option disabled default selected>-- Select Project --</option>
				@if(count($projects) > 0)
				@foreach($projects as $project)
				<option value="{{$project->id}}" {{ $npa->project_id == $project->id  ? 'selected' : '' }}>{{ $project->name }}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="reason">Reason: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Reason</p>
				<textarea class="form-control required" name="reason" required>{{$npa->reason ?? ''}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_id">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				<option disabled default selected>-- Select Employee --</option>
				@if(count($employees) > 0)
				@foreach($employees as $employee)
				@if( $employee->id != $_SESSION['sys_id'] )
				<option value="{{$employee->id}}" {{ $npa->employee_id == $employee->id  ? 'selected' : '' }}>[{{$employee->employee_number}}] {{ucfirst($employee->firstname)}} {{ucfirst($employee->lastname)}}</option>
				@endif
				@endforeach
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="designation_from_id">Designation from: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="designation_from_id" required>
				<option disabled default selected>-- Select Project --</option>
				<option value="0" {{ $npa->designation_from_id == 0  ? 'selected' : '' }}>None</option>
				@if(count($projects) > 0)
				@foreach($projects as $project)
				<option value="{{$project->id}}" {{ $npa->designation_from_id == $project->id  ? 'selected' : '' }}>{{ $project->name }}</option>
				@endforeach
				@endif
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="bs_from">Basic salary from (PHP): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter basic salary from previous project</p>
				<input class="form-control required" name="bs_from" type="number" required value="{{old('bs_from') ?? $npa->bs_from}}" />
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="bs_to">Basic Salary to (PHP): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter basic salary</p>
				<input class="form-control required" name="bs_to" type="number" required value="{{old('bs_to') ?? $npa->bs_to}}" />
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="a_from">Allowance from (PHP): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter allowance from previous project</p>
				<input class="form-control required" name="a_from" type="number" required value="{{old('a_from') ?? $npa->a_from}}" />
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="a_to">Allowance to (PHP): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter allowance</p>
				<input class="form-control required" name="a_to" type="number" required value="{{old('a_to') ?? $npa->a_to}}" />
			</div>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="cola_from">COLA from (PHP): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter COLA from previous project</p>
				<input class="form-control required" name="cola_from" type="number" required value="{{old('cola_from') ?? $npa->cola_from}}" />
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="cola_to">COLA to (PHP): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter COLA</p>
				<input class="form-control required" name="cola_to" type="number" required value="{{old('cola_to') ?? $npa->cola_to}}" />
			</div>
		</div>
	</div>
</div>
