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
						<th>status</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($employeeTrainingSessions as $employeeTrainingSession)
					<tr>
						<td>{{$employeeTrainingSession->training_session->name}}</td>
						<td>
							@if($employeeTrainingSession->status == 0)
							Scheduled
							@endif
							@if($employeeTrainingSession->status == 1)
							Attended
							@endif
							@if($employeeTrainingSession->status == 2)
							Not Attended
							@endif
							@if($employeeTrainingSession->status == 3)
							Pending
							@endif
						</td>
						<td>
							@if($employeeTrainingSession->training_session->attendance_type == 'Sign Up')
							@if($employeeTrainingSession->signup == '0')
							<a class="btn btn-warning btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/signup" title="Sign Up"><i class="fa fa-sign-in-alt"></i></a>
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
							@else
							@if($employeeTrainingSession->status == 0)
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
							<a class="btn btn-success btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/complete" title="Completed"><i class="fa fa-check-square"></i></a>
							<a class="btn btn-danger btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/notAttended" title="Not Attended"><i class="fa fa-times"></i></a>
							@endif
							@if($employeeTrainingSession->status == 1 OR $employeeTrainingSession->status == 2)
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
							@endif
							@if($employeeTrainingSession->status == 3)
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
							<a class="btn btn-warning btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/edit" title="View"><i class="fa fa-edit"></i></a>
							@endif
							@endif
							@else
							@if($employeeTrainingSession->status == 0)
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
							<a class="btn btn-success btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/complete" title="Completed"><i class="fa fa-check-square"></i></a>
							<a class="btn btn-danger btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/notAttended" title="Not Attended"><i class="fa fa-times"></i></a>
							@endif
							@if($employeeTrainingSession->status == 1 OR $employeeTrainingSession->status == 2)
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
							@endif
							@if($employeeTrainingSession->status == 3)
							<a class="btn btn-primary btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/show" title="View"><i class="fa fa-search"></i></a>
							<a class="btn btn-warning btn-sm" href="/hris/pages/training/myTraining/{{$employeeTrainingSession->id}}/edit" title="View"><i class="fa fa-edit"></i></a>
							@endif
							@endif
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