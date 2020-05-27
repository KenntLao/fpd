{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Job Details Setup - Pay Grades')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-columns"></i> Job Details Setup</h1>
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
		<h3 class="card-title">pay grades list</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/admin/jobDetails/payGrades/create"><i class="fa fa-plus"></i> add pay grade</a>
		</div>
	</div>
	<div class="card-body">
		@if(count($payGrades) > 0)
		<table class="table table-hover table-bordered table-striped table-condensed">
			<thead>
				<tr>
					<th>name</th>
					<th>currency</th>
					<th>min salary</th>
					<th>max salary</th>
					<th>actions</th>
				</tr>
			</thead>
			<tbody>
				@foreach($payGrades as $payGrade)
				<tr>
					<td>{{$payGrade->name}}</td>
					<td>{{$payGrade->currency}}</td>
					<td>{{$payGrade->min_salary}}</td>
					<td>{{$payGrade->max_salary}}</td>
					<td>
						<a href="/hris/pages/admin/jobDetails/payGrades/{{$payGrade->id}}/edit"><i class="fa fa-edit"></i></a>
						<form action="/hris/pages/admin/jobDetails/payGrades/delete/{{$payGrade->id}}" method="post">
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
		{{$payGrades->links()}}
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