@extends('adminlte::page')
@section('title', 'HRIS | Leave Entitlement')
@section('content_header')
<div class="row no-gutters">
    <div class="col-12 page-title">
        <h1><i class="fas fa-fw fa-users "></i> leave entitlements</h1>
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
        <h3 class="card-title">Leave Entitlements</h3>
    </div>
    <div class="card-body">
        <div class="row">
            @foreach($leave_groups_rules as $lgr)
            <div class="col-md-6">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">{{$lgr->name}} Chart</h3>
                    </div>
                    <div class="card-body">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas id="donutChart{{$lgr->id}}" style="min-height: 250px; height: 250px; max-height: 250px; max-width: 100%; display: block; width: 572px;" width="715" height="312" class="chartjs-render-monitor"></canvas>
                    </div>
                </div>
            </div>
            @endforeach

        </div>
    </div>
    <div class="card-footer">
    </div>
</div>
@stop
@section('css')
<link rel="stylesheet" href="{{ URL::asset('assets/css/admin_custom.css') }}">
@stop
@section('js')
@php

$emp_id = $_SESSION['sys_id'];
$leaveGroup_ids = App\hris_leave_group_employees::where('employee_id', $emp_id)->get('leave_group_id');

foreach ($leaveGroup_ids as $leaveGroup_id) {
$lg_id = $leaveGroup_id->leave_group_id;
$leave_groups_rules = App\hris_leave_rules::where('leave_group_id', $lg_id)->leftJoin('hris_leave_types', 'hris_leave_rules.leave_type_id', '=', 'hris_leave_types.id')->get();
}

foreach($leave_groups_rules as $leave_group_rule) {


if(!isset($leave_groups_rules)) {
echo 'No available Data. Add Employee to a Leave Group';
}else {

$approved_leave = App\hris_leaves::where('employee_id',$emp_id)->where('status',1)->where('leave_type_id',$leave_group_rule->leave_type_id)->get();
$approved_count = count($approved_leave);


$denied_leave = App\hris_leaves::where('employee_id', $emp_id)->where('status', 2)->where('leave_type_id', $leave_group_rule->leave_type_id)->get();
$denied_count = count($denied_leave);


$pending_leave = App\hris_leaves::where('employee_id', $emp_id)->where('status', 2)->where('leave_type_id', $leave_group_rule->leave_type_id)->get();
$pending_count = count($pending_leave);

$total_leave_used = $approved_count + $denied_count + $pending_count;
}





$total_leave = $leave_group_rule->default_per_year;
$total_unused = $total_leave - $total_leave_used;
echo $chart_var = '<script>
    var donutChartCanvas = $("#donutChart'.$leave_group_rule->id.'").get(0).getContext("2d")
    var donutData = {
        labels: [
            "Approved Leave Days: '.$approved_count.'",
            "Pending Leave Days: '.$pending_count.'",
            "Denied Leave Days: '.$denied_count.'",
            "Unused Leave Days: '.$total_unused.'",
        ],
        datasets: [{
            data: ['. $approved_count .', '. $pending_count .', '. $denied_count.', '. $total_unused .'],
            backgroundColor: ["#f56954", "#00a65a", "#f39c12", "#00c0ef", "#3c8dbc", "#d2d6de"],
        }]
    }
    var donutOptions = {
        maintainAspectRatio: false,
        responsive: true,
    }
    var donutChart = new Chart(donutChartCanvas, {
        type: "doughnut",
        data: donutData,
        options: donutOptions
    });
</script>';
}
@endphp
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