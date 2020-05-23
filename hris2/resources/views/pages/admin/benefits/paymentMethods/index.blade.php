{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Expense Administration - Payment Methods')
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
		<h3 class="card-title">payment methods list</h3>
		<div class="card-tools">
			<a class="btn btn-danger btn-md" href="/hris/pages/admin/benefits/paymentMethods/create"><i class="fa fa-plus mr-1"></i> add payment method</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($paymentMethods) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>name</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($paymentMethods as $paymentMethod)
					<tr>
						<td>{{$paymentMethod->name}}</td>
						<td>
							<a href="/hris/pages/admin/benefits/paymentMethods/{{$paymentMethod->id}}/edit"><i class="fa fa-edit"></i></a>
							<form action="/hris/pages/admin/benefits/paymentMethods/delete/{{$paymentMethod->id}}" method="post">
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
		<h4>No data Available.</h4>
		@endif
	</div>
	<div class="card-footer">
		{{$paymentMethods->links()}}
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