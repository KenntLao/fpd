@extends('adminlte::page')
@section('title', 'HRIS | Staff Directory')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Staff Directory</h1>
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
        <h3 class="card-title">Staff Directory</h3>
        <div class="card-tools">
            <button class="btn add-button btn-md" data-toggle="modal" data-target="#filter-modal"><i class="fas fa-filter mr-1"></i> Filter</button>
        </div>
    </div>
    <div class="card-body">
        @if(count($employees) > 0)
        <div class="row">
            @foreach($employees as $employee)
            <div class="col-12 col-sm-6 col-md-4 col-xl-3 staff-box">
                <div class="staff-card">
                    <div class="staff-header">
                        <div class="row no-gutters">
                            <div class="col-3">
                                <div class="staff-img">
                                    @if($employee->employee_photo)
                                    @if(file_exists('assets/images/employees/employee_photos/'.$employee->employee_photo))
                                    <img src="{{asset('assets/images/employees/employee_photos/')}}/{{$employee->employee_photo}}">
                                    @else
                                    @if($employee->gender == 'M')
                                    <img src="{{asset('assets/images/employees/employee_photos/male/tmp/pic1.png')}}">
                                    @else
                                    <img src="{{asset('assets/images/employees/employee_photos/female/tmp/pic2.png')}}">
                                    @endif
                                    @endif
                                    @else
                                    @if($employee->gender == 'M')
                                    <img src="{{asset('assets/images/employees/employee_photos/male/tmp/pic1.png')}}">
                                    @else
                                    <img src="{{asset('assets/images/employees/employee_photos/female/tmp/pic2.png')}}">
                                    @endif
                                    @endif
                                </div>
                            </div>
                            <div class="col-9">
                                <div class="staff-info">
                                    <h4>{{$employee->firstname}} {{$employee->lastname}}</h4>
                                    <p>
                                        @if($employee->job_title_id)
                                        {{$employee->job_title->name}}
                                        @else
                                        ----
                                        @endif
                                    </p>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="staff-body">
                        <div class="body-row">
                            <label>Department</label>
                            <p>
                                @if($employee->department_id)
                                {{$employee->department->name}}
                                @else
                                ----
                                @endif
                            </p>
                        </div>
                        <div class="body-row">
                            <label>Phone</label>
                            <p>
                                @if($employee->work_phone)
                                {{$employee->work_phone}}
                                @else
                                ----
                                @endif</p>
                        </div>
                        <div class="body-row">
                            <label>Email</label>
                            <p>
                                @if($employee->private_email)
                                {{$employee->private_email}}
                                @else
                                ----
                                @endif</p>
                            </p>
                        </div>
                        <div class="body-row">
                            <label>Home Address</label>
                            <p>
                                @if($employee->home_address)
                                {{$employee->home_address}}
                                @else
                                ----
                                @endif</p>
                            </p>
                        </div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
        @else
        <h4>No data available.</h4>
        @endif()
    </div>
    <div class="card-footer">
        {{$employees->links()}}
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="filter-modal" tabindex="-1" role="dialog" aria-labelledby="filter-label" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="filter-label">Filter Employees</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form class="form-horizontal" method="post" action="/hris/pages/company/staffDirectory/filter" id="form">
                    @csrf
                    <div class="form-group">
                        <label for="department_id">Department: </label>
                        <span class="badge badge-danger">Required</span>
                        <select class="form-control required select2" name="department_id">
                            <option value="0">All</option>
                            @foreach($departments as $department)
                            <option value="{{$department->id}}">{{$department->name}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="form-group">
                        <label for="job_title_id">Job Title: </label>
                        <span class="badge badge-danger">Required</span>
                        <select class="form-control required select2" name="job_title_id">
                            <option value="0">All</option>
                            @foreach($jobTitles as $jobTitle)
                            <option value="{{$jobTitle->id}}">{{$jobTitle->name}}</option>
                            @endforeach
                        </select>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
                <button class="btn btn-success" type="submit" form="form"><i class="fas fa-paper-plane mr-1"></i> Submit</button>
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
<script>
    $(document).ready(function() {
        $('.delete-btn').on('click', function() {
            var get = $('.add-button').attr('href');
            var href = get.replace('create', 'delete');
            var target = $(this).attr('data-target');
            var modal_id = target.replace('#', '');
            var id = target.replace('#modal-', '');
            $('.modal').attr('id', modal_id);
            $('.modal').attr('aria-labelledby', modal_id);
            $('.form-horizontal').attr('action', href + '/' + id);
            $('.form-horizontal').attr('id', 'form-' + id);
            $('.modal-footer > button').attr('form', 'form-' + id);
            var name = $(this).attr('data-name');
            $('.data-name').text('Are you sure you want to delete ' + name + '?');
        });
    });
</script>
@stop