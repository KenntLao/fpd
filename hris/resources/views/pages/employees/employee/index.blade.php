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
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/employees/employee/create"><i class="fa fa-plus mr-1"></i> Create Employee</a>
        </div>
    </div>
    <div class="card-body">
        @if(count($employees) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Image</th>
                        <th>Employee Number</th>
                        <th>Name</th>
                        <th>Mobile Phone</th>
                        <th>Department</th>
                        <th>Gender</th>
                        <th>Supervisor</th>
                        <th>Action</th>
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
                        <td>{{$employee->department}}</td>
                        <td>{{$employee->gender}}</td>
                        <td>{{$employee->supervisor}}</td>
                        <td class="td-action">
                            <div class="row">
                                <div class="col-md-6">
                                    <a class="btn btn-success btn-sm" href="/hris/pages/employees/employee/{{$employee->id}}/edit"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="col-md-6">
                                    <form class="delete-confirm" action="#" method="post">
                                        @method('DELETE')
                                        @csrf
                                        <button class="btn btn-danger btn-sm"><i class="fas fa-trash"></i></button>
                                    </form>
                                </div>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
        @else
        <h4>No data available.</h4>
        @endif()
    </div>
    <div class="card-footer">
        {{$employees->links()}}
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