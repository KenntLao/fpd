@extends('adminlte::page')
@section('title', 'HRIS | Itinerary - Itinerary Request')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Itinerary Request</h1>
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
@php
$hr_officer_role_id = App\roles::where('role_name', 'hr officer')->get('id')->toArray();
$hr_officer_id = implode(' ', $hr_officer_role_id[0]);
$roles = explode(',', $_SESSION['sys_role_ids']);
@endphp
@if( $_SESSION['sys_role_ids'] == ',1,' OR in_array($hr_officer_id, $roles) )
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Itinerary Request List</h3>
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/employees/itineraryRequests/create"><i class="fa fa-plus mr-1"></i> Create Itenerary Request</a>
        </div>
    </div>
    <div class="card-body">
        @if(count($itineraryRequests) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>employee</th>
                        <th>approved by</th>
                        <th>travel date</th>
                        <th>return date</th>
                        <th>from</th>
                        <th>to</th>
                        <th>purpose</th>
                        <th>status</th>
                        <th>action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($itineraryRequests as $itineraryRequest)
                    <tr>
                        <td>{{$itineraryRequest->employee->firstname}} {{$itineraryRequest->employee->lastname}}</td>
                        <td>
                            @if($itineraryRequest->supervisor)
                            @if($itineraryRequest->role_id == ',1,')
                            @php
                            {{
                            $users = App\users::find($itineraryRequest->supervisor_id);
                            echo $users->uname;
                            }}
                            @endphp
                            @else
                            {{$itineraryRequest->supervisor->firstname}} {{$itineraryRequest->supervisor->lastname}}
                            @endif
                            @else
                            None
                            @endif
                        </td>
                        <td>
                            @php
                            echo date('M d, Y H:i A', strtotime($itineraryRequest->travel_date));
                            @endphp
                        </td>
                        <td>
                            @php
                            echo date('M d, Y H:i A', strtotime($itineraryRequest->return_date));
                            @endphp
                        </td>
                        <td>{{$itineraryRequest->travel_from}}</td>
                        <td>{{$itineraryRequest->travel_to}}</td>
                        <td>{{$itineraryRequest->purpose}}</td>
                        <td>
                            @if($itineraryRequest->status == '0')
                            Pending
                            @endif
                            @if($itineraryRequest->status == '1')
                            Approved
                            @endif
                            @if($itineraryRequest->status == '2')
                            Denied
                            @endif
                        </td>
                        <td>
                            <div class="row no-gutters">
                                @if($itineraryRequest->status == '1' OR $itineraryRequest->status == '2')
                                <div class="col-12">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/show"><i class="fas fa-search"></i></a>
                                </div>
                                @else
                                <div class="col-3">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/show"><i class="fas fa-search"></i></a>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-warning btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/edit"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-success btn-sm" href="/hris/pages/employees/itineraryRequests/updateStatus/1/{{$itineraryRequest->id}}"><i class="fas fa-check-square"></i></a>
                                </div>
                                <div class="col-3">
                                    <a class="btn btn-danger btn-sm" href="/hris/pages/employees/itineraryRequests/updateStatus/2/{{$itineraryRequest->id}}"><i class="fas fa-times"></i></a>
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
        {{$itineraryRequests->links()}}
    </div>
</div>
@else
@if(in_array($supervisor_id, $role_ids))
<div class="row no-gutters">
    <ul class="nav nav-tabs" role="tablist" style="border-bottom: 0;">
        <li class="nav-item tab-item">
            <a class="nav-link active" data-toggle="tab" href="#tabs-1" role="tab">My Itenerary Requests</a>
        </li>
        <li class="nav-item tab-item">
            <a class="nav-link" data-toggle="tab" href="#tabs-2" role="tab">Subordinate Itenerary Requests</a>
        </li>
    </ul>
</div>
<div class="tab-content" style="padding-top: 0;">
    <div class="tab-pane active" id="tabs-1" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Itenerary Request List</h3>
                @if(in_array('itenerary-request-add', $_SESSION['sys_permissions']))
                <div class="card-tools">
                    <a class="btn add-button btn-md" href="/hris/pages/employees/itineraryRequests/create"><i class="fa fa-plus mr-1"></i> Create Itenerary Request</a>
                </div>
                @endif
            </div>
            <div class="card-body">
                @if(count($self) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>employee</th>
                                <th>approved by</th>
                                <th>travel date</th>
                                <th>return date</th>
                                <th>from</th>
                                <th>to</th>
                                <th>purpose</th>
                                <th>status</th>
                                @if(in_array('itenerary-request-edit', $_SESSION['sys_permissions']) OR in_array('itenerary-request-delete', $_SESSION['sys_permissions']))
                                <th>action</th>
                                @endif
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($self as $s)
                            <tr>
                                <td>{{$s->employee->firstname}} {{$s->employee->lastname}}</td>
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
                                    @php
                                    echo date('M d, Y H:i A', strtotime($s->travel_date));
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    echo date('M d, Y H:i A', strtotime($s->return_date));
                                    @endphp
                                </td>
                                <td>{{$s->travel_from}}</td>
                                <td>{{$s->travel_to}}</td>
                                <td>{{$s->purpose}}</td>
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
                                @if(in_array('itenerary-request-edit', $_SESSION['sys_permissions']) OR in_array('itenerary-request-delete', $_SESSION['sys_permissions']))
                                <td>
                                    <div class="row no-gutters">
                                        @if($s->status == '1' OR $s->status == '2')
                                        <div class="col-12">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$s->id}}/show"><i class="fas fa-search"></i></a>
                                        </div>
                                        @else
                                        <div class="col-4">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$s->id}}/show"><i class="fas fa-search"></i></a>
                                        </div>
                                        @if(in_array('itenerary-request-edit', $_SESSION['sys_permissions']))
                                        <div class="col-4">
                                            <a class="btn btn-success btn-sm" href="/hris/pages/employees/itineraryRequests/{{$s->id}}/edit"><i class="fas fa-edit"></i></a>
                                        </div>
                                        @endif
                                        @if(in_array('itenerary-request-delete', $_SESSION['sys_permissions']))
                                        <div class="col-4">
                                            <!-- Button trigger modal -->
                                            <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$s->id}}" data-name="Itenerary request - {{$s->created_at}} from {{$s->employee->firstname}} {{$s->employee->lastname}}"><i class="fa fa-trash"></i></button>
                                        </div>
                                        @endif
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
            <div class="card-footer">
                {{$self->links()}}
            </div>
        </div>
    </div>
    <div class="tab-pane" id="tabs-2" role="tab-panel">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Itenerary Request List</h3>
            </div>
            <div class="card-body">
                @if(count($itineraryRequests) > 0)
                <div class="table-responsive">
                    <table class="table table-hover table-bordered table-striped table-condensed">
                        <thead>
                            <tr>
                                <th>employee</th>
                                <th>approved by</th>
                                <th>travel date</th>
                                <th>return date</th>
                                <th>from</th>
                                <th>to</th>
                                <th>purpose</th>
                                <th>status</th>
                                <th>action</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($itineraryRequests as $itineraryRequest)
                            <tr>
                                <td>{{$itineraryRequest->employee->firstname}} {{$itineraryRequest->employee->lastname}}</td>
                                <td>
                                    @if($itineraryRequest->supervisor)
                                    @if($itineraryRequest->role_id == ',1,')
                                    @php
                                    {{
                                    $users = App\users::find($itineraryRequest->supervisor_id);
                                    echo $users->uname;
                                    }}
                                    @endphp
                                    @else
                                    {{$itineraryRequest->supervisor->firstname}} {{$itineraryRequest->supervisor->lastname}}
                                    @endif
                                    @else
                                    None
                                    @endif
                                </td>
                                <td>
                                    @php
                                    echo date('M d, Y H:i A', strtotime($itineraryRequest->travel_date));
                                    @endphp
                                </td>
                                <td>
                                    @php
                                    echo date('M d, Y H:i A', strtotime($itineraryRequest->return_date));
                                    @endphp
                                </td>
                                <td>{{$itineraryRequest->travel_from}}</td>
                                <td>{{$itineraryRequest->travel_to}}</td>
                                <td>{{$itineraryRequest->purpose}}</td>
                                <td>
                                    @if($itineraryRequest->status == '0')
                                    Pending
                                    @endif
                                    @if($itineraryRequest->status == '1')
                                    Approved
                                    @endif
                                    @if($itineraryRequest->status == '2')
                                    Denied
                                    @endif
                                </td>
                                <td>
                                    <div class="row no-gutters">
                                        @if($itineraryRequest->status == '1' OR $itineraryRequest->status == '2')
                                        <div class="col-12">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/show"><i class="fas fa-search"></i></a>
                                        </div>
                                        @else
                                        <div class="col-4">
                                            <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/show"><i class="fas fa-search"></i></a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-success btn-sm" href="/hris/pages/employees/itineraryRequests/updateStatus/1/{{$itineraryRequest->id}}"><i class="fas fa-check-square"></i></a>
                                        </div>
                                        <div class="col-4">
                                            <a class="btn btn-danger btn-sm" href="/hris/pages/employees/itineraryRequests/updateStatus/2/{{$itineraryRequest->id}}"><i class="fas fa-times"></i></a>
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
                {{$itineraryRequests->links()}}
            </div>
        </div>
    </div>
</div>
@else
<div class="card">
    <div class="card-header">
        <h3 class="card-title">Itenerary Request List</h3>
        @if(in_array('itenerary-request-add', $_SESSION['sys_permissions']))
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/employees/itineraryRequests/create"><i class="fa fa-plus mr-1"></i> Create Itenerary Request</a>
        </div>
        @endif
    </div>
    <div class="card-body">
        @if(count($itineraryRequests) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>employee</th>
                        <th>approved by</th>
                        <th>travel date</th>
                        <th>return date</th>
                        <th>from</th>
                        <th>to</th>
                        <th>purpose</th>
                        <th>status</th>
                        @if(in_array('itenerary-request-edit', $_SESSION['sys_permissions']) OR in_array('itenerary-request-delete', $_SESSION['sys_permissions']))
                        <th>action</th>
                        @endif
                    </tr>
                </thead>
                <tbody>
                    @foreach($itineraryRequests as $itineraryRequest)
                    <tr>
                        <td>{{$itineraryRequest->employee->firstname}} {{$itineraryRequest->employee->lastname}}</td>
                        <td>
                            @if($itineraryRequest->supervisor)
                            @if($itineraryRequest->role_id == ',1,')
                            @php
                            {{
                            $users = App\users::find($itineraryRequest->supervisor_id);
                            echo $users->uname;
                            }}
                            @endphp
                            @else
                            {{$itineraryRequest->supervisor->firstname}} {{$itineraryRequest->supervisor->lastname}}
                            @endif
                            @else
                            None
                            @endif
                        </td>
                        <td>
                            @php
                            echo date('M d, Y H:i A', strtotime($itineraryRequest->travel_date));
                            @endphp
                        </td>
                        <td>
                            @php
                            echo date('M d, Y H:i A', strtotime($itineraryRequest->return_date));
                            @endphp
                        </td>
                        <td>{{$itineraryRequest->travel_from}}</td>
                        <td>{{$itineraryRequest->travel_to}}</td>
                        <td>{{$itineraryRequest->purpose}}</td>
                        <td>
                            @if($itineraryRequest->status == '0')
                            Pending
                            @endif
                            @if($itineraryRequest->status == '1')
                            Approved
                            @endif
                            @if($itineraryRequest->status == '2')
                            Denied
                            @endif
                        </td>
                        @if(in_array('itenerary-request-edit', $_SESSION['sys_permissions']) OR in_array('itenerary-request-delete', $_SESSION['sys_permissions']))
                        <td>
                            <div class="row no-gutters">
                                @if($itineraryRequest->status == '1' OR $itineraryRequest->status == '2')
                                <div class="col-12">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/show"><i class="fas fa-search"></i></a>
                                </div>
                                @else
                                <div class="col-4">
                                    <a class="btn btn-primary btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/show"><i class="fas fa-search"></i></a>
                                </div>
                                @if(in_array('itenerary-request-edit', $_SESSION['sys_permissions']))
                                <div class="col-4">
                                    <a class="btn btn-success btn-sm" href="/hris/pages/employees/itineraryRequests/{{$itineraryRequest->id}}/edit"><i class="fas fa-edit"></i></a>
                                </div>
                                @endif
                                @if(in_array('itenerary-request-delete', $_SESSION['sys_permissions']))
                                <div class="col-4">
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$itineraryRequest->id}}" data-name="Itenerary request - {{$itineraryRequest->created_at}} from {{$itineraryRequest->employee->firstname}} {{$itineraryRequest->employee->lastname}}"><i class="fa fa-trash"></i></button>
                                </div>
                                @endif
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
    <div class="card-footer">
        {{$itineraryRequests->links()}}
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