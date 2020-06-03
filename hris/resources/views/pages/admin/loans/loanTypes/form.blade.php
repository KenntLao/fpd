@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Name: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<input class="form-control required" type="text" name="name" value="{{old('name') ?? $loanType->name}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Details: </label>
			<div class="input">
				<p class="placeholder">Enter name</p>
				<textarea class="form-control required" name="details">{{old('details') ?? $loanType->details}}</textarea>
			</div>
		</div>
	</div>
</div>