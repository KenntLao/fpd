@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				@if (count($employees) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $employeeTrainingSession->employee_id == $employee->id  ? 'selected' : '' }}>{{$employee->firstname}} {{$employee->lastname}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="training_session">Training Session: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="training_session_id" required>
				@if (count($trainingSessions) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($trainingSessions as $trainingSession)
				<option value="{{$trainingSession->id}}" {{ $employeeTrainingSession->training_session == $trainingSession->id  ? 'selected' : '' }}>{{$trainingSession->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="status" required>
				<option value="Scheduled" {{ $employeeTrainingSession->status == 'Scheduled'  ? 'selected' : '' }}>Scheduled</option>
				<option value="Attended" {{ $employeeTrainingSession->status == 'Attended'  ? 'selected' : '' }}>Attended</option>
				<option value="Not Attended" {{ $employeeTrainingSession->status == 'Not Attended'  ? 'selected' : '' }}>Not Attended</option>
			</select>
		</div>
	</div>
</div>