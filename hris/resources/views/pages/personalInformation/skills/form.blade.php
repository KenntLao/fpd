@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="skill_id">Code: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="skill_id" required>
				@if (count($skills) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($skills as $skill)
				<option value="{{$skill->id}}" {{ $employeeSkill->skill_id == $skill->id  ? 'selected' : '' }}>{{$skill->name}}</option>
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
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter details</p>
				<textarea class="form-control required" name="details" required>{{old('details') ?? $employeeSkill->details}}</textarea>
			</div>
		</div>
	</div>
</div>