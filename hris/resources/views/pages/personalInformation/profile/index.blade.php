{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Administration - Personal Information')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-grip-horizontal "></i> Personal Information</h1>
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
		<h3 class="card-title">Basic Information</h3>
		<div class="card-tools">
			<a class="btn add-button btn-md" href="/hris/pages/employees/employee/{{$_SESSION['sys_id']}}/edit"><i class="fa fa-edit mr-1"></i> edit info</a>
		</div>
	</div>
	<div class="card-body">
		<div class="row no-gutters profile">
			<div class="col-12 col-md-3 mb-2">
				<div class="profile-image mr-4">
					<img src="{{ URL::asset('assets/images/employees/employee_photos/') }}/{{$employee->employee_photo}}">
				</div>
			</div>
			<div class="col-12 col-md-9 profile-info mb-2">
				<div class="profile-text">
					<h4>{{ $_SESSION['sys_fullname'] }}</h4>
					<p><i class="fa fa-envelope mr-2"></i> {{$employee->work_email}}</p>
					<btn class="btn add-button btn-md" data-toggle="modal" data-target="#change-pass"><i class="fa fa-lock mr-2"></i> Change password</btn>
				</div>
			</div>
		</div>
		<div class="row no-gutters">
			<div class="col-12 col-md-4 mb-2">
				<label>Employee Number</label>
				<p>{{$employee->employee_number}}</p>
			</div>
			<div class="col-12 col-md-4 mb-2">
				<label>PHIC</label>
				<p>{{$employee->phic}}</p>
			</div>
			<div class="col-12 col-md-4 mb-2">
				<label>SSS</label>
				<p>{{$employee->sss}}</p>
			</div>
		</div>
		<div class="row no-gutters section mb-4">
			<div class="col-12 section-title">
				<h5>personal information</h5>
			</div>
			<div class="col-12 section-info">
				<div class="row no-gutters">
					<div class="col-12 col-md-3">
						<label>PAGIBIG</label>
						<p>{{$employee->sss}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Date of Birth</label>
						<p>{{date("M d, Y", strtotime($employee->birthday))}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Gender</label>
						<p>{{$employee->gender}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Nationality</label>
						<p>{{$employee->nationality}}</p>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-12 col-md-3">
						<label>Marital Status</label>
						<p>{{$employee->marital_status}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Joined Date</label>
						<p>{{date("M d, Y", strtotime($employee->joined_date))}}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row no-gutters section mb-4">
			<div class="col-12 section-title">
				<h5>contact information</h5>
			</div>
			<div class="col-12 section-info">
				<div class="row no-gutters">
					<div class="col-12 col-md-3">
						<label>Work Address</label>
						<p>{{$employee->sss}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Home Address</label>
						<p>{{date("M d, Y", strtotime($employee->birthday))}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>City</label>
						<p>{{$employee->gender}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Country</label>
						<p>{{$employee->nationality}}</p>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-12 col-md-3">
						<label>Postal/Zip Code</label>
						<p>{{$employee->postal_code}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Work Phone</label>
						<p>{{$employee->work_phone}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Home Phone</label>
					</div>
					<div class="col-12 col-md-3">
						<label>Private Email</label>
						<p>{{$employee->private_email}}</p>
					</div>
				</div>
			</div>
		</div>
		<div class="row no-gutters section">
			<div class="col-12 section-title">
				<h5>job details</h5>
			</div>
			<div class="col-12 section-info">
				<div class="row no-gutters">
					<div class="col-12 col-md-3">
						<label>Job Title</label>
						<p>{{$employee->job_position}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Employment Status</label>
						<p>{{$employee->employment_status}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Supervisor</label>
						<p>{{$employee->supervisor}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Direct Reports</label>
					</div>
				</div>
				<div class="row no-gutters">
					<div class="col-12 col-md-3">
						<label>Department</label>
						<p>{{$employee->department}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop