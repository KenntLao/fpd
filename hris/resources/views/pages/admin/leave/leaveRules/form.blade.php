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
				<option value="{{$leaveType->id}}" {{ $leaveRule->leave_type_id == $leaveType->id  ? 'selected' : '' }}>{{$leaveType->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_group_id">Leave Group: </label>
			<select class="form-control select2" name="leave_group_id">
				@if(count($leaveGroups) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($leaveGroups as $leaveGroup)
				<option value="{{$leaveGroup->id}}" {{ $leaveRule->leave_group_id == $leaveGroup->id  ? 'selected' : '' }}>{{$leaveGroup->name}}</option>
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
			<label class="mr-2" for="employment_status_id">Employment Status: </label>
			<select class="form-control select2" name="employment_status_id">
				@if(count($employmentStatuses) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employmentStatuses as $employmentStatus)
				<option value="{{$employmentStatus->id}}" {{ $leaveRule->employment_status_id == $employmentStatus->id  ? 'selected' : '' }}>{{$employmentStatus->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_period_id">Leave Period: </label>
			<select class="form-control select2" name="leave_period_id">
				@if(count($leavePeriods) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($leavePeriods as $leavePeriod)
				<option value="{{$leavePeriod->id}}" {{ $leaveRule->leave_period_id == $leavePeriod->id  ? 'selected' : '' }}>{{$leavePeriod->name}}</option>
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
			<label class="mr-2" for="default_per_year">Leaves Per Leave Period: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter leaves per period</p>
				<input class="form-control required" type="text" name="default_per_year" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required maxlength="6" value="{{old('default_per_year') ?? $leaveRule->default_per_year}}">
			</div>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-1"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-1" tabindex="-1" role="dialog" aria-labelledby="tip-1" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>This is the number of leave days that can be applied by an employee per year (or the current leave period). If the leave period is less than a Year this is the number of leaves for the leave period.</p>
							</div>
							<div class="modal-footer">
								<button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_can_apply">Employees can apply for this leave type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="employee_can_apply" required>
				<option value="Yes" {{ $leaveRule->employee_can_apply == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveRule->employee_can_apply == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>