{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment Setup - Employment Types')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 offset-md-3 col-md-6 page-title">
		<h1>recruitment setup</h1>
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
	<div class="col-12 offset-md-2 col-md-8 offset-xl-3 col-xl-6 box">
		<div class="row no-gutters">
			<div class="box-title">
				<h3>Employment Types</h3>
			</div>
			<div class="box-add">
				<a href="/pages/recruitment/recruitmentSetup/employmentTypes/create">add <i class="fa fa-plus"></i></a>
			</div>
		</div>
		<div class="box-table">
			@if ( count($employmentTypes) > 0)
			<div class="row no-gutters">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped">
						<thead>
							<tr>
								<th>id</th>
								<th>name</th>
								<th>action</th>
							</tr>
						</thead>
						<tbody>
							@foreach($employmentTypes as $employmentType)
							<tr>
								<td>{{$employmentType->id}}</td>
								<td>{{$employmentType->name}}</td>
								<td>
									<a href="/pages/recruitment/recruitmentSetup/employmentTypes/{{$employmentType->id}}/edit"><i class="fa fa-edit"></i></a>
									<form action="/pages/recruitment/recruitmentSetup/employmentTypes/delete/{{$employmentType->id}}" method="post">
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
			<h5>No data available.</h5>
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
