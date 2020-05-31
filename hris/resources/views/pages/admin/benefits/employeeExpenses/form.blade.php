@csrf
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="employee">Employee: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter employee name</p>
				<input class="form-control required" type="text" name="employee" value="{{old('employee') ?? $employeeExpense->employee}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="expense_date">Date: </label>
			<span class="badge badge-danger">Required</span>
			<input class="form-control required" type="date" name="expense_date" value="{{old('expense_date') ?? $employeeExpense->expense_date}}" required>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="payment_method">Payment Method: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="payment_method" required>
				@if(count($paymentMethods) > 0)
				<option value="None" {{ $employeeExpense->payment_method == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($paymentMethods as $paymentMethod)
				<option value="{{$paymentMethod->name}}" {{ $employeeExpense->payment_method == $paymentMethod->name  ? 'selected' : '' }}>{{$paymentMethod->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="ref_number">Transaction / Ref No.: </label>
			<div class="input">
				<p class="placeholder">Enter transaction / ref no.</p>
				<input class="form-control required" type="text" name="ref_number" value="{{old('ref_number') ?? $employeeExpense->ref_number}}">
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="payee">Payee: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter payee</p>
				<input class="form-control required" type="text" name="payee" value="{{old('payee') ?? $employeeExpense->payee}}" required>
			</div>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="payment_method">Expense Category: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="expense_category" required>
				@if(count($expensesCategories) > 0)
				<option value="None" {{ $employeeExpense->expense_category == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($expensesCategories as $expensesCategory)
				<option value="{{$expensesCategory->name}}" {{ $employeeExpense->expense_category == $expensesCategory  ? 'selected' : '' }}>{{$expensesCategory->name}}</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6">
		<div class="form-group">
			<label class="mr-2" for="notes">Notes: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter notes</p>
				<textarea class="form-control required" name="notes" required>{{old('notes') ?? $employeeExpense->notes}}</textarea>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="payment_method">Currency: </label>
			<span class="badge badge-danger">Required</span>
			<select class="form-control required select2" name="currency" required>
				@if(count($currencies) > 0)
				<option value="None" {{ $employeeExpense->currency == 'None'  ? 'selected' : '' }}>None</option>
				@foreach($currencies as $currency)
				<option value="{{$currency->code}}" {{ $employeeExpense->currency == $currency->code  ? 'selected' : '' }}>{{$currency->name}} ({{$currency->code}})</option>
				@endforeach
				@else
				<option value="None">None</option>
				@endif
			</select>
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-3">
		<div class="form-group">
			<label class="mr-2" for="amount">Amount: </label>
			<span class="badge badge-danger">Required</span>
			<div class="input">
				<p class="placeholder">Enter amount</p>
				<input class="form-control required" type="text" name="amount" value="{{old('amount') ?? $employeeExpense->amount}}" required>
			</div>
		</div>
	</div>
</div>
<div class="row">
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="receipt">Receipt: </label>
			<input class="form-control required" type="file" name="receipt">
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="attachment_1">Attachment #1: </label>
			<input class="form-control required" type="file" name="attachment_1">
		</div>
	</div>
	<div class="col-12 col-md-6 col-xl-4">
		<div class="form-group">
			<label class="mr-2" for="attachment_2">Attachment #2: </label>
			<input class="form-control required" type="file" name="attachment_2">
		</div>
	</div>
</div>