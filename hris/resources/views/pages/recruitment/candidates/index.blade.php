{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment - Candidates')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 offset-md-2 col-md-8 page-title">
		<h1>recruitment</h1>
	</div>
</div>
@stop
@section('content')
<div class="row no-gutters">
	@if ($message = Session::get('success'))
	<div class="alert alert-success alert-block">
	    <button type="button" class="close" data-dismiss="alert">×</button>
	    <p><i class="fas fa-fw fa-check-circle"></i>{{ $message }}</p>
	</div>
	@endif
	<div class="col-12 offset-md-2 col-md-8 box">
		<div class="row no-gutters">
			<div class="box-title">
				<h3>Candidates</h3>
			</div>
			<div class="box-add">
				<a href="/pages/recruitment/candidates/create">add <i class="fa fa-plus"></i></a>
			</div>
		</div>
		<div class="box-table">
			@if(count($candidates) > 0)
			<div class="row no-gutters">
				<div class="table-responsive">
					<table class="table table-hover table-bordered table-striped table-condensed">
						<thead>
							<tr>
								<th>id</td>
								<th>position applied</th>
								<th>first name</th>
								<th>last name</th>
								<th>email</td>
								<th>country</th>
								<th>actions</th>
							</tr>
						</thead>
						<tbody>
							@foreach($candidates as $candidate)
							<tr>
								<td>{{$candidate->id}}</td>
								<td>{{$candidate->position_applied}}</td>
								<td>{{$candidate->first_name}}</td>
								<td>{{$candidate->last_name}}</td>
								<td>{{$candidate->email}}</td>
								<td>{{$candidate->country}}</td>
								<td>
									<a href="/pages/recruitment/candidates/{{$candidate->id}}/edit"><i class="fa fa-edit"></i></a>
									<form action="/pages/recruitment/candidates/delete/{{$candidate->id}}" method="post">
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
			</div>
			@else
			<h5>No Data Available.</h5>
			@endif
		</div>
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