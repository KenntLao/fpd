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
<div class="card">
	<div class="card-header">
		<h3 class="card-title">candidates list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/recruitment/candidates/create"><i class="fa fa-plus mr-1"></i> add candidate</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($candidates) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>id</th>
						<th>position applied</th>
						<th>first name</th>
						<th>last name</th>
						<th>email</th>
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
							<a href="/hris/pages/recruitment/candidates/{{$candidate->id}}/edit"><i class="fa fa-edit"></i></a>
							<form action="/hris/pages/recruitment/candidates/delete/{{$candidate->id}}" method="post">
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
	<div class="card-footer text-right">
		{{$candidates->links()}}
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