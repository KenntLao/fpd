@extends('adminlte::page')
@section('title', 'HRIS | Leave Management')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> leave Management</h1>
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
@if ($message = Session::get('error'))
<div class="alert alert-danger alert-block">
    <button type="button" class="close" data-dismiss="alert">×</button>
    <p><i class="fas fa-fw fa-exclamation-circle"></i>{{$message}}</p>
</div>
@endif
<div class="row no-gutters">
    @if(in_array($supervisor_id, $role_ids))
    <ul class="nav nav-tabs" role="tablist" style="border-bottom: 0;">
        <li class="nav-item tab-item">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">My Leave list</a>
        </li>
        <li class="nav-item tab-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Subordinate Leave Requests</a>
        </li>
    </ul>
    @endif
</div>
<div class="tab-content" style="padding-top: 0;">
    <div class="tab-pane active" id="tabs-1" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Leave Request List</h3>
                <div class="card-tools">
                    @if($_SESSION['sys_account_mode'] == 'employee')
                    <a class="btn add-button btn-md" href="/hris/pages/leaveManagement/leaves/create"><i class="fa fa-plus mr-1"></i> Apply Leave</a>
                    @endif
                </div>
            </div>
            <div class="card-body">
                @if(count($self) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>approved by</th>
                                <th>approved date</th>
                                <th>reason</th>
                                <th>status</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($self as $s)
                            <tr>
                                <td>{{$s->created_at}}</td>
                                <td>{{$s->leave_types->name}}</td>
                                <td>{{date("Y-m-d", strtotime($s->leave_start_date))}}</td>
                                <td>{{date("Y-m-d", strtotime($s->leave_end_date))}}</td>
                                <td>{{$s->approved_by_id}}</td>
                                <td>{{$s->apporved_date}}</td>
                                <td>{{$s->reason}}</td>
                                <td>
                                    @if($s->status == 0){{'Pending'}}
                                    @elseif($s->status == 1) {{'Approved'}}
                                    @elseif($s->status == 2) {{'Denied'}}
                                    @endif
                                </td>
                                <td>
                                    <div class="row no-gutters">
                                        @if($s->status == 1 OR $s->status == 2)
                                        <div class="col-12">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/leaveManagement/leaves/{{$s->id}}/show"><i class="fas fa-search"></i></a>
                                        </div>
                                        @else
                                        <div class="col-md-12">
                                            <a class="btn btn-success btn-sm" href="/hris/pages/leaveManagement/leaves/{{$s->id}}/edit" title="Edit"><i class="fas fa-edit"></i></a>
                                        </div>
                                        @endif
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
                {{$self->links()}}
            </div>
        </div>
    </div>
    @if(in_array($supervisor_id, $role_ids))
    <div class="tab-pane" id="tabs-2" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Subordinate Leave Request List</h3>
            </div>
            <div class="card-body">
                @if(count($leaves) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>Date</th>
                                <th>Leave Type</th>
                                <th>Start Date</th>
                                <th>End Date</th>
                                <th>approved by</th>
                                <th>approved date</th>
                                <th>reason</th>
                                <th>status</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($leaves as $leave)
                            <tr>
                                <td>{{$leave->created_at}}</td>
                                <td>{{$leave->leave_types->name}}</td>
                                <td>{{date("Y-m-d", strtotime($leave->leave_start_date))}}</td>
                                <td>{{date("Y-m-d", strtotime($leave->leave_end_date))}}</td>
                                <td>
                                    @if($leave->supervisor)
                                    {{$leave->supervisor->firstname .' ' . $leave->supervisor->lastname}}
                                    @endif
                                </td>
                                <td>{{date("Y-m-d", strtotime($leave->approved_date))}}</td>
                                <td>{{$leave->reason}}</td>
                                <td>
                                    @if($leave->status == 0) <span class="badge badge-primary p-2">{{'Pending'}}</span>
                                    @elseif($leave->status == 1) <span class="badge badge-success p-2">{{'Approved'}}</span>
                                    @elseif($leave->status == 2) <span class="badge badge-danger p-2">{{'Denied'}}</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="row no-gutters">
                                        @if($leave->status == 0)
                                        <div class="col-md-6">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/leaveManagement/leaves/{{$leave->id}}/approve" title="Approve"><i class="fas fa-check-square"></i></a>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-danger btn-sm" href="/hris/pages/leaveManagement/leaves/{{$leave->id}}/deny" title="Deny"><i class="fas fa-times"></i></a>
                                        </div>
                                        @endif

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
                {{$leaves->links()}}
            </div>
        </div>
    </div>
    @endif
</div>
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