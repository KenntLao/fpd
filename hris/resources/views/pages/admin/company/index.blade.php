{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Administration - Company Structure')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1>Company Structure</h1>
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
		<h3 class="card-title">company structure list</h3>
		<div class="card-tools">
			<a class="btn btn-danger btn-md" href="/hris/pages/admin/company/create"><i class="fa fa-plus mr-1"></i> add company structure</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($companies) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>name</th>
						<th>address</th>
						<th>type</th>
						<th>country</th>
						<th>time zone</th>
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
							<a href="/hris/pages/admin/company/{{$company->id}}/edit"><i class="fa fa-edit"></i></a>
							<form action="/hris/pages/admin/company/delete/{{$company->id}}" method="post">
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
		@endif()
	</div>
	<div class="card-footer">
		{{#companies->links()}}
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