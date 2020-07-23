{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Leave Settings - Leave Types')
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
@if($errors->any())
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-exclamation-circle"></i>{{$errors->first()}}</p>
</div>
@endif
<div class="card">
	<div class="card-header">
		<h3 class="card-title">leave type list</h3>
		@if(in_array('leave-type-add', $_SESSION['sys_permissions']))
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/leave/leaveTypes/create"><i class="fa fa-plus mr-1"></i> add leave type</a>
		</div>
		@endif
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
					@if(in_array('leave-type-edit', $_SESSION['sys_permissions']) OR in_array('leave-type-edit', $_SESSION['sys_permissions']))
					<th>actions</th>
					@endif
				</tr>
			</thead>
			<tbody>
				@foreach($leaveTypes as $leaveType)
				<tr>
					<td>{{$leaveType->id}}</td>
					<td>{{$leaveType->name}}</td>
					<td>{{$leaveType->leave_accrue}}</td>
					<td>{{$leaveType->carried_forward}}</td>
					<td>{{$leaveType->leaves_per_period}}</td>
					<td>
						@if($leaveType->leave_group)
						{{$leaveType->leave_group->name}}
						@else
						None
						@endif
					</td>
					@if(in_array('leave-type-edit', $_SESSION['sys_permissions']) OR in_array('leave-type-edit', $_SESSION['sys_permissions']))
					<td class="td-action">
						<div class="row no-gutters">
							@if(in_array('leave-type-edit', $_SESSION['sys_permissions']))
							<div class="col-6">
								<a class="btn btn-success btn-sm" href="/hris/pages/admin/leave/leaveTypes/{{$leaveType->id}}/edit"><i class="fa fa-edit"></i></a>
							</div>
							@endif
							@if(in_array('leave-type-delete', $_SESSION['sys_permissions']))
							<div class="col-6">
								<!-- Button trigger modal -->
								<button class="btn btn-danger btn-sm delete-btn" type="button" data-toggle="modal" data-target="#modal-{{$leaveType->id}}" data-name="{{$leaveType->name}}"><i class="fa fa-trash"></i></button>
							</div>
							@endif
						</div>
					</td>
					@endif
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
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title">Delete Confirmation</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<p class="data-name"></p>
				<hr>
				<form class="form-horizontal" method="post">
					@csrf
					@method('DELETE')
					<div class="form-group">
						<label for="upass">Enter Password: </label>
						<input class="form-control" type="password" name="upass" required>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-danger" type="submit"><i class="fa fa-check"></i> Confirm Delete</button>
				<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
			</div>
		</div>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
	$(document).ready(function(){
		$('.delete-btn').on('click', function(){
			var get = $('.add-button').attr('href');
			var href = get.replace('create', 'delete');
			var target = $(this).attr('data-target');
			var modal_id = target.replace('#', '');
			var id = target.replace('#modal-', '');
			$('.modal').attr('id', modal_id);
			$('.modal').attr('aria-labelledby', modal_id);
			$('.form-horizontal').attr('action', href+'/'+id);
			$('.form-horizontal').attr('id', 'form-'+id);
			$('.modal-footer > button').attr('form', 'form-'+id);
			var name = $(this).attr('data-name');
			$('.data-name').text('Are you sure you want to delete '+name+'?');
		});
	});
</script>
@stop