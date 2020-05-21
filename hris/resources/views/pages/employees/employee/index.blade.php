@extends('adminlte::page')

@section('title', 'My FPD | Employees')

@section('content_header')
<h1 class="m-0 text-dark">Employees</h1>
@stop

@section('content')
@if ($message = Session::get('success'))
<div class="alert alert-success alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <strong>{{ $message }}</strong>
</div>
@endif
<div class="row">
    <div class="col-12">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Employee List</h3>
                <a href="#" class="btn btn-success float-right"><i class="fas fa-plus"></i> Create Employee</a>
            </div>
            <!-- /.card-header -->
            <div class="card-body">
                <table class="table table-bordered">
                    <thead>
                        <tr>
                            <th>Employee No.</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Mobile No.</th>
                            <th>Department</th>
                            <th>Gender</th>
                            <th>Supervisor</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($employees as $employee)
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                        </tr>
                        @empty
                        <p>No Data to show</p>
                        @endforelse
                    </tbody>
                </table>
            </div>
            <!-- /.card-body -->
            <div class="card-footer clearfix">
                <div class="float-right">
                    {{ $employees->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="/css/admin_css/frozseana.css">
@stop
@section('js')
@stop