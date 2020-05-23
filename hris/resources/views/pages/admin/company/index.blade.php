{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Administration - Company Structure')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 offset-md-2 col-md-8 page-title">
		<h1>Company Structure</h1>
	</div>
</div>
@stop
@section('content')
<div class="row no-gutters">
	@if ($message = Session::get('success'))
	<div class="alert alert-success alert-block">
	    <button type="button" class="close" data-dismiss="alert">×</button>
	    <p><i class="fas fa-fw fa-check-circle"></i>{{ $message }}</p>
	</div>
	@endif
	<div class="col-12 offset-md-2 col-md-8 box">
		<div class="row no-gutters">
			<div class="box-title">
				<h3>Departments</h3>
			</div>
			<div class="box-add">
				<a href="/pages/admin/company/create">add <i class="fa fa-plus"></i></a>
			</div>
		</div>
		<div class="box-table">
			@if(count($companies) > 0)
			<div class="row no-gutters">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>name</td>
								<th>address</th>
								<th>type</th>
								<th>country</th>
								<th>time zone</td>
								<th>parent structure</th>
								<th>actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($companies as $company)
							<tr>
								<td>{{$company->name}}</td>
								<td>{{$company->address}}</td>
								<td>{{$company->type}}</td>
								<td>{{$company->country}}</td>
								<td>{{$company->timezone}}</td>
								<td>{{$company->parent_structure}}</td>
								<td>
									<a href="/pages/admin/company/{{$company->id}}/edit"><i class="fa fa-edit"></i></a>
									<form action="/pages/admin/company/delete/{{$company->id}}" method="post">
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
			</div>
			@else
			<h5>No Data Available.</h5>
			@endif
		</div>
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