@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Leave Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $leaveType->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leaves_per_period">Leaves Per Leave Period: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter leaves per period</p>
				<input class="form-control required" type="text" name="leaves_per_period" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required maxlength="6" value="{{old('leaves_per_period') ?? $leaveType->leaves_per_period}}">
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
			<select class="form-control select2 required" name="supervisor_leave_assign" required>
				<option value="Yes" {{ $leaveType->supervisor_leave_assign == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->supervisor_leave_assign == 'No'  ? 'selected' : '' }}>No</option>
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
				<option value="Yes" {{ $leaveType->employee_can_apply == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->employee_can_apply == 'No'  ? 'selected' : '' }}>No</option>
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
				<option value="Yes" {{ $leaveType->apply_beyond_current == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->apply_beyond_current == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_accrue">Leave Accrue Enabled: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="leave_accrue" required>
				<option value="Yes" {{ $leaveType->leave_accrue == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->leave_accrue == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="carried_forward">Leave Carried Forward: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="carried_forward" required>
				<option value="Yes" {{ $leaveType->leave_accrue == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->leave_accrue == 'No'  ? 'selected' : '' }}>No</option>
			</select>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-3"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-3" tabindex="-1" role="dialog" aria-labelledby="tip-3" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>If an employee has some leave balance remaining in previous leave period, that amount will get add to the current leave period.</p>
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
			<label class="mr-2" for="carried_forward_percentage">Percentage of Leave Carried Forward: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter percentage of leave carried forward</p>
				<input class="form-control required" type="text" name="carried_forward_percentage" id="percentInput" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{old('carried_forward_percentage') ?? $leaveType->carried_forward_percentage}}" required>
			</div>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-4"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-4" tabindex="-1" role="dialog" aria-labelledby="tip-4" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>If only a percentage of remaining leave days should be carried forward to next leave period. Should be between 0 to 100. Effective only when leave carry forwarding is enabled</p>
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
			<label class="mr-2" for="max_carried_forward_amount">Maximum Carried Forward Amount: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter maximum carried forward amount</p>
				<input class="form-control required" type="text" name="max_carried_forward_amount" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" value="{{old('max_carried_forward_amount') ?? $leaveType->max_carried_forward_amount}}" required>
			</div>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-5"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-5" tabindex="-1" role="dialog" aria-labelledby="tip-5" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>Maximum number of leave days which can be carried forwarded from one year to another. Set to 0 for unlimited.</p>
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
			<label class="mr-2" for="carried_forward_leave_availability">Carried Forward Leave Availability Period: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="carried_forward_leave_availability" required>
				<option value="1 Month" {{ $leaveType->carried_forward_leave_availability == '1 Month'  ? 'selected' : '' }}>1 Month</option>
				<option value="2 Months" {{ $leaveType->carried_forward_leave_availability == '2 Month'  ? 'selected' : '' }}>2 Months</option>
				<option value="3 Months" {{ $leaveType->carried_forward_leave_availability == '3 Month'  ? 'selected' : '' }}>3 Months</option>
				<option value="4 Months" {{ $leaveType->carried_forward_leave_availability == '4 Month'  ? 'selected' : '' }}>4 Months</option>
				<option value="5 Months" {{ $leaveType->carried_forward_leave_availability == '5 Month'  ? 'selected' : '' }}>5 Months</option>
				<option value="6 Months" {{ $leaveType->carried_forward_leave_availability == '6 Month'  ? 'selected' : '' }}>6 Months</option>
				<option value="7 Months" {{ $leaveType->carried_forward_leave_availability == '7 Month'  ? 'selected' : '' }}>7 Months</option>
				<option value="8 Months" {{ $leaveType->carried_forward_leave_availability == '8 Month'  ? 'selected' : '' }}>8 Months</option>
				<option value="9 Months" {{ $leaveType->carried_forward_leave_availability == '9 Month'  ? 'selected' : '' }}>9 Months</option>
				<option value="10 Months" {{ $leaveType->carried_forward_leave_availability == '10 Month'  ? 'selected' : '' }}>10 Months</option>
				<option value="11 Months" {{ $leaveType->carried_forward_leave_availability == '11 Month'  ? 'selected' : '' }}>11 Months</option>
				<option value="1 Year" {{ $leaveType->carried_forward_leave_availability == '1 Year'  ? 'selected' : '' }}>1 Year</option>
				<option value="No Limit" {{ $leaveType->carried_forward_leave_availability == 'No Limit'  ? 'selected' : '' }}>No Limit</option>
			</select>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-6"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-6" tabindex="-1" role="dialog" aria-labelledby="tip-6" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>For how many days carried forward leaves are available from start date of next leave period.</p>
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
			<label class="mr-2" for="proportionate_on_joined_date">Proportionate leaves on Joined Date: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="proportionate_on_joined_date" required>
				<option value="Yes" {{ $leaveType->proportionate_on_joined_date == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->proportionate_on_joined_date == 'No'  ? 'selected' : '' }}>No</option>
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
				<option value="Yes" {{ $leaveType->employee_leave_period == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->employee_leave_period == 'No'  ? 'selected' : '' }}>No</option>
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
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="send_notification_emails">Send Notification Emails: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="send_notification_emails" required>
				<option value="Yes" {{ $leaveType->send_notification_emails == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $leaveType->send_notification_emails == 'No'  ? 'selected' : '' }}>No</option>
			</select>
			<div class="info">
				<!-- Button trigger modal -->
				<button type="button" class="btn btn-primary" data-toggle="modal" data-target="#tip-9"><i class="fas fa-fw fa-info"></i></button>
				<!-- Modal -->
				<div class="modal fade" id="tip-9" tabindex="-1" role="dialog" aria-labelledby="tip-9" aria-hidden="true">
					<div class="modal-dialog" role="document">
						<div class="modal-content">
							<div class="modal-header">
								<h5 class="modal-title" id="exampleModalLabel">Tip</h5>
								<button type="button" class="close" data-dismiss="modal" aria-label="Close">
								<span aria-hidden="true">&times;</span>
								</button>
							</div>
							<div class="modal-body">
								<p>Send leave emails or not. For some leave types you might not want to send email notifications.</p>
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
			<label class="mr-2" for="leave_group">Leave Group: </label>
			<select class="form-control required select2" name="leave_group_id">
				@if(count($leaveGroups) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($leaveGroups as $leaveGroup)
				<option value="{{$leaveGroup->id}}" {{ $leaveType->leave_group == $leaveGroup->name  ? 'selected' : '' }}>{{$leaveGroup->name}}</option>
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
			<label class="mr-2" for="leave_color">Leave Color: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter leave color hex code</p>
				<input class="form-control required" type="text" name="leave_color" required id="colorInput" maxlength="6" value="{{old('leave_color') ?? $leaveType->leave_color}}">
				<div class="color-box"></div>
			</div>
		</div>
	</div>
</div>