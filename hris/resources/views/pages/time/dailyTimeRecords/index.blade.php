@extends('adminlte::page')
@section('title', 'HRIS | Daily Time Records')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-history "></i> Daily Time Records &raquo; {{$employee->employee_number}}
            <span>{{$employee->firstname}} {{$employee->middlename}} {{$employee->lastname}}</span></h1>
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
                <div class="renderMonth">

                    <form>
                        @csrf
                        @php
                        // Start date
                        $start_date = '2020-07-01';

                        // End date
                        $end_date = date('Y-m',strtotime('+2 months'));

                        // current date
                        $current_date = date("M Y");

                        echo '<select name="month" class="monthDropdown form-control">';
                            while (strtotime($start_date) <= strtotime($end_date)) { echo $start_date; if(date("M Y", strtotime($start_date))==$current_date) { $selected="selected" ; } else { $selected="" ; } echo '<option value="' .date('Ym',strtotime($start_date)).'" '.$selected.'> '.date("M Y", strtotime($start_date)).'</option>';

                                $start_date = date("Y-m-d", strtotime("+1 month", strtotime($start_date)));
                                }
                                echo '</select>';
                        @endphp

                    </form>
                </div>
            </div>
        </div>
    </div>
    <div class="col-md-10">
        <div class="row">
            <div class="col-md-12">
                <div class="card">
                    <div class="card-header">
                        <!-- <h3 class="card-title">Hours: </h3> -->
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

                                <tbody id="dtr-table">

                                </tbody>
                            </table>
                        </div>
                    </div>
                    <div class="card-footer">
                        <h3 class="card-title">Total Hours: </h3>
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
    $(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{route('getDtr.fetch')}}",
            method: "GET",
            success: function(response) {
                $('#dtr-table').html(response);
            }
        });

    });

    $('.monthDropdown').on('change', function() {

        var monthValue = $(this).val();
        var _token = $('input[name="_token"]').val();
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
        $.ajax({
            url: "{{ route('getMonth.fetch')}}",
            method: "POST",
            data: {
                _token: _token,
                monthValue: monthValue,
            },
            success: function(response) {
                $('#dtr-table').html(response);
            }
        });
    });
</script>
@stop