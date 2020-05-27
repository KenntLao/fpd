{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Training Setup - Training Sessions')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-list-alt"></i> Training Setup</h1>
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
		<h3 class="card-title">training sessions list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/training/trainingSessions/create"><i class="fa fa-plus"></i> add training session</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($trainingSessions) > 0)
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
								<td>
									@if($trainingSession->course)
									{{$trainingSession->course->name}}
									@else
									<span class="td-error">ERROR</span>
									@endif
								</td>
								<td>{{date("M d, Y - h:i:sa", strtotime($trainingSession->scheduled_time))}}</td>
								<td>
									@if($trainingSession->course)
									{{$trainingSession->course->status}}
									@else
									<span class="td-error">ERROR</span>
									@endif
								</td>
								<td>{{$trainingSession->delivery_method}}</td>
								<td>{{$trainingSession->attendance_type}}</td>
								<td>{{$trainingSession->training_cert_required}}</td>
								<td>
									<a href="/hris/pages/admin/training/trainingSessions/{{$trainingSession->id}}/edit"><i class="fa fa-edit"></i></a>
									<form action="/hris/pages/admin/training/trainingSessions/delete/{{$trainingSession->id}}" method="post">
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
			@endif
	</div>
	<div class="card-footer">
		{{$trainingSessions->links()}}
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