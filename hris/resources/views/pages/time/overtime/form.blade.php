@csrf
<div class="row">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_date">Overtime Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
				<input class="form-control required" type="text" name="ot_date" value="{{ old('ot_date') ?? $overtime->ot_date }}" required readonly>
				@else
				<input class="form-control required overtime_date" type="text" name="ot_date" value="{{ old('ot_date') ?? $overtime->ot_date }}" required>
				@endif
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_time_in">Overtime Time In: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
				<input class="form-control required" type="text" name="ot_time_in" value="{{ old('ot_time_in') ?? $overtime->ot_time_in }}" required readonly>
				@else
				<input class="form-control required overtime_time" type="text" name="ot_time_in" value="{{ old('ot_time_in') ?? $overtime->ot_time_in }}" required>
				@endif
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_time_out">Overtime Time Out: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
				<input class="form-control required" type="text" name="ot_time_out" value="{{ old('ot_time_out') ?? $overtime->ot_time_out }}" required readonly>
				@else
				<input class="form-control required overtime_time" type="text" name="ot_time_out" value="{{ old('ot_time_out') ?? $overtime->ot_time_out }}" required>
				@endif
			</div>
		</div>
	</div>
</div>
@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="type">Type: </label>
			<span class="badge">Required</span>
			<select class="form-control select2 required" name="type" required>
				<option disabled selected default>--select one--</option>
				<option value="REG">REG</option>
				<option value="REB_>8">REB_>8</option>
				<option value="REG_ND1">REG_ND1</option>
				<option value="REG_ND2">REG_ND2</option>
				<option value="RST">RST</option>
				<option value="RST_>8">RST_>8</option>
				<option value="RST_ND1">RST_ND1</option>
				<option value="RST_ND2">RST_ND2</option>
				<option value="LGL">LGL</option>
				<option value="LGL_>8">LGL_>8</option>
				<option value="LGL_ND1">LGL_ND1</option>
				<option value="LGL_ND2">LGL_ND2</option>
				<option value="LGLRST">LGLRST</option>
				<option value="LGLRST_>8">LGLRST_>8</option>
				<option value="LGLRST_ND1">LGLRST_ND1</option>
				<option value="LGLRST_ND2">LGLRST_ND2</option>
				<option value="SPL">SPL</option>
				<option value="SPL_>8">SPL_>8</option>
				<option value="SPL_ND1">SPL_ND1</option>
				<option value="SPL_ND2">SPL_ND2</option>
				<option value="SPLRST">SPLRST</option>
				<option value="SPLRST_>8">SPLRST_>8</option>
				<option value="SPLRST_ND1">SPLRST_ND1</option>
				<option value="SPLRST_ND2">SPLRST_ND2</option>
				<option value="SPRS_CLIEN">SPRS_CLIEN</option>
				<option value="SPRS_CLIEN_>8">SPRS_CLIEN_>8</option>
				<option value="SPRS_CLIEN_ND1">SPRS_CLIEN_ND1</option>
				<option value="SPRS_CLIEN_ND2">SPRS_CLIEN_ND2</option>
				<option value="LGRS_CLIEN">LGRS_CLIEN</option>
				<option value="LGRS_CLIEN_>8">LGRS_CLIEN_>8</option>
				<option value="LGRS_CLIEN_ND1">LGRS_CLIEN_ND1</option>
				<option value="LGRS_CLIEN_ND2">LGRS_CLIEN_ND2</option>
				<option value="SPL_CLIENT">SPL_CLIENT</option>
				<option value="SPL_CLIENT_>8">SPL_CLIENT_>8</option>
				<option value="SPL_CLIENT_ND1">SPL_CLIENT_ND1</option>
				<option value="SPL_CLIENT_ND2">SPL_CLIENT_ND2</option>
				<option value="RST_CLIENT">RST_CLIENT</option>
				<option value="RST_CLIENT_>8">RST_CLIENT_>8</option>
				<option value="RST_CLIENT_ND1">RST_CLIENT_ND1</option>
				<option value="RST_CLIENT_ND2">RST_CLIENT_ND2</option>
				<option value="REG_CLIENT">REG_CLIENT</option>
				<option value="REG_CLIENT_>8">REG_CLIENT_>8</option>
				<option value="REG_CLIENT_ND1">REG_CLIENT_ND1</option>
				<option value="REG_CLIENT_ND2">REG_CLIENT_ND2</option>
				<option value="REGND_CLIE">REGND_CLIE</option>
				<option value="REGND_CLIE_>8">REGND_CLIE_>8</option>
				<option value="REGND_CLIE_ND1">REGND_CLIE_ND1</option>
				<option value="REGND_CLIE_ND2">REGND_CLIE_ND2</option>
				<option value="LG_CLIENT">LG_CLIENT</option>
				<option value="LG_CLIENT_>8">LG_CLIENT_>8</option>
				<option value="LG_CLIENT_ND1">LG_CLIENT_ND1</option>
				<option value="LG_CLIENT_ND2">LG_CLIENT_ND2</option>
				<option value="LGLSPL">LGLSPL</option>
				<option value="LGLSPL_>8">LGLSPL_>8</option>
				<option value="LGLSPL_ND1">LGLSPL_ND1</option>
				<option value="LGLSPL_ND2">LGLSPL_ND2</option>
				<option value="LGLSPLRST">LGLSPLRST</option>
				<option value="LGLSPLRST_>8">LGLSPLRST_>8</option>
				<option value="LGLSPLRST_ND1">LGLSPLRST_ND1</option>
				<option value="LGLSPLRST_ND2">LGLSPLRST_ND2</option>
				<option value="LGLSPL_CLI">LGLSPL_CLI</option>
				<option value="LGLSPL_CLI_>8">LGLSPL_CLI_>8</option>
				<option value="LGLSPL_CLI_ND1">LGLSPL_CLI_ND1</option>
				<option value="LGLSPL_CLI_ND2">LGLSPL_CLI_ND2</option>
				<option value="LGLSPL_ND1">LGLSPL_ND1</option>
				<option value="LGLSPL_ND1_>8">LGLSPL_ND1_>8</option>
				<option value="LGLSPL_ND1_ND1">LGLSPL_ND1_ND1</option>
				<option value="LGLSPL_ND1_ND2">LGLSPL_ND1_ND2</option>
			</select>
		</div>
	</div>
</div>
@endif
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee_remarks">Employee Remarks: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter employee remarks</p>
				@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
				<textarea class="form-control required" name="employee_remarks" required readonly>{{ old('employee_remarks') ?? $overtime->employee_remarks }}</textarea>
				@else
				<textarea class="form-control required" name="employee_remarks" required>{{ old('employee_remarks') ?? $overtime->employee_remarks }}</textarea>
				@endif
			</div>
		</div>
	</div>
	@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="supervisor_remarks">Supervisor Remarks: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter supervisor remarks</p>
				<textarea class="form-control required" name="supervisor_remarks">{{ old('supervisor_remarks') ?? $overtime->supervisor_remarks }}</textarea>
			</div>
		</div>
	</div>
	@endif
</div>