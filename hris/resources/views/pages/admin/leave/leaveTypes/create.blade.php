{{-- resources/views/admin/dashboard.blade.php --}}
@extends('adminlte::page')
@section('title', 'HRIS | Leave Settings - Leave Types')
@section('content_header')
<div class="row no-gutters">
	<div class="col-12 page-title">
		<h1><i class="fas fa-fw fa-pause"></i> Leave Settings</h1>
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
<div class="card">
	<div class="card-header">
		<h3 class="card-title">add leave types</h3>
	</div>
	<div class="card-body">
		<form class="form-horizontal" method="post" action="/hris/pages/admin/leave/leaveTypes" id="form">
			@csrf
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="name">Leave Name: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter name</p>
							<input class="form-control required" type="text" name="name"required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="leaves_per_period">Leaves Per Leave Period: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter leaves per period</p>
							<input class="form-control required" type="text" name="leaves_per_period" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="supervisor_leave_assign">Admin can assign leave to employees: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2 required" name="supervisor_leave_assign" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="employee_can_apply">Employees can apply for this leave type: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2 required" name="employee_can_apply" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="apply_beyond_current">Employees can apply beyond the current leave balance: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2 required" name="apply_beyond_current" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="leave_accrue">Leave Accrue Enabled: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2 required" name="leave_accrue" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="carried_forward">Leave Carried Forward: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control select2 required" name="carried_forward" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="carried_forward_percentage">Percentage of Leave Carried Forward: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter percentage of leave carried forward</p>
							<input class="form-control required" type="text" name="carried_forward_percentage" id="percentInput" maxlength="3" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
						</div>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="max_carried_forward_amount">Maximum Carried Forward Amount: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter maximum carried forward amount</p>
							<input class="form-control required" type="text" name="max_carried_forward_amount" maxlength="6" oninput="this.value = this.value.replace(/[^0-9.]/g, '').replace(/(\..*)\./g, '$1');" required>
						</div>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="carried_forward_leave_availability">Carried Forward Leave Availability Period: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="carried_forward_leave_availability" required>
							<option value="1 Month">1 Month</option>
							<option value="2 Months">2 Months</option>
							<option value="3 Months">3 Months</option>
							<option value="4 Months">4 Months</option>
							<option value="5 Months">5 Months</option>
							<option value="6 Months">6 Months</option>
							<option value="7 Months">7 Months</option>
							<option value="8 Months">8 Months</option>
							<option value="9 Months">9 Months</option>
							<option value="10 Months">10 Months</option>
							<option value="11 Months">11 Months</option>
							<option value="1 Year">1 Year</option>
							<option value="No Limit">No Limit</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="proportionate_on_joined_date">Proportionate leaves on Joined Date: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="proportionate_on_joined_date" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="employee_leave_period">Use Employee Leave Period: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="employee_leave_period" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="send_notification_emails">Send Notification Emails: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="send_notification_emails" required>
							<option value="Yes">Yes</option>
							<option value="No">No</option>
						</select>
					</div>
				</div>
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="leave_group">Leave Group: </label>
						<span class="badge badge-danger">Required</span>
						<select class="form-control required select2" name="leave_group">
							@if(count($leaveGroups) > 0)
							@foreach($leaveGroups as $leaveGroup)
							<option value="None">None</option>
							<option value="{{$leaveGroup->name}}">{{$leaveGroup->name}}</option>
							@endforeach
							@else
							<option value="None">None</option>
							@endif
						</select>
					</div>
				</div>
			</div>
			<div class="row">
				<div class="col-12 col-md-6">
					<div class="form-group">
						<label class="mr-2" for="leave_color">Leave Color: </label>
						<span class="badge badge-danger">Required</span>
						<div class="input">
							<p class="placeholder">Enter leave color hex code</p>
							<input class="form-control required" type="text" name="leave_color" required id="colorInput" maxlength="6">
							<div class="color-box"></div>
						</div>
					</div>
				</div>
			</div>
		</form>
	</div>
	<div class="card-footer text-right">
		<a class="btn btn-default mr-1" href="/hris/pages/admin/leave/leaveTypes/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
		<button class="btn btn-success" type="submit" form="form"><i class="fa fa-upload mr-1"></i> save leave types</button>
	</div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script type="text/javascript">
	$(document).ready(function(){
		$('#percentInput').keyup(function(){
	  		if ($(this).val() > 100){
	    		$(this).val('100');
	  		}
		});
		$('#colorInput').keyup(function() {
			$('.color-box').css('background-color', '#'+$(this).val());
		});
	});	
</script>
@stop