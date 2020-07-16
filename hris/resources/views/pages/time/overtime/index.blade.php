@extends('adminlte::page')
@section('title', 'HRIS | Overtime Management')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Overtime Management</h1>
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
@if( $_SESSION['sys_role_ids'] == ',1,' )
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Overtime Request List</h3>
    </div>
    <div class="card-body">
        @if(count($overtimes) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>date</th>
                        <th>department</th>
                        <th>employee</th>
                        <th>request date and time</th>
                        <th>approved by</th>
                        <th>approved date</th>
                        <th>status</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overtimes as $overtime)
                    <tr>
                        <td>{{date("M d, Y - h:i:sa", strtotime($overtime->created_at))}}</td>
                        <td>{{$overtime->employee->department->name}}</td>
                        <td>{{$overtime->employee->firstname}} {{$overtime->employee->lastname}}</td>
                        <td>{{date('M-d-Y', strtotime($overtime->ot_date))}} {{$overtime->ot_time_in}} - {{$overtime->ot_time_out}}</td>
                        <td>
                            @if($overtime->supervisor)
                            @if($overtime->role_id == ',1,')
                            @php
                            {{
                            $users = App\users::find($overtime->supervisor_id);
                            echo $users->uname;
                            }}
                            @endphp
                            @else
                            {{$overtime->supervisor->firstname}} {{$overtime->supervisor->lastname}}
                            @endif
                            @else
                            None
                            @endif
                        </td>
                        <td>
                            @if($overtime->approved_date)
                            {{date("M d, Y - h:i:sa", strtotime($overtime->approved_date))}}
                            @else
                            @endif
                        </td>
                        <td>
                            @if($overtime->status == '0')
                            Pending
                            @endif
                            @if($overtime->status == '1')
                            Approved
                            @endif
                            @if($overtime->status == '2')
                            Denied
                            @endif
                        </td>
                        <td>
                            <div class="row no-gutters">
                                @if($overtime->status == '1' OR $overtime->status == '2')
                                <div class="col-12">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/time/overtime/{{$overtime->id}}/show"><i class="fas fa-search"></i></a>
                                </div>
                                @else
                                <div class="col-md-6">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/time/overtime/1/{{$overtime->id}}/edit" title="Approve request"><i class="fas fa-check-square"></i></a>
                                </div>
                                <div class="col-md-6">
                                    <a class="btn btn-warning btn-sm" href="/hris/pages/time/overtime/2/{{$overtime->id}}/edit" title="Deny request"><i class="fas fa-times"></i></a>
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
        {{$overtimes->links()}}
    </div>
</div>
@else
@if(in_array($supervisor_id, $role_ids))
<div class="row no-gutters">
    <ul class="nav nav-tabs" role="tablist" style="border-bottom: 0;">
        <li class="nav-item tab-item">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">My Overtime Requests</a>
        </li>
        <li class="nav-item tab-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Subordinate Overtime Requests</a>
        </li>
    </ul>
