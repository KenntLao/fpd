@csrf
@if( $_SESSION['sys_role_ids'] == ',1,' )
<div class="row">
	<div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2" for="department_id">Department </label>
            <span class="badge badge-danger">Required</span>
            <select id="department_dropdown" class="form-control required select2" name="department_id" required>
                @if($overtime->department)
                <option value="{{$overtime->department_id}}" default selected>{{$overtime->department->name}}</option>
                @else
                <option disabled default selected>--select one--</option>
                @foreach($departments as $department)
                <option value="{{$department->id}}">{{$department->name}}</option>
                @endforeach
                @endif
            </select>
        </div>
	</div>
	<div class="col-12 col-md-6">
        <div class="form-group">
            <label class="mr-2" for="employee_id">Employee </label>
            <span class="badge badge-danger">Required</span>
            <select id="employee" class="form-control select2 required" name="employee_id">
                @if($overtime->employee_id)
                <option value="{{$overtime->employee_id}}" default selected>{{$overtime->employee->firstname}} {{$overtime->employee->lastname}}</option>
                @else 
                <option default disabled selected>-- select one --</option>
                @endif
            </select>
        </div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="ot_date">Overtime Date: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
				<input class="form-control required" type="text" name="ot_date" value="{{ old('ot_date') ?? date('Y-m-d', strtotime($overtime->ot_date)) }}" required readonly>
				@else
				<input class="form-control required overtime_date" type="text" name="ot_date" value="{{ old('ot_date') ?? date('Y-m-d', strtotime($overtime->ot_date)) }}" required>
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
				<input class="form-control required" type="text" name="ot_time_in" value="{{ old('ot_time_in') ?? substr_replace($overtime->ot_time_in, ':', 2, 0) }}" required readonly>
				@else
				<input class="form-control required overtime_time" type="text" name="ot_time_in" value="{{ old('ot_time_in') ?? substr_replace($overtime->ot_time_in, ':', 2, 0) }}" required>
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
				<input class="form-control required" type="text" name="ot_time_out" value="{{ old('ot_time_out') ?? substr_replace($overtime->ot_time_out, ':', 2, 0) }}" required readonly>
				@else
				<input class="form-control required overtime_time" type="text" name="ot_time_out" value="{{ old('ot_time_out') ?? substr_replace($overtime->ot_time_out, ':', 2, 0) }}" required>
				@endif
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="overtime_category_id">Category: </label>
			<span class="badge badge-danger">Required</span>
			@if($id == $employee->supervisor OR $_SESSION['sys_role_ids'] == ',1,')
			<select class="form-control required" name="overtime_category_id" required readonly>
				@if(count($categories) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($categories as $category)
				<option value="{{$category->id}}" {{ $overtime->overtime_category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
			@else
			<select class="form-control required" name="overtime_category_id" required>
				@if(count($categories) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($categories as $category)
				<option value="{{$category->id}}" {{ $overtime->overtime_category_id == $category->id ? 'selected' : '' }}>{{$category->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
			@endif
		</div>
	</div>
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
</div>
@else
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
			<label class="mr-2" for="type">Type: </label>
			<span class="badge">Required</span>
			<select class="form-control select2 required" name="type" required>
				<option disabled default selected>--select one--</option>
				@foreach( $types as $type )
				<option value="{{$type->id}}">{{$type->name}}</option>
				@endforeach
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="supervisor_remarks">Supervisor Remarks: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter supervisor remarks</p>
				<textarea class="form-control required" name="supervisor_remarks" required>{{ old('supervisor_remarks') ?? $overtime->supervisor_remarks }}</textarea>
			</div>
		</div>
	</div>
</div>
@endif