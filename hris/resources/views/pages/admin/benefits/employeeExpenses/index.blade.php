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
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-check-circle"></i>{{ $message }}</p>
</div>
@endif
@if($errors->any())
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-exclamation-circle"></i>{{$errors->first()}}</p>
</div>
@endif
<div class="card">
	<div class="card-header">
		<h3 class="card-title">employee expenses list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/benefits/employeeExpenses/create"><i class="fa fa-plus mr-1"></i> add employee expenses</a>
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
							<form action="/hris/pages/admin/benefits/employeeExpenses/updateStatus/{{$employeeExpense->id}}" method="post">
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
							<!-- Button trigger modal -->
							<button type="button" data-toggle="modal" data-target="#modal-{{$employeeExpense->id}}"><i class="fa fa-trash"></i></button>
							<!-- Modal -->
							<div class="modal fade" id="modal-{{$employeeExpense->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-{{$employeeExpense->id}}" aria-hidden="true">
								<div class="modal-dialog" role="document">
									<div class="modal-content">
										<div class="modal-header">
											<h5 class="modal-title">Delete Confirmation</h5>
											<button type="button" class="close" data-dismiss="modal" aria-label="Close">
											<span aria-hidden="true">&times;</span>
											</button>
										</div>
										<div class="modal-body">
											<p>Are you sure you want to delete?</p>
											<hr>
											<form action="/hris/pages/admin/benefits/employeeExpenses/delete/{{$employeeExpense->id}}" method="post" id="form-{{$employeeExpense->id}}">
												@csrf
												@method('DELETE')
												<div class="form-group">
													<label for="upass">Enter Password: </label>
													<input class="form-control" type="password" name="upass" required>
												</div>
											</form>
										</div>
										<div class="modal-footer">
											<button class="btn btn-danger" type="submit" form="form-{{$employeeExpense->id}}"><i class="fa fa-check"></i> Confirm Delete</button>
											<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
										</div>
									</div>
								</div>
							</div>
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