{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Expense Administration - Employee Expenses')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-bars"></i> Expenses Administration</h1>
	</div>
</div>
@stop
@section('content')
@if (count($errors))
<div class="alert alert-danger">
	<strong>Whoops!</strong> There were some problems with your input.
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
<div class="card">
	<div class="card-header">
		<h3 class="card-title">edit employee expense</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/benefits/employeeExpenses/update/{{$employeeExpense->id}}" enctype="multipart/form-data" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="employee">Employee: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="employee" value="{{$employeeExpense->employee}}" required>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="expense_date">Date: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="date" value="{{$employeeExpense->expense_date}}" name="expense_date" required>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="payment_method">Payment Method: </label>
						<span class="badge badge-danger">Required</span>
						@if(count($paymentMethods) > 0)
						<select class="form-control select2" name="payment_method" required>
							@foreach($paymentMethods as $paymentMethod)
							<option value="{{$paymentMethod->name}}" {{ $employeeExpense->payment_method == $paymentMethod->name  ? 'selected' : '' }}>{{$paymentMethod->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="payment_method" disabled>
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="ref_number">Transaction / Ref No.: </label>
						<input class="form-control" type="text" value="{{$employeeExpense->ref_number}}" name="ref_number">
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="payee">Payee: </label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="payee" value="{{$employeeExpense->payee}}" required>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="payment_method">Expense Category: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="expense_category" required>
						@if(count($expensesCategories) > 0)
							@foreach($expensesCategories as $expensesCategory)
							<option value="{{$expensesCategory->name}}" {{ $employeeExpense->payment_method == $paymentMethod->name  ? 'selected' : '' }}>{{$expensesCategory->name}}</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label for="notes">Notes: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter notes</p>
							<textarea class="form-control" name="notes" required>{{$employeeExpense->notes}}</textarea>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="payment_method">Currency: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2" name="currency" required>
						@if(count($currencies) > 0)
							@foreach($currencies as $currency)
							<option value="{{$currency->code}}">{{$currency->name}} ({{$currency->code}})</option>
							@endforeach
						@else
							<option value="None">None</option>
						@endif
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label for="amount">Amount: </label>
						<input class="form-control" type="text" name="amount" value="{{$employeeExpense->amount}}" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label for="receipt">Receipt: </label>
						<input class="form-control" type="file" name="receipt">
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label for="attachment_1">Attachment #1: </label>
						<input class="form-control" type="file" name="attachment_1">
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label for="attachment_2">Attachment #2: </label>
						<input class="form-control" type="file" name="attachment_2">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/benefits/employeeExpense/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save employee expense</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop