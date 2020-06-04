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
@if($errors->any())
<div class="alert alert-danger alert-block">
	<button type="button" class="close" data-dismiss="alert">×</button>
	<p><i class="fas fa-fw fa-exclamation-circle"></i>{{$errors->first()}}</p>
</div>
@endif
<div class="card">
	<div class="card-header">
		<h3 class="card-title">leave rules list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/leave/leaveRules/create"><i class="fa fa-plus mr-1"></i> add leave rule</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($leaveRules) > 0)
		<table class="table table-hover table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th>id</th>
					<th>leave type</th>
					<th>leave group</th>
					<th>leave period</th>
					<th>department</th>
					<th>job title</th>
					<th>employment status</th>
					<th>employmee</th>
					<th>Experience (Days)</th>
					<th>Leaves Per Year</th>
				</tr>
			</thead>
			<tbody>
				@foreach($leaveRules as $leaveRule)
				<tr>
					<td>{{$leaveRule->id}}</td>
					<td>
						<a href="/hris/pages/admin/leave/leaveRules/{{$leaveRule->id}}/edit"><i class="fa fa-edit"></i></a>
						<!-- Button trigger modal -->
						<button type="button" data-toggle="modal" data-target="#modal-{{$leaveRule->id}}"><i class="fa fa-trash"></i></button>
						<!-- Modal -->
						<div class="modal fade" id="modal-{{$leaveRule->id}}" tabindex="-1" role="dialog" aria-labelledby="modal-{{$leaveRule->id}}" aria-hidden="true">
							<div class="modal-dialog" role="document">
								<div class="modal-content">
									<div class="modal-header">
										<h5 class="modal-title">Delete Confirmation</h5>
										<button type="button" class="close" data-dismiss="modal" aria-label="Close">
										<span aria-hidden="true">&times;</span>
										</button>
									</div>
									<div class="modal-body">
										<p>Are you sure you want to delete?</p>
										<hr>
										<form action="/hris/pages/admin/leave/leaveRules/delete/{{$leaveRule->id}}" method="post" id="form-{{$leaveRule->id}}">
											@csrf
											@method('DELETE')
											<div class="form-group">
												<label for="upass">Enter Password: </label>
												<input class="form-control" type="password" name="upass" required>
											</div>
										</form>
									</div>
									<div class="modal-footer">
										<button class="btn btn-danger" type="submit" form="form-{{$leaveRule->id}}"><i class="fa fa-check"></i> Confirm Delete</button>
										<button type="button" class="btn btn-secondary" data-dismiss="modal"><i class="fa fa-times"></i> Close</button>
									</div>
								</div>
							</div>
						</div>
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
		{{$leaveRules->links()}}
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