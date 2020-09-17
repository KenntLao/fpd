@extends('adminlte::page')
@section('title', 'HRIS | Work Shift Assignment')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Work Shift Assignment</h1>
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
@if($_SESSION['sys_role_ids'] == ',1,')
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Work Shift Assignments</h3>
        @if(in_array('workshift-add-assignment', $_SESSION['sys_permissions']))
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/time/workshiftAssignment/create"><i class="fa fa-plus mr-1"></i> Assign Work Shift</a>
        </div>
        @endif
    </div>
    <div class="card-body">
        @if(count($workshift_assignment) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed table-data">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Work Shift</th>
                        <th>Date from</th>
                        <th>Date to</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workshift_assignment as $assignment)
                    <tr>
                        <td>@if($assignment->employee){{$assignment->employee->firstname}} {{$assignment->employee->lastname}}@endif</td>
                        <td>{{!empty($assignment->workshift) ? $assignment->workshift->workshift_name:''}} </td>
                        <td>{{date('Y-m-d', strtotime($assignment->date_from))}}</td>
                        <td>{{date('Y-m-d', strtotime($assignment->date_to))}}</td>
                        <td>
                            @if($assignment->status == 0)
                            Pending
                            @endif
                            @if($assignment->status == 1)
                            Approved
                            @endif
                            @if($assignment->status == 2)
                            Denied
                            @endif
                        </td>
                        <td>
                            @if($assignment->status == 0)
                            <a class="btn btn-success btn-sm" href="/hris/pages/time/workshiftAssignment/{{$assignment->id}}/edit" style="margin: 0 3px"><i class="fas fa-edit"></i></a>
                            <!-- Button trigger modal -->
                            <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$assignment->id}}" data-name="this work shift" style="margin: 0 3px"><i class="fa fa-trash"></i></button>
                            <a class="btn btn-primary btn-sm" href="/hris/pages/time/workshiftAssignment/{{$assignment->id}}/1/status" style="margin: 0 3px"><i class="fas fa-check-square"></i></a>
                            <a class="btn btn-warning btn-sm" href="/hris/pages/time/workshiftAssignment/{{$assignment->id}}/2/status" style="margin: 0 3px"><i class="fas fa-times"></i></a>
                            @else
                            -- --
                            @endif
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
        {{$workshift_assignment->links()}}
    </div>
</div>
@else
@if(in_array($supervisor_id, $sys_role_ids) OR in_array($hr_officer_id, $sys_role_ids))
<div class="row no-gutters">
    <ul class="nav nav-tabs" role="tablist" style="border-bottom: 0;">
        <li class="nav-item tab-item">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">My Work Shift Assignments</a>
        </li>
        <li class="nav-item tab-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Subordinate Work Shift Assignments</a>
        </li>
    </ul>
