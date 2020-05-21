{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Training Sessions')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 offset-md-1 col-md-10 page-title">
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
	<div class="col-12 offset-md-1 col-md-10 box">
		<div class="row no-gutters">
			<div class="box-title">
				<h3>Training Sessions</h3>
			</div>
			<div class="box-add">
				<a href="/pages/admin/training/trainingSessions/create">add <i class="fa fa-plus"></i></a>
			</div>
		</div>
		<div class="box-table">
			@if(count($trainingSessions) > 0)
			<div class="row no-gutters">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>name</th>
								<th>course</th>
								<th>scheduled time</th>
								<th>status</th>
								<th>delivery method</th>
								<th>attendance type</th>
								<th>training certificate required</th>
								<th>actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($trainingSessions as $trainingSession)
							<tr>
								<td>{{$trainingSession->name}}</td>
								<td>{{$trainingSession->course->name}}</td>
								<td>{{$trainingSession->scheduled_time}}</td>
								<td>{{$trainingSession->course->status}}</td>
								<td>{{$trainingSession->delivery_method}}</td>
								<td>{{$trainingSession->attendance_type}}</td>
								<td>{{$trainingSession->training_cert_required}}</td>
								<td>
									<a href="/pages/admin/training/trainingSessions/{{$trainingSession->id}}/edit"><i class="fa fa-edit"></i></a>
									<form action="/pages/admin/training/trainingSessions/delete/{{$trainingSession->id}}" method="post">
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