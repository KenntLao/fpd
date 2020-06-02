{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Overtime Administration - Requests')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-align-center"></i> Overtime Administration</h1>
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
		<h3 class="card-title">request list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/overtime/overtimeRequests/create"><i class="fa fa-plus mr-1"></i> add overtime request</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($overtimeRequests) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>employee</th>
						<th>category</th>
						<th>start time</th>
						<th>end time</th>
						<th>project</th>
						<th>status</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($overtimeRequests as $overtimeRequest)
					<tr>
						<td>{{$overtimeRequest->employee}}</td>
						<td>{{$overtimeRequest->category}}</td>
						<td>{{$overtimeRequest->start_time}}</td>
						<td>{{$overtimeRequest->end_time}}</td>
						<td>{{$overtimeRequest->project}}</td>
						<td>{{$overtimeRequest->status}}</td>
						<td>
							<a href="/hris/pages/admin/overtime/overtimeRequests/{{$overtimeRequest->id}}/edit"><i class="fa fa-edit"></i></a>
							<form action="/hris/pages/admin/overtime/overtimeRequests/updateStatus/{{$overtimeRequest->id}}" method="post">
								@csrf
								@method('PATCH')
								<input type="text" name="status" value="Approved" hidden>
								<button class="btn-check" type="submit" title="Approve status."><i class="fa fa-check-square"></i></button>
							</form>
							<form action="/hris/pages/admin/overtime/overtimeRequests/updateStatus/{{$overtimeRequest->id}}" method="post">
								@csrf
								@method('PATCH')
								<input type="text" name="status" value="Rejected" hidden>
								<button class="btn-x" type="submit" title="Reject status."><i class="fa fa-window-close"></i></button>
							</form>
							<form action="/hris/pages/admin/overtime/overtimeRequests/delete/{{$overtimeRequest->id}}" method="post">
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
		{{$overtimeRequests->links()}}
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