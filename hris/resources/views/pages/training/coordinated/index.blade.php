{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Management - My Training Sessions')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-briefcase"></i> Training Management</h1>
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
		<h3 class="card-title">my training sessions</h3>
	</div>
	<div class="card-body">
		@if(count($employeeTrainingSessions) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>training session</th>
						<th>course</th>
						<th>scheduled time</th>
						<th>delivery method</th>
						<th>attendance type</th>
						<th>training certificate required</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($employeeTrainingSessions as $employeeTrainingSession)
					<tr>
						<td>{{$employeeTrainingSession->name}}</td>
						<td>
							@if($employeeTrainingSession->course)
							{{$employeeTrainingSession->course->name}} {{$employeeTrainingSession->course->code}}
							@else
							ERROR
							@endif
						</td>
						<td>{{$employeeTrainingSession->scheduled_time}}</td>
						<td>{{$employeeTrainingSession->delivery_method}}</td>
						<td>{{$employeeTrainingSession->attendance_type}}</td>
						<td>{{$employeeTrainingSession->training_cert_required}}</td>
						<td>
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/coordinated/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
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
		{{$employeeTrainingSessions->links()}}
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop