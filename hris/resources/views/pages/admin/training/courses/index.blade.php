{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Courses')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 offset-md-2 col-md-8 page-title">
		<h1>Training Setup</h1>
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
				<h3>Courses</h3>
			</div>
			<div class="box-add">
				<a href="/pages/admin/training/courses/create">add <i class="fa fa-plus"></i></a>
			</div>
		</div>
		<div class="box-table">
			@if(count($courses) > 0)
			<div class="row no-gutters">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>code</td>
								<th>name</th>
								<th>coordinator</th>
								<th>trainer</th>
								<th>payment type</th>
								<th>actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($courses as $course)
							<tr>
								<td>{{$course->code}}</td>
								<td>{{$course->name}}</td>
								<td>{{$course->coordinator}}</td>
								<td>{{$course->trainer}}</td>
								<td>{{$course->payment_type}}</td>
								<td>
									<a href="/pages/admin/training/courses/{{$course->id}}/edit"><i class="fa fa-edit"></i></a>
									<form action="/pages/admin/training/courses/delete/{{$course->id}}" method="post">
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