@extends('adminlte::page')
@section('title', 'HRIS | Daily Time Records')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-history "></i> Daily Time Records &raquo; {{$employee->employee_number}} <span>{{$employee->firstname}} {{$employee->middlename}} {{$employee->lastname}}</span></h1>
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
<div class="row">
    <div class="col-md-2">
        <div class="card">
            <div class="card-header">
                <h3 class="card-title">Month</h3>
            </div>
            <div class="card-body">

            </div>
        </div>
    </div>
    <div class="col-md-10">
        <div class="row mb-2">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daily Time Records: 1st Cutoff</h3>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-hover table-bordered table-striped table-condensed">
                                <thead>
                                    <tr>
                                        <th></th>
                                        <th></th>
                                        <th colspan="2" scope="colgroup">Attendance</th>
                                        <th colspan="3" scope="colgroup">Overtime</th>
                                        <th colspan="2" scope="colgroup">Leaves</th>
                                    </tr>
                                    <tr>
                                        <th>Date</th>
                                        <th>Day</th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>IN</th>
                                        <th>OUT</th>
                                        <th>REMARKS</th>
                                        <th>Leave Type</th>
                                        <th>Days</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach($employee_attendances as $attendance)
                                    <tr>
                                        <td>{{$attendance->created_at->format('M d, Y')}}</td>
                                        <td>{{$attendance->created_at->format('D')}}</td>
                                        <td>{{$attendance->created_at->format('H:i:s A')}}</td>
                                        <td>
                                            @if($attendance->time_out != NULL)
                                            {{date("h:i:sa", $attendance->time_out)}}
                                            @else
                                            -
                                            @endif
                                        </td>
                                        <td>lorem ipsum</td>
                                        <td>actions here</td>
                                        <td>lorem ipsum</td>
                                        <td>actions here</td>
                                        <td>lorem ipsum</td>
                                    </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Daily Time Records: 2nd Cutoff</h3>
                    </div>
                    <div class="card-body">

                    </div>
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

</script>
@stop