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
		@if(in_array('employee-expense-add', $_SESSION['sys_permissions']))
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/benefits/employeeExpenses/create"><i class="fa fa-plus mr-1"></i> add employee expenses</a>
		</div>
		@endif
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
						@if(in_array('employee-expense-edit', $_SESSION['sys_permissions']) OR in_array('employee-expense-delete', $_SESSION['sys_permissions']))
						<th>actions</th>
						@endif
					</tr>
				</thead>
				<tbody>
					@foreach($employeeExpenses as $employeeExpense)
					<tr>
						<td>
							@if($employeeExpense->employee)
							{{$employeeExpense->employee->firstname}} {{$employeeExpense->employee->lastname}}
							@else
							<span class="td-error">ERROR</span>
							@endif
						</td>
						<td>{{date('M d, Y', strtotime($employeeExpense->expense_date))}}</td>
						<td>
							@if($employeeExpense->payment_method)
							{{$employeeExpense->payment_method->name}}
							@else
							<span class="td-error">ERROR</span>
							@endif
						</td>
						<td>{{$employeeExpense->payee}}</td>
						<td>
							@if($employeeExpense->expense_category)
							{{$employeeExpense->expense_category->name}}
							@else
							<span class="td-error">ERROR</span>
							@endif
						</td>
						<td>{{$employeeExpense->amount}}</td>
						<td>{{$employeeExpense->currency}}</td>
						<td>
                            @if($employeeExpense->status == '0')
                            Pending
                            @endif
                            @if($employeeExpense->status == '1')
                            Approved
                            @endif
                            @if($employeeExpense->status == '2')
                            Denied
                            @endif
                        </td>
                        @if(in_array('employee-expense-edit', $_SESSION['sys_permissions']) OR in_array('employee-expense-delete', $_SESSION['sys_permissions']))
						<td>
							<div class="row no-gutters">
								@if($employeeExpense->status == '1' OR $employeeExpense->status == '2')
								<div class="col-12">
									<a class="btn btn-info btn-sm" href="/hris/pages/admin/benefits/employeeExpenses/{{$employeeExpense->id}}/show"><i class="fa fa-search"></i></a>
								</div>
								@else
								<div class="action-col">
									<a class="btn btn-info btn-sm" href="/hris/pages/admin/benefits/employeeExpenses/{{$employeeExpense->id}}/show"><i class="fa fa-search"></i></a>
								</div>
								@if(in_array('employee-expense-edit', $_SESSION['sys_permissions']))
								<div class="action-col">
									<a class="btn btn-success btn-sm" href="/hris/pages/admin/benefits/employeeExpenses/{{$employeeExpense->id}}/edit"><i class="fa fa-edit"></i></a>
								</div>
								@endif
								<div class="action-col">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/admin/benefits/employeeExpenses/updateStatus/1/{{$employeeExpense->id}}" title="Approve employee expense."><i class="fas fa-check-square"></i></a>
								</div>
								<div class="action-col">
                                    <a class="btn btn-warning btn-sm" href="/hris/pages/admin/benefits/employeeExpenses/updateStatus/2/{{$employeeExpense->id}}" title="Deny employee expense."><i class="fas fa-times"></i></a>
								</div>
								@if(in_array('employee-expense-delete', $_SESSION['sys_permissions']))
								<div class="action-col">
									<!-- Button trigger modal -->
									<button class="btn btn-danger btn-sm delete-btn" type="button" data-toggle="modal" data-target="#modal-{{$employeeExpense->id}}" data-name="Employee Expense no. {{$employeeExpense->id}}"><i class="fa fa-trash"></i></button>
								</div>
								@endif
								@endif
							</div>
						</td>
                        @endif
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="data-name"></p>
				<hr>
				<form class="form-horizontal" method="post">
					@csrf
					@method('DELETE')
					<div class="form-group">
						<label for="upass">Enter Password: </label>
						<input class="form-control" type="password" name="upass" required>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" type="submit"><i class="fa fa-check"></i> Confirm Delete</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			</div>
		</div>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
	$(document).ready(function(){
		$('.delete-btn').on('click', function(){
			var get = $('.add-button').attr('href');
			var href = get.replace('create', 'delete');
			var target = $(this).attr('data-target');
			var modal_id = target.replace('#', '');
			var id = target.replace('#modal-', '');
			$('.modal').attr('id', modal_id);
			$('.modal').attr('aria-labelledby', modal_id);
			$('.form-horizontal').attr('action', href+'/'+id);
			$('.form-horizontal').attr('id', 'form-'+id);
			$('.modal-footer > button').attr('form', 'form-'+id);
			var name = $(this).attr('data-name');
			$('.data-name').text('Are you sure you want to delete '+name+'?');
		});
	});
</script>
@stop