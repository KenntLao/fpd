@csrf
<?php
	echo $_SESSION['sys_id'];
?>
<div class="row">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_date">Overtime Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required overtime_date" type="text" name="ot_date" value="{{ old('ot_date') ?? $overtime->ot_date }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_time_in">Overtime Time In: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required overtime_time" type="text" name="ot_time_in" value="{{ old('ot_time_in') ?? $overtime->ot_time_in }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_time_out">Overtime Time Out: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<input class="form-control required overtime_time" type="text" name="ot_time_out" value="{{ old('ot_time_out') ?? $overtime->ot_time_out }}" required>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_remarks">Employee Remarks</label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter employee remarks</p>
				<textarea class="form-control required" name="employee_remarks">{{ old('employee_remarks') ?? $overtime->employee_remarks }}</textarea>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="supervisor_remarks">Supervisor Remarks</label>
			<div class="input">
				<p class="placeholder">Enter supervisor remarks</p>
				<textarea class="form-control required" name="supervisor_remarks" disabled>{{ old('supervisor_remarks') ?? $overtime->supervisor_remarks }}</textarea>
			</div>
		</div>
	</div>
</div>