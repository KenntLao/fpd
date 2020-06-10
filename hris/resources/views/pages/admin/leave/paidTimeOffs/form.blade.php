@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_type_id">Leave Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="leave_type_id" required>
				@if(count($leaveTypes) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($leaveTypes as $leaveType)
				<option value="{{$leaveType->id}}" {{ $paidTimeOff->leave_type_id == $leaveType->id  ? 'selected' : '' }}>{{$leaveType->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_id">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				@if(count($employees) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $paidTimeOff->employee_id == $employee->id  ? 'selected' : '' }}>{{$employee->firstname}} {{$employee->lastname}}</option>
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
			<label class="mr-2" for="leave_period_id">Leave Period: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="leave_period_id" required>
				@if(count($leavePeriods) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($leavePeriods as $leavePeriod)
				<option value="{{$leavePeriod->id}}" {{ $paidTimeOff->leave_period_id == $leavePeriod->id  ? 'selected' : '' }}>{{$leavePeriod->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="amount">Leave Amount: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter leave amount</p>
				<input class="form-control required" type="text" name="amount" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required  value="{{old('amount') ?? $paidTimeOff->amount}}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="note">Note: </label>
			<div class="input">
				<p class="placeholder">Enter note</p>
				<textarea class="form-control" name="note">{{old('note') ?? $paidTimeOff->note}}</textarea>
			</div>
		</div>
	</div>
</div>