@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="language_id">Skill: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="language_id" required>
				@if (count($languages) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($languages as $language)
				<option value="{{$language->id}}" {{ $employeeLanguage->language_id == $language->id  ? 'selected' : '' }}>{{$language->name}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="reading">Reading: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="reading" required>
				<option value="Elementary Proficiency" {{ $employeeLanguage->reading == 'Elementary Proficiency'  ? 'selected' : '' }}>Elementary Proficiency</option>
				<option value="Limited Working Proficiency" {{ $employeeLanguage->reading == 'Limited Working Proficiency'  ? 'selected' : '' }}>Limited Working Proficiency</option>
				<option value="Professional Proficiency" {{ $employeeLanguage->reading == 'Professional Proficiency'  ? 'selected' : '' }}>Professional Proficiency</option>
				<option value="Full Professional Proficiency" {{ $employeeLanguage->reading == 'Full Professional Proficiency'  ? 'selected' : '' }}>Full Professional Proficiency</option>
				<option value="Native or Bilingual Proficiency" {{ $employeeLanguage->reading == 'Native or Bilingual Proficiency'  ? 'selected' : '' }}>Native or Bilingual Proficiency</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="speaking">Speaking: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="speaking" required>
				<option value="Elementary Proficiency" {{ $employeeLanguage->speaking == 'Elementary Proficiency'  ? 'selected' : '' }}>Elementary Proficiency</option>
				<option value="Limited Working Proficiency" {{ $employeeLanguage->speaking == 'Limited Working Proficiency'  ? 'selected' : '' }}>Limited Working Proficiency</option>
				<option value="Professional Proficiency" {{ $employeeLanguage->speaking == 'Professional Proficiency'  ? 'selected' : '' }}>Professional Proficiency</option>
				<option value="Full Professional Proficiency" {{ $employeeLanguage->speaking == 'Full Professional Proficiency'  ? 'selected' : '' }}>Full Professional Proficiency</option>
				<option value="Native or Bilingual Proficiency" {{ $employeeLanguage->speaking == 'Native or Bilingual Proficiency'  ? 'selected' : '' }}>Native or Bilingual Proficiency</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="writing">Writing: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="writing" required>
				<option value="Elementary Proficiency" {{ $employeeLanguage->writing == 'Elementary Proficiency'  ? 'selected' : '' }}>Elementary Proficiency</option>
				<option value="Limited Working Proficiency" {{ $employeeLanguage->writing == 'Limited Working Proficiency'  ? 'selected' : '' }}>Limited Working Proficiency</option>
				<option value="Professional Proficiency" {{ $employeeLanguage->writing == 'Professional Proficiency'  ? 'selected' : '' }}>Professional Proficiency</option>
				<option value="Full Professional Proficiency" {{ $employeeLanguage->writing == 'Full Professional Proficiency'  ? 'selected' : '' }}>Full Professional Proficiency</option>
				<option value="Native or Bilingual Proficiency" {{ $employeeLanguage->writing == 'Native or Bilingual Proficiency'  ? 'selected' : '' }}>Native or Bilingual Proficiency</option>
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="understanding">Understanding: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="understanding" required>
				<option value="Elementary Proficiency" {{ $employeeLanguage->understanding == 'Elementary Proficiency'  ? 'selected' : '' }}>Elementary Proficiency</option>
				<option value="Limited Working Proficiency" {{ $employeeLanguage->understanding == 'Limited Working Proficiency'  ? 'selected' : '' }}>Limited Working Proficiency</option>
				<option value="Professional Proficiency" {{ $employeeLanguage->understanding == 'Professional Proficiency'  ? 'selected' : '' }}>Professional Proficiency</option>
				<option value="Full Professional Proficiency" {{ $employeeLanguage->understanding == 'Full Professional Proficiency'  ? 'selected' : '' }}>Full Professional Proficiency</option>
				<option value="Native or Bilingual Proficiency" {{ $employeeLanguage->understanding == 'Native or Bilingual Proficiency'  ? 'selected' : '' }}>Native or Bilingual Proficiency</option>
			</select>
		</div>
	</div>
</div>