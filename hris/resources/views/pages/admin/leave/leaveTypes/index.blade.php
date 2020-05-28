{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Leave Settings - Leave Group Employees')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-pause"></i> Leave Settings</h1>
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
		<h3 class="card-title">leave type list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/leave/leaveTypes/create"><i class="fa fa-plus mr-1"></i> add leave type</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($leaveTypes) > 0)
		<table class="table table-hover table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th>id</th>
					<th>leave name</th>
					<th>leave accrue enabled</th>
					<th>leave carried forward</th>
					<th>leaves per year</th>
					<th>leave group</th>
					<th>actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($leaveTypes as $leaveType)
				<tr>
					<td>{{$leaveType->id}}</td>
					<td>{{$leaveType->leave_accrue}}</td>
					<td>{{$leaveType->carried_forward}}</td>
					<td>{{$leaveType->leaves_per_period}}</td>
					<td>{{$leaveType->leave_group}}</td>
					<td>
						<a href="/hris/pages/admin/leave/leaveTypes/{{$leaveType->id}}/edit"><i class="fa fa-edit"></i></a>
						<form action="/hris/pages/admin/leave/leaveTypes/delete/{{$leaveType->id}}" method="post">
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
		{{$leaveTypes->links()}}
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