{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Recruitment Setup - Experience Levels')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-random"></i> recruitment setup</h1>
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
		<h3 class="card-title">experience levels list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/recruitment/recruitmentSetup/experienceLevels/create"><i class="fa fa-plus"></i> add experience level</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($experienceLevels) > 0)
		<div class="table-responsive">
			<table class="table table-hover table-bordered table-striped table-condensed">
				<thead>
					<tr>
						<th>id</th>
						<th>name</th>
						<th>action</th>
					</tr>
				</thead>
				<tbody>
					@foreach($experienceLevels as $experienceLevel)
					<tr>
						<td>{{$experienceLevel->id}}</td>
						<td>{{$experienceLevel->name}}</td>
						<td>
							<a href="/hris/pages/recruitment/recruitmentSetup/experienceLevels/{{$experienceLevel->id}}/edit"><i class="fa fa-edit"></i></a>
							<form action="/hris/pages/recruitment/recruitmentSetup/experienceLevels/delete/{{$experienceLevel->id}}" method="post">
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
		{{$experienceLevels->links()}}
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
</script>
@stop
