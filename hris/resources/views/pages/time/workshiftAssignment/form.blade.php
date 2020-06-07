@csrf
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_name">Select Employee</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				<option selected default disabled>-- select one --</option>
				@forelse($employees as $employee)
				<option value="{{$employee->id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
				@empty
				<p>No available Employee</p>
				@endforelse
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_name">Select Work Shift</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="workshift_id" required>
				<option selected default disabled>-- select one --</option>
				@forelse($work_shift as $shift)
				<option value="{{$shift->id}}">{{$shift->workshift_name}}</option>
				@empty
				<p>No available Work Shift</p>
				@endforelse
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<div class="form-group">
				<label class="mr-2" for="date_from">Date From: </label>
				<span class="badge badge-danger">Required</span>
				<div class="input">
					<input class="form-control required work_sched" type="text" name="date_from" required>
				</div>
			</div>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<div class="form-group">
				<label class="mr-2" for="date_to">Date To: </label>
				<span class="badge badge-danger">Required</span>
				<div class="input">
					<input class="form-control required work_sched" type="text" name="date_to" required>
				</div>
			</div>
		</div>
	</div>
</div>