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
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_group">Leave Group: </label>
			<select class="form-control required select2" name="leave_group">
				@if(count($leaveGroups) > 0)
				<option value="None" {{ $leaveType->leave_group == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($leaveGroups as $leaveGroup)
				<option value="{{$leaveGroup->name}}" {{ $leaveType->leave_group == $leaveGroup->name  ? 'selected' : '' }}>{{$leaveGroup->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
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