{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Time Management - Time Sheets')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-user-friends"></i> Time Management</h1>
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
		<h3 class="card-title">Time Sheets</h3>
	</div>
	<div class="card-body">
		<ul class="nav nav-tabs" role="tablist">
			<li class="nav-item">
				<a id="tablink-1" href="#tab-1" class="nav-link active" data-toggle="tab" aria-controls="tab-1" aria-selected="true">All My Time Sheets</a>
			</li>
			<li class="nav-item">
				<a href="#tab-2" class="nav-link" data-toggle="tab" aria-controls="tab-2" aria-selected="false">Approved Time Sheets</a>
			</li>
			<li class="nav-item">
				<a href="#tab-3" class="nav-link" data-toggle="tab" aria-controls="tab-3" aria-selected="false">Pending Time Sheets</a>
			</li>
			<li class="nav-item">
				<a href="#tab-4" class="nav-link" data-toggle="tab" aria-controls="tab-4" aria-selected="false">Subordinate Time Sheets</a>
			</li>
		</ul>
		<div class="tab-content">
			<div class="tab-pane fade show active" id="tab-1" role="tabpanel" aria-labelledby="tablink-1">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>start date</th>
								<th>end date</th>
								<th>total time</th>
								<th>status</th>
								<th>actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>actions here</td>
							</tr>
							<tr>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>actions here</td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
			<div class="tab-pane fade" id="tab-2" role="tabpanel" aria-labelledby="tablink-2">
			</div>
			<div class="tab-pane fade" id="tab-3" role="tabpanel" aria-labelledby="tablink-3">

			</div>
			<div class="tab-pane fade" id="tab-4" role="tabpanel" aria-labelledby="tablink-4">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>employee</th>
								<th>start date</th>
								<th>end date</th>
								<th>total time</th>
								<th>status</th>
								<th>actions</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>lorem ipsum</td>
								<td>actions here</td>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer"></div>
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