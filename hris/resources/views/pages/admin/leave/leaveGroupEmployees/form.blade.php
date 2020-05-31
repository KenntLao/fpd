@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee" required>
				<option value="SocialConz Digital" {{ $leaveGroupEmployee->employee == 'SocialConz Digital'  ? 'selected' : '' }}>SocialConz Digital</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_group">Leave Group: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="leave_group" required>
				@if(count($leaveGroups) > 0)
				<option value="None" {{ $leaveGroupEmployee->leave_group == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($leaveGroups as $leaveGroup)
				<option value="{{$leaveGroup->name}}" {{ $leaveGroupEmployee->leave_group == $leaveGroup->name  ? 'selected' : '' }}>{{$leaveGroup->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
</div>