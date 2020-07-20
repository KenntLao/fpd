{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Personal Information - Basic Information')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-grip-horizontal"></i> Basic Information</h1>
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
			<a class="btn add-button btn-md" href="/hris/pages/personalInformation/profile/{{$_SESSION['sys_id']}}/edit"><i class="fa fa-edit mr-1"></i> edit info</a>
		</div>
	</div>
	<div class="card-body">
		<div class="row no-gutters profile">
			<div class="col-12 col-md-2 mb-2">
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
						<p>{{$employee->work_address}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Home Address</label>
						<p>{{$employee->home_address}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Work Phone</label>
						<p>{{$employee->work_phone}}</p>
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
						<p>{{$employee->job_title->name}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Employment Status</label>
						<p>{{$employee->employment_status}}</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Supervisor</label>
						<p>
							@php
							if($employee->supervisor) {
								$supervisor = App\hris_employee::find($employee->supervisor);
								echo $supervisor->firstname.' '.$supervisor->lastname;
							} else {
								echo 'ADD SUPERVISOR';
							}
							@endphp
						</p>
					</div>
					<div class="col-12 col-md-3">
						<label>Department</label>
						<p>{{$employee->department->name}}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
	<div class="card-footer">
	</div>
</div>
<div class="modal fade" id="change-pass" tabindex="-1" role="dialog" aria-labelledby="change-pass" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<h5 class="modal-title" id="change-passl">Change Password</h5>
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
				<span aria-hidden="true">&times;</span>
				</button>
			</div>
			<div class="modal-body">
				<form class="form-horizontal" action="/hris/pages/personalInformation/profile/changePass" id="form">
					@csrf
					<div class="form-group">
						<label class="mr-2">Old password: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter old password</p>
							<input class="form-control required" type="password" name="old_pass" required>
						</div>
					</div>
					<div class="form-group">
						<label class="mr-2">New password: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter new password</p>
							<input class="form-control required" type="password" name="new_pass" required>
						</div>
					</div>
				</form>
			</div>
			<div class="modal-footer">
				<button class="btn btn-success" type="submit" form="form"><i class="fa fa-check"></i> Save Password</button>
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
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
@stop