{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - PRF')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-columns"></i> recruitment</h1>
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
		<h3 class="card-title">Prf request list</h3>
		<div class="card-tools">
			@if(in_array($manager_om_id, $employee_ids) OR in_array($op_assistant_id, $employee_ids))
			<a class="btn add-button btn-md" href="/hris/pages/recruitment/prf/create"><i class="fa fa-plus mr-1"></i> Request</a>
			@endif
		</div>
	</div>
	<div class="card-body">
		@if(count($prfs) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>Control No.</th>
						<th>Requested By</th>
						<th>Department</th>
						<th>Date Filed</th>
						<th>Reason</th>
						<th>Status</th>
						<th>Availability</th>
						<th>Action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($prfs as $prf)
					<tr>
						<td>{{$prf->control_no}}</td>
						<td>
							@if(isset($prf->employee->firstname))
							{{$prf->employee->firstname}} {{$prf->employee->lastname}}
							@else
							--
							@endif
						</td>
						<td>
							@if(isset($prf->department->name))
							{{$prf->department->name}}
							@else
							--
							@endif
						</td>
						<td>{{$prf->date_filed}}</td>
						<td>{{$prf->reason}}</td>
						<td>
							@if($prf->initial_status == 0)
							<span class="badge badge-warning p-2">Pending</span>
							@elseif($prf->initial_status == 1)
							<span class="badge badge-primary p-2">Processing</span>
							@elseif($prf->initial_status == 2)
							<span class="badge badge-success p-2">Approved</span>
							@elseif($prf->initial_status == 3)
							<span class="badge badge-danger p-2">Rejected</span>
							@endif
						</td>
						<td>
							@if($prf->close_status == 0)
								<span class="badge badge-warning p-2">Open</span>
							@elseif($prf->close_status == 1)
								<span class="badge badge-primary p-2">Processing</span>
							@else
								<span class="badge badge-success p-2">Closed</span>
							@endif
						</td>
						<td>
							<!-- IF CURRENT USER IS OM -->
							@if($prf->employee_id == $_SESSION['sys_id'])
								<!-- IF PENDING -->
								@if($prf->initial_status == 0)
									<a class="btn btn-success btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/edit"><i class="fa fa-edit"></i></a>
								<!-- IF PROCESSING -->
								@elseif($prf->initial_status == 1)
									<a class="btn btn-warning btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/show"><i class="fa fa-search"></i></a>
								<!-- IF HR APPROVED -->
								@elseif($prf->initial_status == 2)
									<a class="btn btn-success btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/showFinal"><i class="fa fa-search"></i></a>
								<!-- IF REJECTED -->
								@else
								<a class="btn btn-warning btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/show"><i class="fa fa-search"></i></a>
								@endif
							<!-- IF CURRENT USER IS DIRECTOR -->
							@elseif($prf->supervisor_id == $_SESSION['sys_id'])
							<!-- IF PENDING -->
								@if($prf->initial_status == 0)
									<a class="btn btn-warning btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/show"><i class="fa fa-search"></i></a>
								<!-- IF PROCESSING -->
								@elseif($prf->initial_status == 1)
									<a class="btn btn-warning btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/show"><i class="fa fa-search"></i></a>
								<!-- IF HR APPROVED -->
								@elseif($prf->initial_status == 2)
									<a class="btn btn-success btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/showFinal"><i class="fa fa-search"></i></a>
								<!-- IF REJECTED -->
								@else
									<a class="btn btn-warning btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/show"><i class="fa fa-search"></i></a>
								@endif
							<!-- IF CURRENT USER IS HR RECRUITMENT -->
							@else
								<!-- IF PROCESSING -->
								@if($prf->initial_status == 1)
									<a class="btn btn-warning btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/show"><i class="fa fa-search"></i></a>
								<!-- IF HR APPROVED -->
								@elseif($prf->initial_status == 2)
									<a class="btn btn-success btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/showFinal"><i class="fa fa-search"></i></a>
								<!-- IF REJECTED -->
								@else
								<a class="btn btn-warning btn-sm" href="/hris/pages/recruitment/prf/{{$prf->id}}/show"><i class="fa fa-search"></i></a>
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
	<div class="card-footer text-right">
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
	$(document).ready(function() {
		$('.delete-btn').on('click', function() {
			var get = $('.add-button').attr('href');
			var href = get.replace('create', 'delete');
			var target = $(this).attr('data-target');
			var modal_id = target.replace('#', '');
			var id = target.replace('#modal-', '');
			$('.modal').attr('id', modal_id);
			$('.modal').attr('aria-labelledby', modal_id);
			$('.form-horizontal').attr('action', href + '/' + id);
			$('.form-horizontal').attr('id', 'form-' + id);
			$('.modal-footer > button').attr('form', 'form-' + id);
			var name = $(this).attr('data-name');
			$('.data-name').text('Are you sure you want to delete ' + name + '?');
		});
	});
</script>
@stop