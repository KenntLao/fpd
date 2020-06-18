@csrf
<div class="row">
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="time_in">Sunday Time in: </label>
			<div class="input">
				<input class="form-control overtime_time" type="text" name="sunday_time_in" value="{{ old('ot_time_in') ?? $overtime->ot_time_in }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="time_in">Sunday Time in: </label>
			<div class="input">
				<input class="form-control overtime_time" type="text" name="sunday_time_in" value="{{ old('ot_time_in') ?? $overtime->ot_time_in }}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-4">
		<div class="form-group">
			<label class="mr-2" for="time_in">Sunday Time in: </label>
			<div class="input">
				<input class="form-control overtime_date" type="text" name="sunday_time_in" required>
			</div>
		</div>
	</div>
</div>