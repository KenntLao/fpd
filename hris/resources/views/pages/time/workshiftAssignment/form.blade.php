@csrf
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_name">Select Employee</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				@if($employee)
				<option selected value="{{$workshift_assignment->employee_id}}">{{$employee->firstname}} {{$employee->lastname}}</option>
				@else
				<option selected default disabled>-- select one --</option>
				@endif
				@foreach($employees as $emp_data)
				<option value="{{$emp_data->id}}">{{$emp_data->firstname}} {{$emp_data->lastname}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_name">Select Work Shift</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="workshift_id" required>
				@if($workshift_rel)
				<option selected value="{{$workshift_assignment->workshift_id}}">{{$workshift_rel->workshift_name}}</option>
				@else
				<option selected default disabled>-- select one --</option>
				@endif
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
					<input class="form-control required work_sched" type="text" name="date_from" value="{{old('date_from') ?? $workshift_assignment->date_from}}" required>
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
					<input class="form-control required work_sched" type="text" name="date_to" value="{{old('date_to') ?? $workshift_assignment->date_to}}" required>
				</div>
			</div>
		</div>
	</div>
</div>