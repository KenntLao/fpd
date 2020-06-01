@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $leavePeriod->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="start">Period Start: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="date" name="start" value="{{old('start') ?? $leavePeriod->start}}" required>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="end">Period End: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="date" name="end" value="{{old('end') ?? $leavePeriod->end}}" required>
		</div>
	</div>
</div>