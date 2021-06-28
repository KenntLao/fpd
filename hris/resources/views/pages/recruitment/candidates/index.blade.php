{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - Candidates')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-user-friends"></i> recruitment</h1>
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

@if ($message = Session::get('error'))
<div class="alert alert-success alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-check-circle"></i>{!! $message !!}</p>
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
		<h3 class="card-title">candidates list</h3>
		@if(in_array('candidate-add', $_SESSION['sys_permissions']))
		<div class="card-tools">
			<form class="float-right ml-2" action="/hris/pages/recruitment/candidates/import" method="post" enctype="multipart/form-data">
				@csrf
				<input type="file" name="candidateData" id="file" style="display:none;" onchange="this.form.submit()">
				<button class="btn add-button btn-md" type="button" id="upload-exc" name="button" onclick="thisFileUpload();"><i class="far fa-file-excel mr-1"></i> Upload Excel</button>
			</form>
			<!--<a class="btn add-button btn-md" href="/hris/pages/recruitment/candidates/create"><i class="fa fa-plus mr-1"></i> add candidate</a>-->
		</div>
		@endif
	</div>
	<div class="card-body">
		@if(count($candidates) > 0)
		<div class="table-responsive">
			<!-- If current user is hr recruitment-->
			@if(in_array($hr_recruitment_id,$employee_ids))
			<table class="table table-hover table-bordered table-striped table-condensed table-data">
				<thead>
					<tr>
						<th>PRF</th>
						<th>position</th>
						<th>Name</th>
						<th>Status</th>
						<th>Status Date</th>
						<th>Manager</th>
						<th>Assigned Date</th>
						<th>Result</th>
						<th>Result Date</th>
						<th>Date</th>
						<th>file</th>
					</tr>
				</thead>
				<tbody>
					@foreach($candidates as $candidate)
					<tr>
						<td>
							@if($candidate->status == 7)
								@if($candidate->prf_id != NULL)
									@php
										$selected_prf = \App\hris_prf::where('id',$candidate->prf_id)->first();
									@endphp
									<a href="/hris/pages/recruitment/prf/{{$selected_prf->id}}/showFinal">{{$selected_prf->control_no}}</a>
								@else 
								---
								@endif
							@else
								---
							@endif
						</td>
						<td>{{$candidate->careers_app_position}}</td>
						<td><a href="/hris/pages/recruitment/candidates/show/{{$candidate->id}}">{{$candidate->careers_app_fname}} {{$candidate->careers_app_lname}}</a></td>
						@if($candidate->status != 7)
						<td style="width: 15%">
							@if(in_array($hr_recruitment_id,$employee_ids))
							<select data-id="{{$candidate->id}}" class="form-control candidate_status" name="status">
								<option {{$candidate->status == 0 ? 'selected' : ''}} value="0">Pending</option>
								<option {{$candidate->status == 1 ? 'selected' : ''}} value="1">Initial Interview</option>
								<option {{$candidate->status == 2 ? 'selected' : ''}} value="2">Manager Interview</option>
								<option {{$candidate->status == 3 ? 'selected' : ''}} value="3">Client Interview</option>
								<option {{$candidate->status == 4 ? 'selected' : ''}} value="4">Pre-Employment</option>
								<option {{$candidate->status == 5 ? 'selected' : ''}} value="5">Employment Request</option>
								<option {{$candidate->status == 6 ? 'selected' : ''}} value="6">Failed</option>
								<option {{$candidate->status == 6 ? 'selected' : ''}} value="7">Employed</option>
							</select>
							@else
								@if($candidate->status == NULL)
								---
								@else
								{{$candidate->status}}
								@endif
							@endif
						</td>
						@else
						<td>Employed</td>
						@endif

						<td>{{$candidate->status_updated_at}}</td>
						@if($candidate->status != 7)
							<td style="width: 15%">
								@if(in_array($hr_recruitment_id,$employee_ids))

								<select data-id="{{$candidate->id}}" class="form-control manager_dropdown" name="status">
									<option>-- select --</option>
									@foreach($oms as $om)
									<option value="{{$om->id}}" {{$candidate->manager_id == $om->id ? 'selected' : ''}}>{{$om->firstname}} {{$om->lastname}}</option>
									@endforeach
								</select>

								@endif
							</td>
							@else
							@if($candidate->manager_id != NULL)
								@foreach($oms as $om)
									@if($candidate->manager_id == $om->id)
									<td>{{$om->firstname}} {{$om->lastname}}</td>
									@endif
								@endforeach
							@else
							<td>N/A</td>
							@endif
						
						@endif
						<td>{{$candidate->manager_updated_at}}</td>
						<td>
							@if($candidate->manager_result == 0)
							Pending
							@elseif($candidate->manager_result == 1)
							Qualified
							@else
							Not Qualified
							@endif
						</td>
						<td>
							@if($candidate->manager_result_date == NULL)
							---
							@else
							{{$candidate->manager_result_date}}
							@endif
						</td>
						<td>{{$candidate->date_apply}}</td>
						<td><a href="{{$candidate->careers_app_file}}" target="_blank">View File</a></td>



					</tr>
					@endforeach
				</tbody>
			</table>
			<!-- If current user is OM-->
			@elseif(in_array($om_id,$employee_ids))
			<table class="table table-hover table-bordered table-striped table-condensed table-data">
				<thead>
					<tr>
						<th>PRF</th>
						<th>position applied</th>
						<th>Name</th>
						<th>Assigned Date</th>
						<th>Result</th>
						<th>Result Date</th>
						<th>Date</th>
						<th>file</th>
					</tr>
				</thead>
				<tbody>
					
					@foreach($candidates as $candidate)
					
					<tr>
						<td>
							<select data-id="{{$candidate->id}}" class="form-control select2 prf_assignment" name="prf_id">
								<option default hidden disabled selected>--select--</option>
								@php
									$selected_prf = \App\hris_prf::where('id',$candidate->prf_id)->first();
								@endphp

								@if($selected_prf != NULL)
									<option selected>{{$selected_prf->control_no}}</option>
								@endif
									
								@foreach($prfs as $prf)
									<option value="{{$prf->id}}">{{$prf->control_no}}</option>
								@endforeach
							</select>
						</td>
						<td>{{$candidate->careers_app_position}}</td>
						<td><a href="/hris/pages/recruitment/candidates/show/{{$candidate->id}}">{{$candidate->careers_app_fname}} {{$candidate->careers_app_lname}}</a></td>
						<td>{{$candidate->manager_updated_at}}</td>
						<td>
							@if($candidate->status == 7)
								@if($candidate->manager_result == 0)
									Pending
								@elseif($candidate->manager_result == 1)
									Qualified
								@else
									Not Qualified
								@endif
							@else
								<select data-id="{{$candidate->id}}" class="form-control manager_result" name="status">
									<option default hidden>--select--</option>
									<option {{$candidate->manager_result == 0 ? 'selected' : ''}} value="0">Pending</option>
									<option {{$candidate->manager_result == 1 ? 'selected' : ''}} value="1">Qualified</option>
									<option {{$candidate->manager_result == 2 ? 'selected' : ''}} value="2">Not Qualified</option>
								</select>
							@endif
						</td>
						<td>
							@if($candidate->manager_result_date == NULL)
							---
							@else
							{{$candidate->manager_result_date}}
							@endif
						</td>
						<td>{{$candidate->date_apply}}</td>
						<td><a href="{{$candidate->careers_app_file}}" target="_blank">View File</a></td>
					</tr>
					@endforeach
				</tbody>
			</table>
			@elseif($approval_requests != NULL)
			<table class="table table-hover table-bordered table-striped table-condensed table-data">
				<thead>
					<tr>
						<th>position applied</th>
						<th>Name</th>
						<th>Status</th>
						<th>Status Date</th>
						<th>Manager</th>
						<th>Assigned Date</th>
						<th>Result</th>
						<th>Result Date</th>
						<th>Date</th>
						<th>file</th>
					</tr>
				</thead>
				<tbody>
					@foreach($approval_requests as $candidate)
					<tr>
						<td>{{$candidate->careers_app_position}}</td>
						<td><a href="/hris/pages/recruitment/candidates/show/{{$candidate->id}}">{{$candidate->careers_app_fname}} {{$candidate->careers_app_lname}}</a></td>
						<td style="width: 15%">
							<select data-id="{{$candidate->id}}" class="form-control candidate_status" name="status">
								<option hidden disabled selected>Employment Request</option>
								<option {{$candidate->status == 6 ? 'selected' : ''}} value="6">Failed</option>
								<option {{$candidate->status == 7 ? 'selected' : ''}} value="7">Employed</option>
							</select>
						</td>

						<td>{{$candidate->status_updated_at}}</td>
						<td style="width: 15%">
							@foreach($oms as $om)
							@if($candidate->manager_id == $om->id)
							{{$om->firstname}} {{$om->lastname}}
							@endif
							@endforeach
						</td>
						<td>{{$candidate->manager_updated_at}}</td>
						<td>
							@if($candidate->manager_result == 0)
							Pending
							@elseif($candidate->manager_result == 1)
							Qualified
							@else
							Not Qualified
							@endif
						</td>
						<td>
							@if($candidate->manager_result_date == NULL)
							---
							@else
							{{$candidate->manager_result_date}}
							@endif
						</td>
						<td>{{$candidate->date_apply}}</td>
						<td><a href="{{$candidate->careers_app_file}}" target="_blank">View File</a></td>



					</tr>
					@endforeach
				</tbody>
			</table>
			@endif
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
	 $('.select2').select2();
	function thisFileUpload() {
		document.getElementById("file").click();
	};
	$('.table-data').DataTable({
		"paging": true,
		"lengthChange": false,
		"searching": true,
		"ordering": true,
	});
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

<script>
	$('.candidate_status').on('change', function() {
		if ($(this).val() != '') {
			var candidate_status = $(this).val();
			var candidate_id = $(this).attr('data-id');

			var _token = $('input[name="_token"]').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('candidateStatus.fetch')}}",
				method: "POST",
				data: {
					_token: _token,
					candidate_status: candidate_status,
					candidate_id: candidate_id,
				},
				success: function(response) {
					location.reload();
				},
				error: function(response) {
					console.log(response);
				}
			});
		}
	});
	$('.manager_dropdown').on('change', function() {
		if ($(this).val() != '') {
			var manager_dropdown = $(this).val();
			var candidate_id = $(this).attr('data-id');

			var _token = $('input[name="_token"]').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('candidateManager.fetch')}}",
				method: "POST",
				data: {
					_token: _token,
					manager_id: manager_dropdown,
					candidate_id: candidate_id,
				},
				success: function(response) {
					location.reload();
				},
				error: function(response) {
					console.log(response);
				}
			});
		}
	});
	$('.manager_result').on('change', function() {
		if ($(this).val() != '') {
			var manager_result = $(this).val();
			var candidate_id = $(this).attr('data-id');

			var _token = $('input[name="_token"]').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('managerResult.fetch')}}",
				method: "POST",
				data: {
					_token: _token,
					manager_result: manager_result,
					candidate_id: candidate_id,
				},
				success: function(response) {
					location.reload();
				},
				error: function(response) {
					console.log(response);
				}
			});
		}
	});
	$('.prf_assignment').on('change', function() {
		if ($(this).val() != '') {
			var prf_id = $(this).val();
			var candidate_id = $(this).attr('data-id');

			var _token = $('input[name="_token"]').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('prf.fetch')}}",
				method: "POST",
				data: {
					_token: _token,
					prf_id: prf_id,
					candidate_id: candidate_id,
				},
				success: function(response) {
					location.reload();
				},
				error: function(response) {
					console.log(response);
				}
			});
		}
	});
</script>
@stop