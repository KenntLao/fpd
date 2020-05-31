@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee" required>
				<option value="SocialConz Digital" {{ $employeeTrainingSession->employee == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="training_session">Training Session: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="training_session" required>
				@if (count($trainingSessions) > 0)
				<option value="None" {{ $employeeTrainingSession->training_session == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($trainingSessions as $trainingSession)
				<option value="{{$trainingSession->name}}" {{ $employeeTrainingSession->training_session == $trainingSession->name  ? 'selected' : '' }}>{{$trainingSession->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
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