</div>
<div class="tab-content" style="padding-top: 0;">
    <div class="tab-pane active" id="tabs-1" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Work Shift Assignments</h3>
                @if(in_array('workshift-add-assignment', $_SESSION['sys_permissions']))
                <div class="card-tools">
                    <a class="btn add-button btn-md" href="/hris/pages/time/workshiftAssignment/create"><i class="fa fa-plus mr-1"></i> Assign Work Shift</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                @if(count($self) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed table-data">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Work Shift</th>
                                <th>Date from</th>
                                <th>Date to</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>

                            @foreach($self as $s)
                            <tr>
                                <td>@if($s->employee){{$s->employee->firstname}} {{$s->employee->lastname}}@endif</td>
                                <td>{{!empty($s->workshift) ? $s->workshift->workshift_name:''}} </td>
                                <td>{{date('Y-m-d', strtotime($s->date_from))}}</td>
                                <td>{{date('Y-m-d', strtotime($s->date_to))}}</td>
                                <td>
                                    @if($s->status == 0)
                                    Pending
                                    @endif
                                    @if($s->status == 1)
                                    Approved
                                    @endif
                                    @if($s->status == 2)
                                    Denied
                                    @endif
                                </td>
                                <td>
                                    @if($s->status == 0)
                                    <a class="btn btn-success btn-sm" href="/hris/pages/time/workshiftAssignment/{{$s->id}}/edit" style="margin: 0 3px"><i class="fas fa-edit"></i></a>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$s->id}}" data-name="this work shift" style="margin: 0 3px"><i class="fa fa-trash"></i></button>
                                    @else
                                    -- --
                                    @endif
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
                {{$self->links()}}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="tabs-2" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Work Shift Assignments</h3>
            </div>
            <div class="card-body">
                @if(count($workshift_assignment) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed table-data">
                        <thead>
                            <tr>
                                <th>Employee</th>
                                <th>Work Shift</th>
                                <th>Date from</th>
                                <th>Date to</th>
                                <th>Status</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($workshift_assignment as $assignment)
                            <tr>
                                <td>@if($assignment->employee){{$assignment->employee->firstname}} {{$assignment->employee->lastname}}@endif</td>
                                <td>{{!empty($assignment->workshift) ? $assignment->workshift->workshift_name:''}} </td>
                                <td>{{date('Y-m-d', strtotime($assignment->date_from))}}</td>
                                <td>{{date('Y-m-d', strtotime($assignment->date_to))}}</td>
                                <td>
                                    @if($assignment->status == 0)
                                    Pending
                                    @endif
                                    @if($assignment->status == 1)
                                    Approved
                                    @endif
                                    @if($assignment->status == 2)
                                    Denied
                                    @endif
                                </td>
                                <td>
                                    @if($assignment->status == 0)
                                    <a class="btn btn-success btn-sm" href="/hris/pages/time/workshiftAssignment/{{$assignment->id}}/edit" style="margin: 0 3px"><i class="fas fa-edit"></i></a>
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$assignment->id}}" data-name="this work shift" style="margin: 0 3px"><i class="fa fa-trash"></i></button>
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/time/workshiftAssignment/{{$assignment->id}}/1/status" style="margin: 0 3px"><i class="fas fa-check-square"></i></a>
                                    <a class="btn btn-warning btn-sm" href="/hris/pages/time/workshiftAssignment/{{$assignment->id}}/2/status" style="margin: 0 3px"><i class="fas fa-times"></i></a>
                                    @else
                                    -- --
                                    @endif
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
                {{$workshift_assignment->links()}}
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Work Shift Assignments</h3>
        @if(in_array('workshift-add-assignment', $_SESSION['sys_permissions']))
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/time/workshiftAssignment/create"><i class="fa fa-plus mr-1"></i> Assign Work Shift</a>
        </div>
        @endif
    </div>
    <div class="card-body">
        @if(count($workshift_assignment) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed table-data">
                <thead>
                    <tr>
                        <th>Employee</th>
                        <th>Work Shift</th>
                        <th>Date from</th>
                        <th>Date to</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($workshift_assignment as $assignment)
                    <tr>
                        <td>@if($assignment->employee){{$assignment->employee->firstname}} {{$assignment->employee->lastname}}@endif</td>
                        <td>{{!empty($assignment->workshift) ? $assignment->workshift->workshift_name:''}} </td>
                        <td>{{date('Y-m-d', strtotime($assignment->date_from))}}</td>
                        <td>{{date('Y-m-d', strtotime($assignment->date_to))}}</td>
                        <td>
                            @if($assignment->status == 0)
                            Pending
                            @endif
                            @if($assignment->status == 1)
                            Approved
                            @endif
                            @if($assignment->status == 2)
                            Denied
                            @endif
                        </td>
                        <td>
                            @if($assignment->status == 0)
                            <a class="btn btn-success btn-sm" href="/hris/pages/time/workshiftAssignment/{{$assignment->id}}/edit" style="margin: 0 3px"><i class="fas fa-edit"></i></a>
                            <!-- Button trigger modal -->
                            <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$assignment->id}}" data-name="this work shift" style="margin: 0 3px"><i class="fa fa-trash"></i></button>
                            @else
                            -- --
                            @endif
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
        {{$workshift_assignment->links()}}
    </div>
</div>
@endif
@endif
<div class="modal fade" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Delete Confirmation</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p class="data-name"></p>
                <hr>
                <form class="form-horizontal" method="post">
                    @csrf
                    @method('DELETE')
                    <div class="form-group">
                        <label for="upass">Enter Password: </label>
                        <input class="form-control" type="password" name="upass" required>
                    </div>
                </form>
            </div>
            <div class="modal-footer">
                <button class="btn btn-danger" type="submit"><i class="fa fa-check"></i> Confirm Delete</button>
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
<script>
    $(function() {
        $('.table-data').DataTable({
            "paging": false,
            "lengthChange": false,
            "searching": true,
            "ordering": true,
        });
    });
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