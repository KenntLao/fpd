@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Leave Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $leaveType->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="leave_color">Leave Color: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter leave color hex code</p>
				<input class="form-control required" type="text" name="leave_color" required id="colorInput" maxlength="6" value="{{old('leave_color') ?? $leaveType->leave_color}}">
				<div class="color-box"></div>
			</div>
		</div>
	</div>
</div>