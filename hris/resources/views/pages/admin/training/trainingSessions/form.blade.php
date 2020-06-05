@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $trainingSession->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="course">Course: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="course_id" required>
				@if(count($courses) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($courses as $course)
				<option value="{{$course->id}}" {{ $course->id == $trainingSession->course_id  ? 'selected' : '' }}>{{$course->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="details">Details: </label>
			<div class="input">
				<p class="placeholder">Enter details</p>
				<textarea class="form-control required" name="details">{{old('details') ?? $trainingSession->details}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="scheduled_time">Scheduled Time: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="datetime-local" name="scheduled_time" value="{{ old('scheduled_time') ??  date('Y-m-d\TH:i', strtotime($trainingSession->scheduled_time)) }}" required>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="assignment_due_date">Assignment Due Date: </label>
			<input class="form-control" type="date" value="{{old('assignment_due_date') ?? $trainingSession->assignment_due_date}}" name="assignment_due_date">
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="delivery_method">Delivery Method: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="delivery_method" required>
				<option value="Classroom" {{ $trainingSession->delivery_method == 'Classroom'  ? 'selected' : '' }}>Classroom</option>
				<option value="Self Study" {{ $trainingSession->delivery_method == 'Self Study'  ? 'selected' : '' }}>Self Study</option>
				<option value="Online" {{ $trainingSession->delivery_method == 'Online'  ? 'selected' : '' }}>Online</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="delivery_location">Delivery Location: </label>
			<div class="input">
				<p class="placeholder">Enter delivery location</p>
				<input class="form-control" type="text" name="delivery_location" value="{{old('delivery_location') ?? $trainingSession->delivery_location}}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="attendance_type">Attendance Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="attendance_type">
				<option value="Sign Up" {{ $trainingSession->attendance_type == 'Sign Up'  ? 'selected' : '' }}>Sign Up</option>
				<option value="Assign" {{ $trainingSession->attendance_type == 'Assign'  ? 'selected' : '' }}>Assign</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="attachment">Attachment: </label>
			<input class="form-control required" type="file" name="attachment">
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="training_cert_required">Training Certificate Required: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="training_cert_required">
				<option value="Yes" {{ $trainingSession->training_cert_required == 'Yes'  ? 'selected' : '' }}>Yes</option>
				<option value="No" {{ $trainingSession->training_cert_required == 'No'  ? 'selected' : '' }}>No</option>
			</select>
		</div>
	</div>
</div>