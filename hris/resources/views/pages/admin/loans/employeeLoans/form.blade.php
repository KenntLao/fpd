@csrf
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="name">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="employee_id" required>
				@if (count($employees) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($employees as $employee)
				<option value="{{$employee->id}}" {{ $employeeLoan->employee_id == $employee->id  ? 'selected' : '' }}>{{$employee->firstname}} {{$employee->lastname}}</option>
				@endforeach
				@else
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="type">Loan Type: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="type_id" required>
				@if(count($types) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($types as $type)
				<option value="{{$type->id}}" {{ $employeeLoan->type == $type->name  ? 'selected' : '' }}>{{$type->name}}</option>
				@endforeach
				@else 
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="loan_start_date">Loan Start Date: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="date" name="loan_start_date" value="{{old('loan_start_date') ?? $employeeLoan->loan_start_date}}" required>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="last_installment_date">Last Installment Date: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="date" name="last_installment_date" value="{{old('last_installment_date') ?? $employeeLoan->last_installment_date}}" required>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="loan_period">Loan Period: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Loan Period (Months)</p>
				<input class="form-control required" type="text" name="loan_period" value="{{old('loan_period') ?? $employeeLoan->loan_period}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="type">Currency: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="currency" required>
				@if(count($currencies) > 0)
				<option disabled default selected>--select one--</option>
				@foreach($currencies as $currency)
				<option value="{{$currency->name}}" {{ $employeeLoan->currency == $currency->name  ? 'selected' : '' }}>{{$currency->name}}</option>
				@endforeach
				@else 
				<option disabled default selected>--select one--</option>
				@endif
			</select>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="loan_period">Loan Amount: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Loan Amount</p>
				<input class="form-control required" type="text" name="loan_amount" value="{{old('loan_amount') ?? $employeeLoan->loan_amount}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="loan_period">Monthly Installment: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter Monthly Installment</p>
				<input class="form-control required" type="text" name="monthly_installment" value="{{old('monthly_installment') ?? $employeeLoan->monthly_installment}}" required>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="status">Status: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="status">
				<option value="Approved" {{ $employeeLoan->status == 'Approved'  ? 'selected' : '' }}>Approved</option>
				<option value="Paid" {{ $employeeLoan->status == 'Paid'  ? 'selected' : '' }}>Paid</option>
				<option value="Suspended" {{ $employeeLoan->status == 'Suspended'  ? 'selected' : '' }}>Suspended</option>
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="status">Details: </label>
			<div class="input">
				<p class="placeholder">Enter details</p>
				<textarea class="form-control required">{{old('details') ?? $employeeLoan->details}}</textarea>
			</div>
		</div>
	</div>
</div>
