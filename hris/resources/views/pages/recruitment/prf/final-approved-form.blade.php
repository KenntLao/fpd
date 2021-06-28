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
        <h3 class="card-title">{{$employee->firstname}} {{$employee->lastname}} - PRF Request</h3>
        @if($prf->supervisor_id == $_SESSION['sys_id'])
        @if($prf->initial_status == 0)
        <div class="card-tools">
            <a class="btn btn-danger btn-md mr-1" href="/hris/pages/recruitment/prf/reject/{{$prf->id}}"><i class="fa fa-ban mr-1"></i> Reject</a>
            <a class="btn btn-success btn-md" href="/hris/pages/recruitment/prf/approve/{{$prf->id}}"><i class="fa fa-check mr-1"></i> Approve</a>
        </div>
        @else
        <div class="card-tools">
            @if($prf->initial_status == 1)
            <p class="badge badge-primary p-1">Processing</p>
            @elseif($prf->initial_status == 2)
            <p class="badge badge-success p-1">Approved</p>
            @elseif($prf->initial_status == 3)
            <p class="badge badge-danger p-1">Rejected</p>
            @endif

            @if($prf->close_status == 0)
            <p class="badge badge-warning p-1">Open</p>
            @elseif($prf->close_status == 1)
            <p class="badge badge-primary p-1">Processing</p>
            @else
            <p class="badge badge-success p-1">Closed</p>
            @endif
        </div>
        @endif
        @else

        @if(in_array($hr_recruitment_id,$employee_ids))
            @if($prf->initial_status == 3)
                <div class="card-tools">
                    <p class="badge badge-danger p-1">Rejected</p>
                </div>
                @elseif($prf->initial_status == 1)
                <div class="card-tools">
                    <a class="btn btn-danger btn-md mr-1" href="/hris/pages/recruitment/prf/reject/{{$prf->id}}"><i class="fa fa-ban mr-1"></i> Reject</a>
                    <a class="btn btn-success btn-md" href="/hris/pages/recruitment/prf/HRapprove/{{$prf->id}}"><i class="fa fa-check mr-1"></i> Approve</a>
                </div>
                @elseif($prf->initial_status == 2)
                <div class="card-tools">
                    <p class="badge badge-success p-1">Approved</p>
                    @if($prf->close_status == 0)
                        <p class="badge badge-warning p-1">Open</p>
                    @elseif($prf->close_status == 1)
					<p class="badge badge-primary p-1">Processing</p>
					@else
					<p class="badge badge-success p-1">Closed</p>
                    @endif
                </div>
                @endif
                @else
                <div class="card-tools">
                    @if($prf->initial_status == 1)
                    <p class="badge badge-success p-1">Processing</p>
                    @elseif($prf->initial_status == 2)
                    <p class="badge badge-success p-1">Approved</p>
                    @elseif($prf->initial_status == 3)
                    <p class="badge badge-danger p-1">Rejected</p>
                    @endif

                    @if($prf->close_status == 0)
                    <p class="badge badge-warning p-1">Open</p>
                    @elseif($prf->close_status == 1)
					<p class="badge badge-primary p-1">Processing</p>
					@else
					<p class="badge badge-success p-1">Closed</p>
                    @endif
                </div>
            @endif
        @endif
    </div>
    <div class="card-body">
        <input id="prf_id" type="hidden" value="{{$prf->id}}">
        @if($prf->initial_status == 3)
        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2">Rejection Remarks: </label>
                    <div class="input">
                        <p>{{$prf->reject_remarks}}</p>
                    </div>
                </div>
            </div>
        </div>
        @endif
        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="first_name">Control No: </label>
                    <div class="input">
                        <p>{{$prf->control_no}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="first_name">Education: </label>
                    <div class="input">
                        <p>{{$prf->education}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="first_name">Work Experience: </label>
                    <div class="input">
                        <p>{{$prf->work_exp}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="first_name">Skills: </label>
                    <div class="input">
                        <p>{{$prf->skills}}</p>
                    </div>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-12">
                <div class="form-group">
                    <label class="mr-2" for="first_name">Duty Description: </label>
                    <div class="input">
                        <p>{{$prf->duty_desc}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">Reason: </label>
                    <p>{{$prf->reason}}</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">Job Position: </label>
                    <p>
                    @if(isset($prf->jobTitle->name))
                        {{$prf->jobTitle->name}}
                    @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="basic_rate">Basic Rate (PHP): </label>
                    <div class="input">
                        <p>{{$prf->basic_rate}}</p>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="allowance">Allowance: </label>
                    <div class="input">
                        <p>{{$prf->allowance}}</p>
                    </div>
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">Project Based: </label>
                    @if($prf->project_based == 0)
                    <p>No</p>
                    @else
                    <p>{{$prf->project_based}}</p>
                    @endif
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">CMO Based: </label>
                    @if($prf->cmo_based == 0)
                    <p>No</p>
                    @else
                    <p>{{$prf->cmo_based}}</p>
                    @endif
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-3" id="cmo_based_remarks">
            <div class="col-12 col-md-6 col-xl-5">
                <div class="form-group">
                    <label class="mr-2" for="client_approval_file">Remarks </label>
                    <p>{{$prf->cmo_remarks}}</p>
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-3" id="project_based_file">
            <div class="col-12 col-md-6 col-xl-5">
                <div class="form-group">
                    <label class="mr-2" for="client_approval_file">Client’s Approval on increase/decrease Attachment: </label>
                    <p>{{$prf->client_approval_file}}</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-5">
                <div class="form-group">
                    <label class="mr-2" for="labor_approval_file">Approved Labor cost from Operations Department Attachment: </label>
                    <p>{{$prf->labor_approval_file}}</p>
                </div>
            </div>
        </div>



        <!-- PART 2 FORM -->


        <div class="row mt-3 mb-3">
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
        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">Action: </label>
                    <span class="badge badge-danger">Required</span>
                    <select class="form-control required select2 action_approve" name="action" required>
                        <option default hidden disabled selected>
                            @if($prf->action == 1)
                                For Sourcing
                            @elseif($prf->action == 2)
                                For NPA
                            @elseif($prf->action == 3)
                                Other
                            @else
                                For Job Offer
                            @endif
                        </option>
                        <option value="4">For Job Offer</option>
                    </select>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">Type of Employment: </label>
                    <p>
                        @if(isset($prf->employmentStatus->name))
                        {{$prf->employmentStatus->name}}
                        @else
                        ---
                        @endif
                    </p>
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">Duration From: </label>
                    <p>{{$prf->duration_from}}</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-4">
                <div class="form-group">
                    <label class="mr-2" for="gender">Duration To: </label>
                    <p>{{$prf->duration_to}}</p>
                </div>
            </div>
        </div>

        <div class="row mt-3 mb-3">
            <div class="col-md-6">
                <div class="form-group">
                    <label class="mr-2" for="roles">Name of Hired Personnel</label>
                    <p>
                        @if(isset($prf->candidate->careers_app_fname))
                        {{$prf->candidate->careers_app_fname}} {{$prf->candidate->careers_app_lname}}
                    </p>
                    @else
                        <p></p>
                    @endif
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="form-group">
                    <label class="mr-2" for="date_hired">Designation: </label>
                    <p>{{$designation->name}}</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="form-group">
                    <label class="mr-2" for="date_hired">Job Position: </label>
                    <p>
                        @if(isset($prf->jobTitle->name))
                        {{$prf->jobTitle->name}}
                        @else
                        ---
                        @endif
                    </p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="form-group">
                    <label class="mr-2" for="date_hired">Salary Offered: </label>
                    <p>{{$prf->candidate_salary}}</p>
                </div>
            </div>
            <div class="col-12 col-md-6 col-xl-3">
                <div class="form-group">
                    <label class="mr-2" for="date_hired">Date Hired: </label>
                    <p>{{$prf->candidate_hire_date}}</p>
                </div>
            </div>
        </div>
        <div class="row mt-3 mb-3">
            <div class="col-12 col-md-6 col-xl-3">
                <div class="form-group">
                    <label class="mr-2" for="date_hired">Billing Advice: </label>
                    <p>
                        @if($prf->pod_type == 1)
                        With Billing Advice
                        @else
                        Billing Advice Not Needed
                        @endif
                    </p>
                </div>
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

    </div>
    <div class="card-footer text-right">
        <a class="btn btn-default mr-1" href="/hris/pages/recruitment/prf/index"><i class="fa fa-arrow-left mr-1"></i> back</a>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script src="{{ URL::asset('assets/js/main.js') }}"></script>
<script>
    $('.action_approve').on('change', function() {
		if ($(this).val() != '') {
			var action = $(this).val();
            var prf_id = $('#prf_id').val();

			var _token = $('input[name="_token"]').val();
			$.ajaxSetup({
				headers: {
					'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
				}
			});
			$.ajax({
				url: "{{ route('prfAction.fetch')}}",
				method: "POST",
				data: {
					_token: _token,
                    prf_id: prf_id,
					action: action,
				},
				success: function(response) {
					location.reload();
				},
				error: function(response) {
					console.log(response);
				}
			});
		}
	});
</script>
@stop