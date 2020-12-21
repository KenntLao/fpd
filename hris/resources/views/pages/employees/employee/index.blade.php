@extends('adminlte::page')
@section('title', 'HRIS | Employees - Employee')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Employee Management</h1>
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
        <h3 class="card-title">Employee List</h3>
        @if(in_array('employee-add',$_SESSION['sys_permissions']))
        <div class="card-tools">
            <form class="float-right ml-2" action="/hris/pages/employees/employee/import" method="post" enctype="multipart/form-data">
                @csrf
                <input type="file" name="employeeData" id="file" style="display:none;" onchange="this.form.submit()">
                <button class="btn add-button btn-md" type="button" id="upload-exc" name="button" onclick="thisFileUpload();"><i class="far fa-file-excel mr-1"></i> Upload Excel</button>
            </form>
            <a class="btn add-button btn-md" href="/hris/pages/employees/employee/create"><i class="fa fa-plus mr-1"></i> Create Employee</a>
        </div>
        @endif
    </div>
    <div class="card-body">
        @if(count($employees) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed table-data">
                <!-- <a href="/hris/pages/employees/employee/download">dl</a> -->
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Employee Number</th>
                        <th>Name</th>
                        <th>Mobile Phone</th>
                        <th>Department</th>
                        <th>Project</th>
                        <th>Supervisor</th>
                        @if(in_array('employee-add',$_SESSION['sys_permissions']) || in_array('employee-edit',$_SESSION['sys_permissions']) || in_array('employee-delete',$_SESSION['sys_permissions']))
                        <th>Action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($employees as $employee)
                    <tr>
                        <td>
                            <div class="table-image-container">
                                <img src="{{asset('assets/images/employees/employee_photos/')}}/{{$employee->employee_photo}}">
                            </div>
                        </td>
                        <td><a class="clickable-info" href="/hris/pages/employees/employee/{{$employee->id}}">{{$employee->employee_number}}</a></td>
                        <td><a class="clickable-info" href="/hris/pages/employees/employee/{{$employee->id}}">{{$employee->firstname}} {{$employee->middlename}} {{$employee->lastname}}</a></td>
                        <td>{{$employee->work_no}}</td>
                        <td>
                            @php
                            if($employee->department){
                            $employee_dept = $employee->department->name;
                            } else {
                            $employee_dept = "N/A";
                            }

                            echo $employee_dept;

                            @endphp
                        </td>
                        <td>
                            @if($employee->employeeProject)
                            @php
                            $emp_project = App\hris_projects::where('id',$employee->employeeProject->id)->first();
                            echo $emp_project['name'];
                            @endphp
                            @endif
                        </td>
                        <td>
                            @php
                            {{

                                    $emp = App\hris_employee::where('id',$employee->supervisor)->first();  
                                    if($emp !== NULL){
                                        echo $emp->firstname . ' ' . $emp->lastname;
                                    }
                            }}
                            @endphp

                        </td>
                        @if(in_array('employee-add',$_SESSION['sys_permissions']))
                        <td class="td-action">
                            <div class="row no-gutters">
                                @if($role_id == 1)
                                <div class="col-md-12">
                                    <a class="btn btn-success btn-sm" href="/hris/pages/employees/employee/{{$employee->id}}/edit"><i class="fas fa-edit"></i></a>
                                </div>
                                @else
                                <div class="col-md-12">
                                    <a class="btn btn-success btn-sm" href="/hris/pages/employees/employee/{{$employee->id}}/edit"><i class="fas fa-edit"></i></a>
                                </div>
                                @endif
                            </div>
                        </td>
                        @endif
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h4>No data available.</h4>
        @endif()
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
<script>
    function thisFileUpload() {
        document.getElementById("file").click();
    };

    $('.table-data').DataTable({
        "paging": true,
        "lengthChange": false,
        "searching": true,
        "ordering": true,
    });
</script>
@stop