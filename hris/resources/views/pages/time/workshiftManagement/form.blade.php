@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="workshift_name">Work Shift Name: </label>
			<span class="badge right badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Work Shift Name</p>
				<input class="form-control required" type="text" name="workshift_name" value="{{old('work_shift_name') ?? $work_shift->workshift_name}}" required>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="monday_shift" value="1" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Monday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Monday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="monday_time_in" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Monday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="monday_time_out" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="tuesday_shift" value="1" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Tuesday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Tuesday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="tuesday_time_in" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Tuesday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="tuesday_time_out" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="wednesday_shift" value="1" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Wednesday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Wednesday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="wednesday_time_in" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Wednesday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="wednesday_time_out" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="thursday_shift" value="1" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Thursday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Thursday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="thursday_time_in" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Thursday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="thursday_time_out" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="friday_shift" value="1" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Friday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Friday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="friday_time_in" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Friday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="friday_time_out" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="saturday_shift" value="1" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Saturday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Saturday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="saturday_time_in" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Saturday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="saturday_time_out" required>
					</div>
				</div>
			</div>
		</div>
		<div class="form-group">
			<div class="form-check">
				<input class="form-check-input workshift_check" type="checkbox" name="sunday_shift" value="1" id="defaultCheck1">
				<label class="form-check-label" for="defaultCheck1">
					Sunday
				</label>
			</div>
			<div class="row shift_time">
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Sunday Time in: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="sunday_time_in" required>
					</div>
				</div>
				<div class="col-md-6">
					<label class="mr-2" for="time_in">Sunday Time Out: </label>
					<div class="input">
						<input class="form-control workshift_time" type="text" name="sunday_time_out" required>
					</div>
				</div>
			</div>
		</div>
	</div>
</div>