@csrf
<div class="row">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_date">Overtime Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				@if($id == $overtime->supervisor_id)
				<input class="form-control required" type="text" name="ot_date" value="{{ old('ot_date') ?? $overtime->ot_date }}" required readonly>
				@else
				<input class="form-control required overtime_date" type="text" name="ot_date" value="{{ old('ot_date') ?? $overtime->ot_date }}" required {{ $overtime->status == 'Approved' ? 'disabled' : '' ?? $overtime->status == 'Rejected' ? 'disabled' : '' }} >
				@endif
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_time_in">Overtime Time In: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				@if($id == $overtime->supervisor_id)
				<input class="form-control required" type="text" name="ot_time_in" value="{{ old('ot_time_in') ?? $overtime->ot_time_in }}" required readonly>
				@else
				<input class="form-control required overtime_time" type="text" name="ot_time_in" value="{{ old('ot_time_in') ?? $overtime->ot_time_in }}" required {{ $overtime->status == 'Approved' ? 'disabled' : '' ?? $overtime->status == 'Rejected' ? 'disabled' : '' }} >
				@endif
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_time_out">Overtime Time Out: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				@if($id == $overtime->supervisor_id)
				<input class="form-control required" type="text" name="ot_time_out" value="{{ old('ot_time_out') ?? $overtime->ot_time_out }}" required readonly>
				@else
				<input class="form-control required overtime_time" type="text" name="ot_time_out" value="{{ old('ot_time_out') ?? $overtime->ot_time_out }}" required {{ $overtime->status == 'Approved' ? 'disabled' : '' ?? $overtime->status == 'Rejected' ? 'disabled' : '' }} >
				@endif
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_remarks">Employee Remarks: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter employee remarks</p>
				@if($id == $overtime->supervisor_id)
				<textarea class="form-control required" name="employee_remarks" required readonly>{{ old('employee_remarks') ?? $overtime->employee_remarks }}</textarea>
				@else
				<textarea class="form-control required" name="employee_remarks" required {{ $overtime->status == 'Approved' ? 'disabled' : '' ?? $overtime->status == 'Rejected' ? 'disabled' : '' }} >{{ old('employee_remarks') ?? $overtime->employee_remarks }}</textarea>
				@endif
			</div>
		</div>
	</div>
	@if($id == $employee->supervisor OR $overtime->supervisor_remarks)
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="supervisor_remarks">Supervisor Remarks: </label>
			<div class="input">
				<p class="placeholder">Enter supervisor remarks</p>
				<textarea class="form-control required" name="supervisor_remarks"  {{ $overtime->status == 'Approved' ? 'readonly' : '' ?? $overtime->status == 'Rejected' ? 'readonly' : '' }} >{{ old('supervisor_remarks') ?? $overtime->supervisor_remarks }}</textarea>
			</div>
		</div>
	</div>
	@endif
</div>