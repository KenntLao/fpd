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
@if (count($errors))
<div class="alert alert-danger">
	<strong>Whoops!</strong> There were some problems with your input.
	<ul>
		@foreach ($errors->all() as $error)
		<li>{{ $error }}</li>
		@endforeach
	</ul>
</div>
@endif
<div class="card" id="create">
	<div class="card-header">
		<h3 class="card-title">HR APPROVAL FOR {{$employee->firstname}} {{$employee->lastname}} - PRF Request</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/recruitment/prf/approve-submit/{{$prf->id}}" enctype="multipart/form-data" id="form">
			@csrf
			@method('PATCH')
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="received_by">Received By: </label>
						<p>[{{$supervisor->employee_number}}] {{$supervisor->firstname}} {{$supervisor->middlename}} {{$supervisor->lastname}}</p>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="received_by">Date Received: </label>
						<p>{{$prf->date_filed}}</p>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="received_by">PR Filed By: </label>
						<p>[{{$employee->employee_number}}] {{$employee->firstname}} {{$employee->middlename}} {{$employee->lastname}}</p>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="gender">Action: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="action" required>
							<option default hidden disabled selected>-- Choose Action --</option>
							<option value="1">For Sourcing</option>
							<option value="2">For NPA</option>
							<option value="3">Other</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="gender">Type of Employment: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="employment_status_id" required>
							<option default hidden disabled selected>-- Choose Status --</option>
							@foreach($employment_status as $em_status)
							<option value="{{$em_status->id}}">{{$em_status->name}}</option>
							@endforeach
						</select>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="gender">Duration From: </label>
						<span class="badge badge-danger">Required</span>
						<input type="date" class="form-control required" name="duration_from" required>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="gender">Duration To: </label>
						<span class="badge badge-danger">Required</span>
						<input type="date" class="form-control required" name="duration_to" required>
					</div>
				</div>
			</div>

			<div class="row">
				<div class="col-md-6">
					<div class="form-group">
						<label class="mr-2" for="roles">Name of Hired Personnel</label>
						<span class="badge badge-danger">Required</span>
						<select class="required select2" name="candidates[]" multiple="multiple" required>
							@if(count($candidates) > 0)
							@foreach($candidates as $candidate)
							<option value="{{$candidate->id}}">
								{{$candidate->careers_app_fname}} {{$candidate->careers_app_lname}}
							</option>
							@endforeach
							@endif
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="date_hired">Designation: </label>
						<span class="badge badge-danger"></span>
						<p>{{$designation->name}}</p>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="date_hired">Job Position: </label>
						<span class="badge badge-danger">Required</span>
						<select class="required select2" name="candidate_position" required>
							<option default hidden disabled selected>-- Choose Job Title --</option>
							@foreach($job_positions as $job_position)
							<option value="{{$job_position->id}}">
								{{$job_position->name}}
							</option>
							@endforeach
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="date_hired">Salary Offered: </label>
						<span class="badge badge-danger">Required</span>
						<input type="number" class="form-control required" name="candidate_salary" required>
					</div>
				</div>
				<div class="col-12 col-md-6 col-xl-3">
					<div class="form-group">
						<label class="mr-2" for="date_hired">Date Hired: </label>
						<span class="badge badge-danger">Required</span>
						<input type="date" class="form-control required" name="candidate_hire_date" required>
					</div>
				</div>
			</div>
			<div class="col-12 col-md-6 col-xl-3">
				<div class="form-group">
					<label class="mr-2" for="date_hired">Billing Advice: </label>
					<span class="badge badge-danger">Required</span>
					<select class="required select2" name="pod_type" required>
						<option default hidden disabled selected>-- Choose Billing Advice --</option>
						<option value="1">With Billing Advice</option>
						<option value="2">Billing Advice Not Needed</option>
					</select>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6 col-xl-4">
					<div class="form-group">
						<label class="mr-2" for="date_hired">Verified By: </label>
						<p>[{{$hr_detail->employee_number}}] {{$hr_detail->firstname}} {{$hr_detail->lastname}}</p>
						<p>HR Recruitment</p>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/recruitment/prf/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> submit</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop