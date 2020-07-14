@extends('adminlte::page')
@section('title', 'HRIS | Work Shift Management')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> Work Shift Management</h1>
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
        <h3 class="card-title">Work Shift List</h3>
        <div class="card-tools">
            <a class="btn add-button btn-md" href="/hris/pages/time/workshiftManagement/create"><i class="fa fa-plus mr-1"></i> Create Work Shift</a>
        </div>
    </div>
    <div class="card-body">
        @if(count($work_shift) > 0)
        <div class="table-responsive">
            <table class="table table-hover table-bordered table-striped table-condensed">
                <thead>
                    <tr>
                        <th>Name</th>
                        <th>Monday</th>
                        <th>Tuesday</th>
                        <th>Wednesday</th>
                        <th>Thursday</th>
                        <th>Friday</th>
                        <th>Saturday</th>
                        <th>Sunday</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($work_shift as $shift)
                    @php
                    $monday_time_in = $shift->monday_time_in;
                    $monday_time_out = $shift->monday_time_out;
                    $tuesday_time_in = $shift->tuesday_time_in;
                    $tuesday_time_out = $shift->tuesday_time_out;
                    $wednesday_time_in = $shift->wednesday_time_in;
                    $wednesday_time_out = $shift->wednesday_time_out;
                    $thursday_time_in = $shift->thursday_time_in;
                    $thursday_time_out = $shift->thursday_time_out;
                    $friday_time_in = $shift->friday_time_in;
                    $friday_time_out = $shift->friday_time_out;
                    $saturday_time_in = $shift->saturday_time_in;
                    $saturday_time_out = $shift->saturday_time_out;
                    $sunday_time_in = $shift->sunday_time_in;
                    $sunday_time_out = $shift->sunday_time_out;

                    @endphp
                    <tr>
                        <td>{{$shift->workshift_name}}</td>
                        <td>
                            @if($monday_time_in == 0000 && $monday_time_out == 0000 )
                            -
                            @else
                            {{date('h:i a', strtotime($monday_time_in))}} - {{date('h:i a', strtotime($monday_time_out))}}
                            @endif
                        </td>
                        <td>
                            @if($tuesday_time_in == 0000 && $tuesday_time_out == 0000 )
                            -
                            @else
                            {{date('h:i a', strtotime($tuesday_time_in))}} - {{date('h:i a', strtotime($tuesday_time_out))}}
                            @endif
                        </td>
                        <td>
                            @if($wednesday_time_in == 0000 && $wednesday_time_out == 0000)
                            -
                            @else
                            {{date('h:i a', strtotime($wednesday_time_in))}} - {{date('h:i a', strtotime($wednesday_time_out))}}
                            @endif
                        </td>
                        <td>
                            @if($thursday_time_in == 0000 && $thursday_time_out == 0000)
                            -
                            @else
                            {{date('h:i a', strtotime($thursday_time_in))}} - {{date('h:i a', strtotime($thursday_time_out))}}
                            @endif
                        </td>
                        <td>
                            @if($friday_time_in == 0000 && $friday_time_out == 0000)
                            -
                            @else
                            {{date('h:i a', strtotime($friday_time_in))}} - {{date('h:i a', strtotime($friday_time_out))}}
                            @endif
                        </td>
                        <td>
                            @if($saturday_time_in == 0000 && $saturday_time_out == 0000)
                            -
                            @else
                            {{date('h:i a', strtotime($saturday_time_in))}} - {{date('h:i a', strtotime($saturday_time_out))}}
                            @endif
                        </td>
                        <td>
                            @if($sunday_time_in == 0000 && $sunday_time_out == 0000 )
                            -
                            @else {{date('h:i a', strtotime($sunday_time_in))}} - {{date('h:i a', strtotime($sunday_time_out))}}
                            @endif
                        </td>
                        <td class="td-action">
                            <div class="row no-gutters">
                                <div class="col-md-6">
                                    <a class="btn btn-success btn-sm" href="/hris/pages/time/workshiftManagement/{{$shift->id}}/edit"><i class="fas fa-edit"></i></a>
                                </div>
                                <div class="col-6">
                                    <!-- Button trigger modal -->
                                    <button class="btn btn-danger delete-btn btn-sm" type="button" data-toggle="modal" data-target="#modal-{{$shift->id}}" data-name="{{$shift->workshift_name}}"><i class="fa fa-trash"></i></button>
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
        {{$work_shift->links()}}
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