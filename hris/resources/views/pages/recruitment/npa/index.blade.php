{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - NPA')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-columns"></i> Notice of Personnel Actions</h1>
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
		<h3 class="card-title">NPA request list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/recruitment/npa/create"><i class="fa fa-plus mr-1"></i> NPA Request</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($npas) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>Date</th>
						<th>Sender</th>
						<th>Approved by</th>
						<th>status</th>
						<th>actions</th>
					</tr>
				</thead>
				<tbody>
					@foreach($npas as $npa)
					<tr>
						<td>{{date('M d, Y', strtotime($npa->request_date))}}</td>
						<td>
							@if($npa->account_mode == 'user')
							@php
							$user = App\users::find($npa->sender_id);
							@endphp
							@if($user)
							{{ucfirst($user->firstname)}} {{ucfirst($user->lastname)}}
							@else
							----
							@endif
							@else
							{{ucfirst($npa->sender->firstname)}} {{ucfirst($npa->sender->lastname)}}
							@endif
						</td>
						<td>
							@if($npa->approve)
							{{ucfirst($npa->approve->firstname)}} {{ucfirst($npa->approve->lastname)}}
							@else
							----
							@endif
						</td>
						<td>
							@if($npa->status == 0)
							Pending
							@endif
							@if($npa->status == 1)
							Processing
							@endif
							@if($npa->status == 2)
							Approved
							@endif
							@if($npa->status == 3)
							Rejected
							@endif
						</td>
						<td>
							@if($npa->status == 0)
							@if($npa->sender_id == $_SESSION['sys_id'])
							@if(in_array('npa-edit', $_SESSION['sys_permissions']))
							<a class="btn btn-success btn-sm" href="/hris/pages/recruitment/npa/{{$npa->id}}/edit"><i class="fa fa-edit"></i></a>
							@endif
							@if(in_array('npa-delete', $_SESSION['sys_permissions']))
							<!-- Button trigger modal -->
							<button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$npa->id}}" data-name="{{$npa->id}}"><i class="fa fa-trash"></i></button>
							@endif
							@endif
							@endif
							<a class="btn btn-primary btn-sm" href="/hris/pages/recruitment/npa/{{$npa->id}}/show"><i class="fa fa-search"></i></a>
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
		{{$npas->links()}}
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