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
			<label class="mr-2" for="exp_days">Required Experience (Days): </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter leaves per period</p>
				<input class="form-control required" type="text" name="exp_days" value="{{old('exp_days') ?? $leaveRule->exp_days}}" required>
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
								<p>Number of experience in days required for this rule to be applied to the employee. 0 to discard experience. Experience is calculated by taking difference in days between joined date and start date of current leave period.</p>
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
</div>
<div class="row">
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
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="supervisor_leave_assign">Admin can assign leave to employees: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="supervisor_assign_leave" required>
				<option value="Yes" {{ $leaveRule->supervisor_leave_assign == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveRule->supervisor_leave_assign == 'No'  ? 'selected' : '' }}>No</option>
			</select>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-2"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-2" tabindex="-1" role="dialog" aria-labelledby="tip-2" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>If [ Yes ] is selected, an Admin or a Manager is able to login as an employee (Please check switch employee concept explained in employee module) and apply this type of leaves behalf of the employee.</p>
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
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="apply_beyond_current">Employees can apply beyond the current leave balance: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="apply_beyond_current" required>
				<option value="Yes" {{ $leaveRule->apply_beyond_current == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveRule->apply_beyond_current == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_accrue">Leave Accrue Enabled: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="leave_accrue" required>
				<option value="Yes" {{ $leaveRule->leave_accrue == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveRule->leave_accrue == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>

<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="proportionate_on_joined_date">Proportionate leaves on Joined Date: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="proportionate_on_joined_date" required>
				<option value="Yes" {{ $leaveRule->proportionate_on_joined_date == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveRule->proportionate_on_joined_date == 'No'  ? 'selected' : '' }}>No</option>
			</select>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-7"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-7" tabindex="-1" role="dialog" aria-labelledby="tip-7" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>Whether the available number of leaves should be calculated based on number of days employee work in a given leave period. (e.g if an employee joined in end of June, he/she will only get half of the number of leave days specified for given leave type.</p>
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
			<label class="mr-2" for="employee_leave_period">Use Employee Leave Period: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_leave_period" required>
				<option value="Yes" {{ $leaveRule->employee_leave_period == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveRule->employee_leave_period == 'No'  ? 'selected' : '' }}>No</option>
			</select>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-8"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-8" tabindex="-1" role="dialog" aria-labelledby="tip-8" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
									<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>When Yes is selected leave period for this type of leave will start from the joined date of each employee.</p>
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
</div>