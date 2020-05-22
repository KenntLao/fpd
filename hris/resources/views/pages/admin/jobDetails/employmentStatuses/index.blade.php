{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Employment Status')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1>Job Details Setup</h1>
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
		<h3 class="card-title">employment status list</h3>
		<div class="card-tools">
			<a class="btn btn-danger btn-md" href="/hris/pages/admin/jobDetails/employmentStatuses/create"><i class="fa fa-plus mr-1"></i> add employment status</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($employmentStatuses) > 0)
		<table class="table table-hover table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th>id</th>
					<th>name</th>
					<th>description</th>
					<th>actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($employmentStatuses as $employmentStatus)
				<tr>
					<td>{{$employmentStatus->id}}</td>
					<td>{{$employmentStatus->name}}</td>
					<td>{{$employmentStatus->description}}</td>
					<td>
						<a href="/hris/pages/admin/jobDetails/employmentStatuses/{{$employmentStatus->id}}/edit"><i class="fa fa-edit"></i></a>
						<form action="/hris/pages/admin/jobDetails/employmentStatuses/delete/{{$employmentStatus->id}}" method="post">
							@csrf
							@method('DELETE')
							<button type="submit"><i class="fa fa-trash"></i></button>
						</form>
					</td>
				</tr>
				@endforeach
			</tbody>
		</table>
		@else
		<h4>No data available.</h4>
		@endif
	</div>
	<div class="card-footer">
		{{$employmentStatuses->links()}}
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