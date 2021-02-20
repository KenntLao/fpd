@csrf
<div class="row">
	<input type="hidden" value="{{$employee->id}}" name="employee_id">
	<input type="hidden" value="{{$employee->supervisor}}" name="supervisor_id">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="start_date">Leave Type</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control select2 required" name="leave_type">
				<option selected default disabled>-- select one --</option>
				@foreach($leave_groups_rules as $leave_groups_rule)
				<option value="{{$leave_groups_rule->leave_type_id}}" {{$leave_groups_rule->leave_type_id == $leaves->leave_type_id ? 'selected' : ''}}>{{$leave_groups_rule->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="half_day">Half-Day</label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control half_day required" name="half_day">
				<option default value="0">No</option>
				<option value="1">Yes</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-4 short_leave_date">
		<div class="form-group">
			<label class="mr-2" for="start_date">Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required leave_date required" type="text" name="short_date" value="@if($leaves->short_date) {{date("Y-m-d", strtotime($leaves->short_date))}} @else{{old('short_date')}}@endif" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 long_leave_date">
		<div class="form-group">
			<label class="mr-2" for="start_date">Start Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required leave_date" type="text" name="start_date" value="@if($leaves->leave_start_date) {{date("Y-m-d", strtotime($leaves->leave_start_date))}} @else{{old('start_date')}}@endif" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4 long_leave_date">
		<div class="form-group">
			<label class="mr-2" for="end_date">End Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required leave_date" type="text" name="end_date" value="@if($leaves->leave_end_date) {{date("Y-m-d", strtotime($leaves->leave_end_date))}} @else{{old('end_date')}}@endif" required>
			</div>
		</div>
	</div>

</div>
<div class="row">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="end_date">Reason</label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<textarea class="form-control required" name="reason" required>{{ old('reason') ?? $leaves->reason}}</textarea>
			</div>
		</div>
	</div>
</div>