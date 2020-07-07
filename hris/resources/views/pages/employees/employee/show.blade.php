@extends('adminlte::page')
@section('title', 'HRIS | Employees - Employee')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-user"></i> Employee Profile</h1>
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
        <h3 class="card-title">Profile</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-md-2 col-sm-12">
                <div class="form-group">
                    <label class="mr-2 custom-file-upload" for="employee_photo">
                        <div class="image-preview-container">
                            <img id="image-preview" src="{{asset('/assets/images/employees/employee_photos')}}/{{$employee->employee_photo}}" />
                        </div>
                    </label>

                </div>
            </div>
            <div class="col-md-7">
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="mr-2" for="employee_number">Employee Number</label>
                            <div class="employee-info">
                                <span>{{$employee->employee_number}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="employee_first_name">Employee First Name </label>
                            <div class="employee-info">
                                <span>{{$employee->firstname}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="employee_middle_name">Employee Middle Name </label>
                            <div class="employee-info">
                                <span>{{$employee->middlename}}</span>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="form-group">
                            <label class="mr-2" for="employee_last_name">Employee Last Name </label>
                            <div class="employee-info">
                                <span>{{$employee->lastname}}</span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="mr-2" for="job_postion">Job Position</label>
                            <div class="employee-info">
                                <span>{{$employee->job_position}}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-5"></div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="work_mobile">Work Mobile </label>
                    <div class="employee-info">
                        <span>{{$employee->work_no}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="work_phone">Work Phone </label>
                    <div class="employee-info">
                        <span>{{$employee->work_phone}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="work_email">Work Email </label>
                    <div class="employee-info">
                        <span>{{$employee->work_email}}</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="department">Department </label>
                    <div class="employee-info">
                        <span>{{$employee->department->name}}</span>
                    </div>
                </div>
            </div>
            <div class="col-md-4">
                <div class="form-group">
                    <label class="mr-2" for="supervisor">Supervisor </label>
                    <div class="employee-info">
                        <span>
                            @if(isset($supervisor))
                            {{$supervisor->firstname}} {{$supervisor->lastname}}
                            @endif
                        </span>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <ul class="nav nav-tabs" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">Work Information</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Private Information</a>
                    </li>
                </ul><!-- Tab panes -->
                <div class="tab-content">
                    <div class="tab-pane active" id="tabs-1" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label class="mr-2" for="work_address">Work Address </label>
                                    <div class="employee-info">
                                        <span>{{$employee->work_address}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mr-2" for="sss">SSS </label>
                                    <div class="employee-info">
                                        <span>{{$employee->sss}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mr-2" for="pagibig">Pag-ibig </label>
                                    <div class="employee-info">
                                        <span>{{$employee->pagibig}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mr-2" for="phic">PHIC </label>
                                    <div class="employee-info">
                                        <span>{{$employee->phic}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mr-2" for="joined_date">Joined Date </label>
                                    <div class="employee-info">
                                        <span>{{$employee->joined_date}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mr-2" for="marital_status">Employment Status</label>
                                    <div class="employee-info">
                                        <span>{{$employee->employment_status}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="mr-2" for="termination_date">Termination Date </label>
                                    <div class="employee-info">
                                        <span>{{$employee->termination_date}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane" id="tabs-2" role="tabpanel">
                        <div class="row">
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3>Private Contact</h3>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="address">Address </label>
                                    <div class="employee-info">
                                        <span>{{$employee->home_address}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="email">Email </label>
                                    <div class="employee-info">
                                        <span>{{$employee->private_email}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="email">Bank Account Number </label>
                                    <div class="employee-info">
                                        <span>{{$employee->bank_acc}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="home_work_distance">Km Home-Work </label>
                                    <div class="employee-info">
                                        <span>{{$employee->home_distance}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3>Marital Status</h3>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="marital_status">Marital Status </label>
                                    <div class="employee-info">
                                        <span>{{$employee->marital_status}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3>Emergency</h3>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="emergency_contact">Emergency Contact</label>
                                    <div class="employee-info">
                                        <span>{{$employee->emergency_contact}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="emergency_phone">Emergency Phone</label>
                                    <div class="employee-info">
                                        <span>{{$employee->emergency_no}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3>Education</h3>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="marital_status">Certificate Level </label>
                                    <div class="employee-info">
                                        <span>{{$employee->cert_level}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="field_study">Field of Study</label>
                                    <div class="employee-info">
                                        <span>{{$employee->field_study}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="school">School</label>
                                    <div class="employee-info">
                                        <span>{{$employee->school}}</span>
                                    </div>
                                </div>
                            </div>
                            <div class="col-md-6">
                                <div class="form-group">
                                    <h3>Citizenship</h3>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="nationality">Nationality </label>
                                    <div class="employee-info">
                                        <span>{{$employee->nationality}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="passport_no">Passport No. </label>
                                    <div class="employee-info">
                                        <span>{{$employee->passport_no}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="gender">Gender </label>
                                    <div class="employee-info">
                                        <span>{{$employee->gender}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="birthday">Date of Birth </label>
                                    <div class="employee-info">
                                        <span>{{$employee->birthday}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="place_birth">Place of Birth </label>
                                    <div class="employee-info">
                                        <span>{{$employee->place_birth}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3>Dependant</h3>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="dependant">Number of Children</label>
                                    <div class="employee-info">
                                        <span>{{$employee->dependant}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <h3>Work Permit</h3>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="visa">Visa No.</label>
                                    <div class="employee-info">
                                        <span>{{$employee->visa_no}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="work_permit">Work Permit No.</label>
                                    <div class="employee-info">
                                        <span>{{$employee->work_permit}}</span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="mr-2" for="visa_expire">Visa Expiry Date</label>
                                    <div class="employee-info">
                                        <span>{{$employee->visa_expire}}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-footer text-right">

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