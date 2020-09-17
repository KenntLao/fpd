@csrf
<div class="row">
	<div class="col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_name">Select Employee</label>
			<span class="badge badge-danger">Required</span>
			@if(\Route::current()->getName() == 'editWs')
			<select class="form-control required select2 select-employee" name="employee_id" required>
			@else
			<select class="form-control required select2 select-employee" name="employee_id[]" multiple="multiple" required>
			@endif
				@if(count($employees) > 0)
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $workshift_assignment->employee_id == $employee->id  ? 'selected' : '' }}>{{'['.$employee->employee_number.'] '}}{{$employee->firstname}} {{$employee->lastname}}</option>
				@endforeach
				@else
				<option selected default disabled>-- None --</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_name">Select Work Shift</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="workshift_id" required>
				@if(count($work_shift) > 0)
				<option selected default disabled>-- None --</option>
				@foreach($work_shift as $shift)
				<option value="{{$shift->id}}" {{ $workshift_assignment->workshift_id == $shift->id  ? 'selected' : '' }}>{{$shift->workshift_name}}</option>
				@endforeach
				@else
				<option selected default disabled>-- None --</option>
				@endif
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
					<input class="form-control required work_sched" type="text" name="date_from" value="@if($workshift_assignment->date_from) {{date('Y-m-d', strtotime($workshift_assignment->date_from))}} @else{{old('date_from')}}@endif" required>
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
					<input class="form-control required work_sched" type="text" name="date_to" value="@if($workshift_assignment->date_to) {{date('Y-m-d', strtotime($workshift_assignment->date_to))}} @else{{old('date_to')}}@endif" required>
				</div>
			</div>
		</div>
	</div>
</div>