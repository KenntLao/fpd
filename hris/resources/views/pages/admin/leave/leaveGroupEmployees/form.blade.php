@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				@if (count($employees) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $leaveGroupEmployee->employee_id == $employee->id  ? 'selected' : '' }}>{{$employee->firstname}} {{$employee->lastname}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_group">Leave Group: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="leave_group_id" required>
				@if(count($leaveGroups) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($leaveGroups as $leaveGroup)
				<option value="{{$leaveGroup->id}}" {{ $leaveGroupEmployee->leave_group_id == $leaveGroup->id  ? 'selected' : '' }}>{{$leaveGroup->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
</div>