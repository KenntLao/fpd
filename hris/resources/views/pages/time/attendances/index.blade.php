{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Time Management - Attendance')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-list-alt"></i> Time Management</h1>
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
		<h3 class="card-title">Attendance</h3>
		<div class="card-tools">
			<form action="/hris/pages/time/attendances" method="post">
				@csrf
				<button class="btn add-button btn-md">Punch In</button>
			</form>
		</div>
	</div>
	<div class="card-body">
		@if(count($attendances) > 0)
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>time in</th>
								<th>time out</th>
								<th>note</th>
							</tr>
						</thead>
						<tbody>
							@foreach($attendances as $attendance)
							<tr>
								<td>{{date("M d, Y - h:i:sa", strtotime($attendance->time_in))}}</td>
								<td>
									@if($attendance->time_out)
									{{date("M d, Y - h:i:sa", strtotime($attendance->time_in))}}
									@endif
								</td>
								<td>{{$attendance->note}}</td>
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
		{{$attendances->links()}}
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