</div>
<div class="tab-content" style="padding-top: 0;">
    <div class="tab-pane active" id="tabs-1" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Overtime Request List</h3>
                <div class="card-tools">
                    <a class="btn add-button btn-md" href="/hris/pages/time/overtime/create"><i class="fa fa-plus mr-1"></i> Request Overtime</a>
                </div>
            </div>
            <div class="card-body">
                @if(count($self) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>date</th>
                                <th>employee</th>
                                <th>request date and time</th>
                                <th>approved by</th>
                                <th>approved date</th>
                                <th>status</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($self as $s)
                            <tr>
                                <td>{{date("M d, Y - h:i:sa", strtotime($s->created_at))}}</td>
                                <td>{{$s->employee->firstname}} {{$s->employee->lastname}}</td>
                                <td>{{date_format(date_create_from_format('m-d-Y', $s->ot_date), 'M d, Y')}} {{$s->ot_time_in}} - {{$s->ot_time_out}}</td>
                                <td>
                                    @if($s->supervisor)
                                    @if($s->role_id == ',1,')
                                    @php
                                    {{
                                    $users = App\users::find($s->supervisor_id);
                                    echo $users->uname;
                                    }}
                                    @endphp
                                    @else
                                    {{$s->supervisor->firstname}} {{$s->supervisor->lastname}}
                                    @endif
                                    @else
                                    None
                                    @endif
                                </td>
                                <td>
                                    @if($s->approved_date)
                                    {{date("M d, Y - h:i:sa", strtotime($s->approved_date))}}
                                    @else
                                    @endif
                                </td>
                                <td>
                                    @if($s->status == '0')
                                    Pending
                                    @endif
                                    @if($s->status == '1')
                                    Approved
                                    @endif
                                    @if($s->status == '2')
                                    Denied
                                    @endif
                                </td>
                                <td>
                                    <div class="row no-gutters">
                                        @if($s->status == '1' OR $s->status == '2')
                                        <div class="col-12">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/time/overtime/{{$s->id}}/show"><i class="fas fa-search"></i></a>
                                        </div>
                                        @else
                                        <div class="col-6">
                                            <a class="btn btn-success btn-sm" href="/hris/pages/time/overtime/{{$s->id}}/edit"><i class="fas fa-edit"></i></a>
                                        </div>
                                        <div class="col-6">
                                            <!-- Button trigger modal -->
                                            <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$s->id}}" data-name="Overtime request - {{$s->created_at}} from {{$s->employee->firstname}} {{$s->employee->lastname}}"><i class="fa fa-trash"></i></button>
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
    <div class="tab-pane" id="tabs-2" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Overtime Request List</h3>
            </div>
            <div class="card-body">
                @if(count($overtimes) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>date</th>
                                <th>employee</th>
                                <th>request date and time</th>
                                <th>approved by</th>
                                <th>approved date</th>
                                <th>status</th>
                                <th>actions</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($overtimes as $overtime)
                            <tr>
                                <td>{{date("M d, Y - h:i:sa", strtotime($overtime->created_at))}}</td>
                                <td>{{$overtime->employee->firstname}} {{$overtime->employee->lastname}}</td>
                                <td>{{date_format(date_create_from_format('m-d-Y', $overtime->ot_date), 'M d, Y')}} {{$overtime->ot_time_in}} - {{$overtime->ot_time_out}}</td>
                                <td>
                                    @if($overtime->supervisor)
                                    @if($overtime->role_id == ',1,')
                                    @php
                                    {{
                                    $users = App\users::find($overtime->supervisor_id);
                                    echo $users->uname;
                                    }}
                                    @endphp
                                    @else
                                    {{$overtime->supervisor->firstname}} {{$overtime->supervisor->lastname}}
                                    @endif
                                    @else
                                    None
                                    @endif
                                </td>
                                <td>
                                    @if($overtime->approved_date)
                                    {{date("M d, Y - h:i:sa", strtotime($overtime->approved_date))}}
                                    @else
                                    @endif
                                </td>
                                <td>
                                    @if($overtime->status == '0')
                                    Pending
                                    @endif
                                    @if($overtime->status == '1')
                                    Approved
                                    @endif
                                    @if($overtime->status == '2')
                                    Denied
                                    @endif
                                </td>
                                <td>
                                    <div class="row no-gutters">
                                        @if($overtime->status == '1' OR $overtime->status == '2')
                                        <div class="col-12">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/time/overtime/{{$overtime->id}}/show"><i class="fas fa-search"></i></a>
                                        </div>
                                        @else
                                        <div class="col-md-6">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/time/overtime/1/{{$overtime->id}}/edit" title="Approve request"><i class="fas fa-check-square"></i></a>
                                        </div>
                                        <div class="col-md-6">
                                            <a class="btn btn-warning btn-sm" href="/hris/pages/time/overtime/2/{{$overtime->id}}/edit" title="Deny request"><i class="fas fa-times"></i></a>
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
                {{$overtimes->links()}}
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Overtime Request List</h3>
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/time/overtime/create"><i class="fa fa-plus mr-1"></i> Request Overtime</a>
        </div>
    </div>
    <div class="card-body">
        @if(count($overtimes) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>date</th>
                        <th>employee</th>
                        <th>request date and time</th>
                        <th>approved by</th>
                        <th>approved date</th>
                        <th>status</th>
                        <th>actions</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($overtimes as $overtime)
                    <tr>
                        <td>{{date("M d, Y - h:i:sa", strtotime($overtime->created_at))}}</td>
                        <td>{{$overtime->employee->firstname}} {{$overtime->employee->lastname}}</td>
                        <td>{{date_format(date_create_from_format('m-d-Y', $overtime->ot_date), 'M d, Y')}} {{$overtime->ot_time_in}} - {{$overtime->ot_time_out}}</td>
                        <td>
                            @if($overtime->supervisor)
                            @if($overtime->role_id == ',1,')
                            @php
                            {{
                            $users = App\users::find($overtime->supervisor_id);
                            echo $users->uname;
                            }}
                            @endphp
                            @else
                            {{$overtime->supervisor->firstname}} {{$overtime->supervisor->lastname}}
                            @endif
                            @else
                            None
                            @endif
                        </td>
                        <td>
                            @if($overtime->approved_date)
                            {{date("M d, Y - h:i:sa", strtotime($overtime->approved_date))}}
                            @else
                            @endif
                        </td>
                        <td>
                            @if($overtime->status == '0')
                            Pending
                            @endif
                            @if($overtime->status == '1')
                            Approved
                            @endif
                            @if($overtime->status == '2')
                            Denied
                            @endif
                        </td>
                        <td class="td-action">
                            <div class="row no-gutters">
                                @if($overtime->status == '1' OR $overtime->status == '2')
                                <div class="col-12">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/time/overtime/{{$overtime->id}}/show"><i class="fas fa-search"></i></a>
                                </div>
                                @else
                                <div class="col-6">
                                    <a class="btn btn-success btn-sm" href="/hris/pages/time/overtime/{{$overtime->id}}/edit"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="col-6">
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$overtime->id}}" data-name="Overtime request - {{$overtime->created_at}} from {{$overtime->employee->firstname}} {{$overtime->employee->lastname}}"><i class="fa fa-trash"></i></button>
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
        {{$overtimes->links()}}
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