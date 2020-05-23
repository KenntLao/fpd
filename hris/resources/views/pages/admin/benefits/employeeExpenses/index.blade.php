{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Expense Administration - Employee Expenses')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1>Expenses Administration</h1>
	</div>
</div>
@stop
@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-check-circle"></i>{{ $message }}</p>
</div>
@endif
<div class="card">
	<div class="card-header">
		<h3 class="card-title">employee expenses list</h3>
		<div class="card-tools">
			<a class="btn btn-danger btn-md" href="/hris/pages/admin/benefits/employeeExpenses/create"><i class="fa fa-plus mr-1"></i> add employee expenses</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($employeeExpenses) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>employee</th>
						<th>date</th>
						<th>payment method</th>
						<th>payee</th>
						<th>category</th>
						<th>amount</th>
						<th>currency</th>
						<th>status</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($employeeExpenses as $employeeExpense)
					<tr>
						<td>{{$employeeExpense->employee}}</td>
						<td>{{$employeeExpense->expense_date}}</td>
						<td>{{$employeeExpense->payment_method}}</td>
						<td>{{$employeeExpense->payee}}</td>
						<td>{{$employeeExpense->expense_category}}</td>
						<td>{{$employeeExpense->amount}}</td>
						<td>{{$employeeExpense->currency}}</td>
						<td>{{$employeeExpense->status}}</td>
						<td>
							<a href="/hris/pages/admin/benefits/employeeExpenses/{{$employeeExpense->id}}/edit"><i class="fa fa-edit"></i></a>
							<form action="/hris/pages/admin/expense/employeeExpenses/updateStatus/{{$employeeExpense->id}}" method="post">
								@csrf
								@method('PATCH')
								<input type="text" name="status" value="Approved" hidden>
								<button class="btn-check" type="submit" title="Approve status."><i class="fa fa-check-square"></i></button>
							</form>
							<form action="/hris/pages/admin/benefits/employeeExpenses/updateStatus/{{$employeeExpense->id}}" method="post">
								@csrf
								@method('PATCH')
								<input type="text" name="status" value="Rejected" hidden>
								<button class="btn-x" type="submit" title="Reject status."><i class="fa fa-window-close"></i></button>
							</form>
							<form action="/hris/pages/admin/benefits/employeeExpenses/delete/{{$employeeExpense->id}}" method="post">
								@csrf
								@method('DELETE')
								<button type="submit"><i class="fa fa-trash"></i></button>
							</form>
						</td>
					</tr>
					@endforeach
				</tbody>
			</table>
		</div>
		@else
		<h4>No data available.</h4>
		@endif
	</div>
	<div class="card-footer">
		{{$employeeExpenses->links()}}
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
console.log('Hi!');
</script>
@stop