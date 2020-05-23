{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Expense Administration - Employee Expenses')
@section('content_header')
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
		<h3 class="card-title">add employee expense</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/pages/admin/benefits/employeeExpenses" enctype="multipart/form-data" id="form">
			@csrf
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="employee">Employee</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="employee" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="expense_date">Date</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="date" name="expense_date" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="payment_method">Payment Method</label>
						<span class="badge badge-danger">Required</span>
						@if(count($paymentMethods) > 0)
						<select class="form-control select2" name="payment_method" required>
							@foreach($paymentMethods as $paymentMethod)
							<option value="{{$paymentMethod->name}}">{{$paymentMethod->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="payment_method" disabled>
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="ref_number">Transaction / Ref No. : </label>
						<input class="form-control" type="text" name="ref_number">
					</div>
				</div>
			</div>
			<div class="row">
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="payee">Payee</label>
						<span class="badge badge-danger">Required</span>
						<input class="form-control" type="text" name="payee" required>
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="payment_method">Expense Category</label>
						<span class="badge badge-danger">Required</span>
						@if(count($expensesCategories) > 0)
						<select class="form-control select2" name="expense_category" required>
							@foreach($expensesCategories as $expensesCategory)
							<option value="{{$expensesCategory->name}}">{{$expensesCategory->name}}</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="expense_category" disabled>
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-6">
					<div class="form-group">
						<label for="notes">Notes</label>
						<span class="badge badge-danger">Required</span>
						<textarea class="form-control" name="notes" required></textarea>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-3">
					<div class="form-group">
						<label for="payment_method">Currency</label>
						<span class="badge badge-danger">Required</span>
						@if(count($currencies) > 0)
						<select class="form-control select2" name="currency" required>
							@foreach($currencies as $currency)
							<option value="{{$currency->code}}">{{$currency->name}} ({{$currency->code}})</option>
							@endforeach
						</select>
						@else
						<select class="form-control select2" name="currency" disabled>
							<option value="None">None</option>
						</select>
						@endif
					</div>
				</div>
				<div class="col-3">
					<div class="form-group">
						<label for="amount">Amount</label>
						<input class="form-control" type="text" name="amount" required>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-4">
					<div class="form-group">
						<label for="receipt">Receipt: </label>
						<input class="form-control" type="file" name="receipt">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="attachment_1">Attachment #1: </label>
						<input class="form-control" type="file" name="attachment_1">
					</div>
				</div>
				<div class="col-4">
					<div class="form-group">
						<label for="attachment_2">Attachment #2: </label>
						<input class="form-control" type="file" name="attachment_2">
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/benefits/employeeExpenses/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-primary" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save employee expense</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
$(document).ready(function() {
$('.select2').select2();
});
</script>
@stop